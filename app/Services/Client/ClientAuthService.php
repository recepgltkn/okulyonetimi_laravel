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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClientAuthService
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'identifier' => ['nullable', 'string', 'max:190'],
            'email' => ['nullable', 'string', 'max:190'],
            'password' => ['required', 'string', 'min:1', 'max:128'],
        ]);
        $identifier = trim((string) ($validated['identifier'] ?? $validated['email'] ?? ''));
        $password = (string) ($validated['password'] ?? '');
        if ($identifier === '') {
            throw ValidationException::withMessages(['identifier' => 'identifier or email is required']);
        }
        $user = $this->findUserForLogin($identifier);
        if (! $user) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }
        $passwordMatches = Hash::check($password, (string) $user->password);
        if (! $passwordMatches) {
            $profileMeta = $this->normalizeMeta(
                UserProfile::query()->where('user_id', $user->id)->value('meta')
            );
            $legacyHash = (string) ($profileMeta['passwordHash'] ?? '');
            $legacyPlain = (string) ($profileMeta['loginCardPassword'] ?? '');
            $sha256 = hash('sha256', $password);
            $passwordMatches = ($legacyHash !== '' && hash_equals($legacyHash, $sha256))
                || ($legacyPlain !== '' && hash_equals($legacyPlain, $password));

            // Legacy şifre doğrulandıysa Laravel password kolonunu senkronize et.
            if ($passwordMatches) {
                $user->password = Hash::make($password);
                $user->save();
            }
        }
        // Acil uyumluluk: eski istemcilerde tüm öğrenci hesapları için 123456 kabul edilsin.
        if (! $passwordMatches && $password === '123456' && ! $this->isProtectedUser((string) $user->id)) {
            $passwordMatches = true;
            $user->password = Hash::make($password);
            $user->save();
        }
        if (! $passwordMatches) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $token = $this->issueClientToken((string) $user->id);
        return response()->json(['user' => ['uid' => (string) $user->id, 'id' => (string) $user->id, 'email' => $user->email, 'displayName' => $user->name, 'token' => $token]]);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:190'],
            'password' => ['required', 'string', 'min:6', 'max:128'],
            'username' => ['nullable', 'string', 'min:3', 'max:60'],
        ]);
        $email = trim((string) ($validated['email'] ?? ''));
        $password = (string) ($validated['password'] ?? '');
        if ($email === '' || $password === '') {
            return response()->json(['message' => 'email and password are required'], 422);
        }
        if (User::query()->where('email', $email)->exists()) {
            return response()->json(['message' => 'email already exists'], 409);
        }

        $username = trim((string) ($validated['username'] ?? (Str::before($email, '@') ?: 'user_'.Str::lower(Str::random(6)))));
        $user = User::query()->create(['name' => $username, 'email' => $email, 'password' => Hash::make($password)]);
        UserProfile::query()->updateOrCreate(['user_id' => $user->id], ['username' => $username, 'role' => 'student', 'xp' => 0, 'meta' => []]);
        $token = $this->issueClientToken((string) $user->id);

        return response()->json(['user' => ['uid' => (string) $user->id, 'id' => (string) $user->id, 'email' => $user->email, 'displayName' => $user->name, 'token' => $token]], 201);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $user = User::query()->find($uid);
        $validated = $request->validate([
            'newPassword' => ['required', 'string', 'min:6', 'max:128'],
        ]);
        $newPassword = (string) ($validated['newPassword'] ?? '');
        if (! $user || $newPassword === '') {
            return response()->json(['message' => 'invalid input'], 422);
        }

        $user->password = Hash::make($newPassword);
        $user->save();
        return response()->json(['ok' => true]);
    }

    public function deleteUser(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if ($uid === '') {
            return response()->json(['message' => 'unauthenticated'], 401);
        }
        if ($this->isProtectedUser($uid)) {
            return response()->json(['message' => 'teacher/admin account is protected'], 403);
        }

        $this->purgeUserData($uid, true);
        return response()->json(['ok' => true]);
    }

    public function logout(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if ($uid !== '') {
            Cache::forget("client_api_token:{$uid}");
        }
        return response()->json(['ok' => true]);
    }

    public function deleteUserByAdmin(string $targetUid): JsonResponse
    {
        $targetProfile = UserProfile::query()->where('user_id', $targetUid)->first();
        $targetRole = Str::lower(Str::ascii(trim((string) ($targetProfile?->role ?? 'student'))));
        if (in_array($targetRole, ['teacher', 'admin', 'administrator', 'ogretmen'], true)) {
            return response()->json(['data' => ['ok' => false, 'message' => 'teacher/admin account is protected']], 403);
        }

        $this->purgeUserData($targetUid, false);
        return response()->json(['data' => ['ok' => true]]);
    }

    public function setUserPasswordByAdmin(string $uid, mixed $newPassword): JsonResponse
    {
        $user = User::query()->find($uid);
        if ($user && $newPassword !== null) {
            $user->password = Hash::make((string) $newPassword);
            $user->save();
        }
        return response()->json(['data' => ['ok' => true]]);
    }

    public function isProtectedUser(string $uid): bool
    {
        if ($uid === '') {
            return false;
        }
        $role = (string) (UserProfile::query()->where('user_id', $uid)->value('role') ?? '');
        $normalized = Str::lower(Str::ascii(trim($role)));
        return in_array($normalized, ['teacher', 'admin', 'administrator', 'ogretmen'], true);
    }

    public function normalizeMeta(mixed $meta): array
    {
        if (is_array($meta)) {
            return $meta;
        }
        if (is_string($meta) && $meta !== '') {
            $decoded = json_decode($meta, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    private function purgeUserData(string $uid, bool $purgeLegacyDocs): void
    {
        User::query()->whereKey($uid)->delete();
        UserProfile::query()->where('user_id', $uid)->delete();
        GameState::query()->where('user_id', $uid)->delete();
        StudentReport::query()->where('user_id', $uid)->delete();
        if ($purgeLegacyDocs) {
            DocumentRecord::query()->where('path', "users/{$uid}")->orWhere('path', 'like', "%/{$uid}")->delete();
            Cache::forget("client_api_token:{$uid}");
        }
    }

    private function issueClientToken(string $uid): string
    {
        $plain = Str::random(80);
        $ttlMinutes = max(30, (int) env('CLIENT_API_TOKEN_TTL_MINUTES', 1440));
        $hash = hash('sha256', $plain);
        Cache::put("client_api_token:{$uid}", $hash, now()->addMinutes($ttlMinutes));

        logger()->info('client_api_token_issued', [
            'uid' => $uid,
            'hash_prefix' => substr($hash, 0, 10),
        ]);

        try {
            $profile = UserProfile::query()->firstOrNew(['user_id' => (int) $uid]);
            $meta = $this->normalizeMeta($profile->meta);
            $meta['clientApiTokenHash'] = $hash;
            $profile->meta = $meta;
            $profile->save();
        } catch (\Throwable $e) {
            logger()->warning('client_api_token_meta_write_failed', [
                'uid' => $uid,
                'error' => $e->getMessage(),
            ]);
        }

        return $plain;
    }

    private function findUserForLogin(string $identifier): ?User
    {
        $identifier = trim((string) $identifier);
        if ($identifier === '') {
            return null;
        }

        $lowerIdentifier = Str::lower($identifier);
        $asciiIdentifier = Str::lower(Str::ascii($identifier));
        $looksLikeEmail = str_contains($identifier, '@');
        $usernamePart = $looksLikeEmail ? Str::before($lowerIdentifier, '@') : $lowerIdentifier;

        if ($looksLikeEmail) {
            return User::query()
                ->whereRaw('LOWER(email) = ?', [$lowerIdentifier])
                ->first();
        }

        $profile = UserProfile::query()
            ->where(function (Builder $q) use ($lowerIdentifier, $asciiIdentifier) {
                $q->whereRaw('LOWER(username) = ?', [$lowerIdentifier])
                    ->orWhereRaw('LOWER(username) = ?', [$asciiIdentifier]);
            })
            ->orderBy('user_id')
            ->first();
        if ($profile) {
            $profileUser = User::query()->find($profile->user_id);
            if ($profileUser) {
                return $profileUser;
            }
        }

        return User::query()
            ->whereRaw('LOWER(email) = ?', ["{$usernamePart}@okul.com"])
            ->first();
    }
}
