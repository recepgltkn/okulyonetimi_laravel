<?php

namespace App\Services\Client;

use App\Models\DocumentRecord;
use App\Models\GameState;
use App\Models\StudentReport;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientDocumentService
{
    private const NATIVE = ['users', 'gameStates', 'studentReports'];

    public function setDoc(Request $request): JsonResponse
    {
        $doc = $this->upsertDoc((string) $request->input('path', ''), (array) $request->input('data', []), (bool) $request->input('merge', false));
        return response()->json(['doc' => $doc]);
    }

    public function updateDoc(Request $request): JsonResponse
    {
        $doc = $this->upsertDoc((string) $request->input('path', ''), (array) $request->input('data', []), true);
        return response()->json(['doc' => $doc]);
    }

    public function getDoc(Request $request): JsonResponse
    {
        $doc = $this->findDoc((string) $request->query('path', ''));
        return $doc ? response()->json(['exists' => true, 'doc' => $doc]) : response()->json(['exists' => false]);
    }

    public function deleteDoc(Request $request, ClientAuthService $authService): JsonResponse
    {
        $path = trim((string) $request->input('path', ''), '/');
        [$parent, $collection, $id] = $this->splitDocPath($path);
        if ($parent === null && in_array($collection, self::NATIVE, true)) {
            if ($collection === 'users') {
                if ($authService->isProtectedUser($id)) {
                    return response()->json(['message' => 'teacher/admin account is protected'], 403);
                }
                User::query()->whereKey($id)->delete();
                UserProfile::query()->where('user_id', $id)->delete();
            } elseif ($collection === 'gameStates') {
                GameState::query()->where('user_id', $id)->delete();
            } elseif ($collection === 'studentReports') {
                StudentReport::query()->where('user_id', $id)->delete();
            }
            return response()->json(['ok' => true]);
        }

        DocumentRecord::query()->where('path', $path)->delete();
        return response()->json(['ok' => true]);
    }

    public function addDoc(Request $request): JsonResponse
    {
        $collectionPath = trim((string) $request->input('collectionPath', ''), '/');
        $id = Str::lower(Str::random(20));
        $path = "{$collectionPath}/{$id}";
        $doc = $this->upsertDoc($path, (array) $request->input('data', []), false);
        return response()->json(['doc' => $doc], 201);
    }

    public function queryDocs(Request $request): JsonResponse
    {
        $source = (array) $request->input('source', []);
        $constraints = (array) $request->input('constraints', []);
        if (count($constraints) > 20) {
            return response()->json(['message' => 'too many constraints'], 422);
        }

        $type = (string) ($source['type'] ?? 'collection');
        if ($type === 'collectionGroup') {
            $name = (string) ($source['name'] ?? '');
            if (strlen($name) > 120) {
                return response()->json(['message' => 'invalid source'], 422);
            }
            $q = DocumentRecord::query()->where('collection_name', $name);
            $this->applyDocumentRecordConstraints($q, $constraints);
            $docs = $q->get()->map(fn ($d) => $this->docPayload($d))->values()->all();
            return response()->json(['docs' => $this->applyConstraints($docs, $constraints)]);
        }

        $collectionPath = trim((string) ($source['path'] ?? ''), '/');
        if (strlen($collectionPath) > 255) {
            return response()->json(['message' => 'invalid source'], 422);
        }

        [$parent, $collection] = $this->splitCollectionPath($collectionPath);
        if ($parent === null && $collection === 'users') {
            $q = User::query()
                ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->select(['users.*', 'user_profiles.role', 'user_profiles.xp', 'user_profiles.meta', 'user_profiles.total_time_seconds', 'user_profiles.class_name', 'user_profiles.section', 'user_profiles.selected_avatar_id']);
            $this->applyNativeUserConstraints($q, $constraints);
            $rows = $q->get();

            $docs = $rows->map(function ($r) {
                $meta = [];
                if (is_array($r->meta)) {
                    $meta = $r->meta;
                } elseif (is_string($r->meta) && $r->meta !== '') {
                    $decoded = json_decode($r->meta, true);
                    if (is_array($decoded)) {
                        $meta = $decoded;
                    }
                }

                $data = array_merge($meta, [
                    'username' => $r->name,
                    'email' => $r->email,
                    'role' => $r->role ?: 'student',
                    'xp' => (int) ($r->xp ?? 0),
                    'totalTimeSeconds' => (int) ($r->total_time_seconds ?? 0),
                    'class' => $r->class_name,
                    'section' => $r->section,
                    'selectedAvatarId' => $r->selected_avatar_id,
                    'createdAt' => optional($r->created_at)?->toIso8601String(),
                    'updatedAt' => optional($r->updated_at)?->toIso8601String(),
                ]);

                return ['id' => (string) $r->id, 'path' => "users/{$r->id}", 'parentPath' => null, 'collection' => 'users', 'data' => $data, 'createdAt' => optional($r->created_at)?->toIso8601String(), 'updatedAt' => optional($r->updated_at)?->toIso8601String()];
            })->values()->all();

            return response()->json(['docs' => $this->applyConstraints($docs, $constraints)]);
        }

        $q = DocumentRecord::query()->where('collection_name', $collection)->where('parent_path', $parent);
        $this->applyDocumentRecordConstraints($q, $constraints);
        $docs = $q->get()->map(fn ($d) => $this->docPayload($d))->values()->all();
        return response()->json(['docs' => $this->applyConstraints($docs, $constraints)]);
    }

    public function batch(Request $request): JsonResponse
    {
        $ops = (array) $request->input('ops', []);
        if (count($ops) > 500) {
            return response()->json(['message' => 'too many operations'], 422);
        }

        foreach ($ops as $op) {
            $kind = (string) ($op['kind'] ?? '');
            if ($kind === 'set') {
                $this->upsertDoc((string) ($op['path'] ?? ''), (array) ($op['data'] ?? []), (bool) ($op['merge'] ?? false));
            }
            if ($kind === 'update') {
                $this->upsertDoc((string) ($op['path'] ?? ''), (array) ($op['data'] ?? []), true);
            }
            if ($kind === 'delete') {
                DocumentRecord::query()->where('path', trim((string) ($op['path'] ?? ''), '/'))->delete();
            }
        }

        return response()->json(['ok' => true]);
    }

    private function upsertDoc(string $rawPath, array $data, bool $merge): array
    {
        $path = trim($rawPath, '/');
        [$parent, $collection, $id] = $this->splitDocPath($path);
        if ($parent === null && in_array($collection, self::NATIVE, true)) {
            if ($collection === 'users') {
                return $this->upsertNativeUser($id, $data, $merge);
            }
            if ($collection === 'gameStates') {
                return $this->upsertNativeGameState($id, $data, $merge);
            }
            if ($collection === 'studentReports') {
                return $this->upsertNativeStudentReport($id, $data, $merge);
            }
        }

        $doc = DocumentRecord::query()->where('path', $path)->first();
        $base = (array) ($doc?->payload ?? []);
        $payload = $merge ? $this->normalizePayload($data, $base) : $this->normalizePayload($data, []);
        if (! $doc) {
            $doc = new DocumentRecord(['path' => $path, 'parent_path' => $parent, 'collection_name' => $collection, 'document_id' => $id]);
        }
        $doc->payload = $payload;
        $doc->save();

        return $this->docPayload($doc);
    }

    private function findDoc(string $rawPath): ?array
    {
        $path = trim($rawPath, '/');
        [$parent, $collection, $id] = $this->splitDocPath($path);
        if ($parent === null && in_array($collection, self::NATIVE, true)) {
            if ($collection === 'users') {
                return $this->findNativeUser($id);
            }
            if ($collection === 'gameStates') {
                return $this->findNativeGameState($id);
            }
            if ($collection === 'studentReports') {
                return $this->findNativeStudentReport($id);
            }
        }

        $doc = DocumentRecord::query()->where('path', $path)->first();
        return $doc ? $this->docPayload($doc) : null;
    }

    private function upsertNativeUser(string $id, array $data, bool $merge): array
    {
        $user = User::query()->find($id) ?: new User(['id' => (int) $id, 'email' => (string) ($data['email'] ?? "user_{$id}@local.test"), 'password' => Hash::make((string) ($data['password'] ?? Str::random(16)))]);
        $profile = UserProfile::query()->firstOrNew(['user_id' => (int) $id]);
        $base = $this->nativeUserData($user, $profile);
        $payload = $merge ? $this->normalizePayload($data, $base) : $this->normalizePayload($data, []);

        $user->name = (string) ($payload['username'] ?? $payload['name'] ?? $user->name ?? "user_{$id}");
        if (isset($payload['email'])) {
            $user->email = (string) $payload['email'];
        }
        if (isset($payload['password']) && (string) $payload['password'] !== '') {
            $user->password = Hash::make((string) $payload['password']);
        }
        $user->save();

        $profile->username = (string) ($payload['username'] ?? $user->name);
        $profile->role = (string) ($payload['role'] ?? $profile->role ?? 'student');
        $profile->xp = (int) ($payload['xp'] ?? 0);
        $profile->total_time_seconds = (int) ($payload['totalTimeSeconds'] ?? 0);
        $profile->class_name = isset($payload['class']) ? (string) $payload['class'] : $profile->class_name;
        $profile->section = isset($payload['section']) ? (string) $payload['section'] : $profile->section;
        $profile->selected_avatar_id = isset($payload['selectedAvatarId']) ? (string) $payload['selectedAvatarId'] : $profile->selected_avatar_id;
        $profile->meta = $this->extractMeta($payload, ['username', 'name', 'email', 'password', 'role', 'xp', 'totalTimeSeconds', 'class', 'section', 'selectedAvatarId', 'createdAt', 'updatedAt']);
        $profile->save();

        return $this->findNativeUser((string) $user->id);
    }

    private function findNativeUser(string $id): ?array
    {
        $user = User::query()->find($id);
        if (! $user) {
            return null;
        }

        $profile = UserProfile::query()->firstOrCreate(['user_id' => $user->id], ['username' => $user->name, 'role' => 'student', 'xp' => 0, 'meta' => []]);
        $data = $this->nativeUserData($user, $profile);

        return ['id' => (string) $user->id, 'path' => "users/{$user->id}", 'parentPath' => null, 'collection' => 'users', 'data' => $data, 'createdAt' => optional($user->created_at)?->toIso8601String(), 'updatedAt' => optional($user->updated_at)?->toIso8601String()];
    }

    private function upsertNativeGameState(string $id, array $data, bool $merge): array
    {
        $row = GameState::query()->firstOrNew(['user_id' => (int) $id]);
        $base = (array) ($row->payload ?? []);
        $row->payload = $merge ? $this->normalizePayload($data, $base) : $this->normalizePayload($data, []);
        $row->save();
        return $this->findNativeGameState($id);
    }

    private function findNativeGameState(string $id): ?array
    {
        $row = GameState::query()->where('user_id', $id)->first();
        if (! $row) {
            return null;
        }

        return ['id' => (string) $id, 'path' => "gameStates/{$id}", 'parentPath' => null, 'collection' => 'gameStates', 'data' => (array) ($row->payload ?? []), 'createdAt' => optional($row->created_at)?->toIso8601String(), 'updatedAt' => optional($row->updated_at)?->toIso8601String()];
    }

    private function upsertNativeStudentReport(string $id, array $data, bool $merge): array
    {
        $row = StudentReport::query()->firstOrNew(['user_id' => (int) $id]);
        $base = $this->nativeStudentReportData($row);
        $payload = $merge ? $this->normalizePayload($data, $base) : $this->normalizePayload($data, []);

        $row->total_xp = (int) ($payload['totalXP'] ?? $payload['xp'] ?? 0);
        $row->total_duration_ms = (int) ($payload['totalDurationMs'] ?? 0);
        $row->completion_percent = (float) ($payload['completionPercent'] ?? 0);
        $row->meta = $this->extractMeta($payload, ['totalXP', 'xp', 'totalDurationMs', 'completionPercent', 'createdAt', 'updatedAt']);
        $row->save();

        return $this->findNativeStudentReport($id);
    }

    private function findNativeStudentReport(string $id): ?array
    {
        $row = StudentReport::query()->where('user_id', $id)->first();
        if (! $row) {
            return null;
        }

        return ['id' => (string) $id, 'path' => "studentReports/{$id}", 'parentPath' => null, 'collection' => 'studentReports', 'data' => $this->nativeStudentReportData($row), 'createdAt' => optional($row->created_at)?->toIso8601String(), 'updatedAt' => optional($row->updated_at)?->toIso8601String()];
    }

    private function nativeUserData(User $user, UserProfile $profile): array
    {
        return array_merge((array) ($profile->meta ?? []), [
            'username' => (string) ($profile->username ?: $user->name),
            'email' => (string) $user->email,
            'role' => (string) ($profile->role ?: 'student'),
            'xp' => (int) ($profile->xp ?? 0),
            'totalTimeSeconds' => (int) ($profile->total_time_seconds ?? 0),
            'class' => $profile->class_name,
            'section' => $profile->section,
            'selectedAvatarId' => $profile->selected_avatar_id,
            'createdAt' => optional($user->created_at)?->toIso8601String(),
            'updatedAt' => optional($user->updated_at)?->toIso8601String(),
        ]);
    }

    private function nativeStudentReportData(StudentReport $row): array
    {
        return array_merge((array) ($row->meta ?? []), [
            'totalXP' => (int) ($row->total_xp ?? 0),
            'totalDurationMs' => (int) ($row->total_duration_ms ?? 0),
            'completionPercent' => (float) ($row->completion_percent ?? 0),
            'createdAt' => optional($row->created_at)?->toIso8601String(),
            'updatedAt' => optional($row->updated_at)?->toIso8601String(),
        ]);
    }

    private function normalizePayload(array $incoming, array $base): array
    {
        foreach ($incoming as $k => $v) {
            if (is_array($v) && (($v['__op'] ?? null) === 'increment')) {
                $base[$k] = (float) ($base[$k] ?? 0) + (float) ($v['by'] ?? 0);
            } elseif (is_array($v) && (($v['__op'] ?? null) === 'serverTimestamp')) {
                $base[$k] = now()->toIso8601String();
            } else {
                $base[$k] = $v;
            }
        }
        return $base;
    }

    private function docPayload(DocumentRecord $doc): array
    {
        return ['id' => (string) $doc->document_id, 'path' => (string) $doc->path, 'parentPath' => $doc->parent_path, 'collection' => (string) $doc->collection_name, 'data' => (array) ($doc->payload ?? []), 'createdAt' => optional($doc->created_at)?->toIso8601String(), 'updatedAt' => optional($doc->updated_at)?->toIso8601String()];
    }

    private function splitCollectionPath(string $path): array
    {
        $parts = array_values(array_filter(explode('/', trim($path, '/')), fn ($x) => $x !== ''));
        $collection = (string) end($parts);
        $parent = count($parts) > 1 ? implode('/', array_slice($parts, 0, -1)) : null;
        return [$parent, $collection];
    }

    private function splitDocPath(string $path): array
    {
        $parts = array_values(array_filter(explode('/', trim($path, '/')), fn ($x) => $x !== ''));
        $id = (string) end($parts);
        $collection = count($parts) > 1 ? (string) $parts[count($parts) - 2] : '';
        $parent = count($parts) > 2 ? implode('/', array_slice($parts, 0, -2)) : null;
        return [$parent, $collection, $id];
    }

    private function applyDocumentRecordConstraints(Builder $query, array $constraints): void
    {
        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'where') {
                continue;
            }
            $field = (string) ($c['field'] ?? '');
            $op = (string) ($c['op'] ?? '==');
            $value = $c['value'] ?? null;
            if ($field === '') {
                continue;
            }
            $column = $this->mapDocumentRecordField($field);
            if (! $column) {
                continue;
            }
            $this->applyWhereConstraint($query, $column, $op, $value);
        }

        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'orderBy') {
                continue;
            }
            $field = (string) ($c['field'] ?? '');
            if ($field === '') {
                continue;
            }
            $column = $this->mapDocumentRecordField($field);
            if (! $column) {
                continue;
            }
            $dir = strtolower((string) ($c['direction'] ?? 'asc')) === 'desc' ? 'desc' : 'asc';
            $query->orderBy($column, $dir);
        }

        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'limit') {
                continue;
            }
            $count = (int) ($c['count'] ?? 0);
            if ($count > 0) {
                $query->limit($count);
            }
        }
    }

    private function applyNativeUserConstraints(Builder $query, array $constraints): void
    {
        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'where') {
                continue;
            }
            $field = (string) ($c['field'] ?? '');
            $op = (string) ($c['op'] ?? '==');
            $value = $c['value'] ?? null;
            if ($field === '') {
                continue;
            }
            $column = $this->mapNativeUserField($field);
            if (! $column) {
                continue;
            }
            $this->applyWhereConstraint($query, $column, $op, $value);
        }

        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'orderBy') {
                continue;
            }
            $field = (string) ($c['field'] ?? '');
            if ($field === '') {
                continue;
            }
            $column = $this->mapNativeUserField($field);
            if (! $column) {
                continue;
            }
            $dir = strtolower((string) ($c['direction'] ?? 'asc')) === 'desc' ? 'desc' : 'asc';
            $query->orderBy($column, $dir);
        }

        foreach ($constraints as $c) {
            if (($c['type'] ?? '') !== 'limit') {
                continue;
            }
            $count = (int) ($c['count'] ?? 0);
            if ($count > 0) {
                $query->limit($count);
            }
        }
    }

    private function mapDocumentRecordField(string $field): ?string
    {
        $plain = trim($field);
        if ($plain === 'id' || $plain === 'document_id') return 'document_id';
        if ($plain === 'path') return 'path';
        if ($plain === 'parentPath' || $plain === 'parent_path') return 'parent_path';
        if ($plain === 'collection' || $plain === 'collection_name') return 'collection_name';
        if ($plain === 'createdAt' || $plain === 'created_at') return 'created_at';
        if ($plain === 'updatedAt' || $plain === 'updated_at') return 'updated_at';
        $payloadField = str_replace('.', '->', $plain);
        return "payload->{$payloadField}";
    }

    private function mapNativeUserField(string $field): ?string
    {
        $plain = trim($field);
        return match ($plain) {
            'id', 'uid' => 'users.id',
            'username', 'name' => 'users.name',
            'email' => 'users.email',
            'role' => 'user_profiles.role',
            'xp' => 'user_profiles.xp',
            'totalTimeSeconds' => 'user_profiles.total_time_seconds',
            'class', 'className' => 'user_profiles.class_name',
            'section' => 'user_profiles.section',
            'selectedAvatarId' => 'user_profiles.selected_avatar_id',
            'createdAt', 'created_at' => 'users.created_at',
            'updatedAt', 'updated_at' => 'users.updated_at',
            default => null,
        };
    }

    private function applyWhereConstraint(Builder $query, string $column, string $op, mixed $value): void
    {
        if ($op === 'in' && is_array($value)) {
            $query->whereIn($column, $value);
            return;
        }
        if ($op === '==') {
            $query->where($column, '=', $value);
            return;
        }
        if ($op === '!=') {
            $query->where($column, '!=', $value);
            return;
        }
        if (in_array($op, ['>', '>=', '<', '<='], true)) {
            $query->where($column, $op, $value);
        }
    }

    private function applyConstraints(array $docs, array $constraints): array
    {
        $limit = null;
        foreach ($constraints as $c) {
            if (($c['type'] ?? '') === 'where') {
                $f = (string) ($c['field'] ?? '');
                $op = (string) ($c['op'] ?? '==');
                $val = $c['value'] ?? null;
                $docs = array_values(array_filter($docs, function ($d) use ($f, $op, $val) {
                    $v = data_get($d['data'] ?? [], $f);
                    if ($op === '==') return $v == $val;
                    if ($op === 'in' && is_array($val)) return in_array($v, $val, true);
                    if ($op === '!=') return $v != $val;
                    if ($op === '>') return $v > $val;
                    if ($op === '>=') return $v >= $val;
                    if ($op === '<') return $v < $val;
                    if ($op === '<=') return $v <= $val;
                    return false;
                }));
            }
        }

        foreach (array_reverse($constraints) as $c) {
            if (($c['type'] ?? '') === 'orderBy') {
                $f = (string) ($c['field'] ?? '');
                $dir = strtolower((string) ($c['direction'] ?? 'asc'));
                usort($docs, function ($a, $b) use ($f, $dir) {
                    $cmp = (data_get($a['data'] ?? [], $f) <=> data_get($b['data'] ?? [], $f));
                    return $dir === 'desc' ? -$cmp : $cmp;
                });
            }
            if (($c['type'] ?? '') === 'limit') {
                $limit = (int) ($c['count'] ?? 0);
            }
        }

        return ($limit && $limit > 0) ? array_slice($docs, 0, $limit) : $docs;
    }

    private function extractMeta(array $payload, array $reserved): array
    {
        $out = [];
        foreach ($payload as $k => $v) {
            if (! in_array((string) $k, $reserved, true)) {
                $out[$k] = $v;
            }
        }
        return $out;
    }
}
