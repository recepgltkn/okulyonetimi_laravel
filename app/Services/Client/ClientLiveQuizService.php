<?php

namespace App\Services\Client;

use App\Models\DocumentRecord;
use App\Models\LiveQuiz;
use App\Models\LiveQuizAnswer;
use App\Models\LiveQuizSession;
use App\Models\StudentReport;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientLiveQuizService
{
    public function createQuiz(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if (! $this->isTeacher($uid)) return response()->json(['message' => 'forbidden'], 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'targetClass' => ['nullable', 'string', 'max:64'],
            'targetSection' => ['nullable', 'string', 'max:64'],
            'questions' => ['required', 'array', 'min:1', 'max:80'],
        ]);

        $quiz = LiveQuiz::query()->create([
            'teacher_id' => $uid,
            'title' => trim((string) $validated['title']),
            'target_class' => trim((string) ($validated['targetClass'] ?? '')) ?: null,
            'target_section' => trim((string) ($validated['targetSection'] ?? '')) ?: null,
            'status' => 'active',
            'payload' => [
                'questions' => array_values((array) $validated['questions']),
                'version' => 3,
            ],
        ]);

        return response()->json(['quiz' => $this->quizPayload($quiz)], 201);
    }

    public function updateQuiz(Request $request, string $quizId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if (! $this->isTeacher($uid)) return response()->json(['message' => 'forbidden'], 403);

        $quiz = LiveQuiz::query()->where('id', $quizId)->where('teacher_id', $uid)->first();
        if (! $quiz) return response()->json(['message' => 'quiz not found'], 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'targetClass' => ['nullable', 'string', 'max:64'],
            'targetSection' => ['nullable', 'string', 'max:64'],
            'questions' => ['required', 'array', 'min:1', 'max:80'],
        ]);

        $payload = (array) ($quiz->payload ?? []);
        $payload['questions'] = array_values((array) $validated['questions']);
        $payload['version'] = 3;

        $quiz->title = trim((string) $validated['title']);
        $quiz->target_class = trim((string) ($validated['targetClass'] ?? '')) ?: null;
        $quiz->target_section = trim((string) ($validated['targetSection'] ?? '')) ?: null;
        $quiz->status = 'active';
        $quiz->payload = $payload;
        $quiz->save();

        return response()->json(['quiz' => $this->quizPayload($quiz)]);
    }

    public function deleteQuiz(Request $request, string $quizId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if (! $this->isTeacher($uid)) return response()->json(['message' => 'forbidden'], 403);

        $quiz = LiveQuiz::query()->where('id', $quizId)->where('teacher_id', $uid)->first();
        if (! $quiz) return response()->json(['message' => 'quiz not found'], 404);

        $quiz->status = 'deleted';
        $quiz->save();

        return response()->json(['ok' => true]);
    }

    public function listMyQuizzes(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $rows = LiveQuiz::query()->where('teacher_id', $uid)->where('status', '!=', 'deleted')->latest()->limit(100)->get();
        return response()->json(['quizzes' => $rows->map(fn ($q) => $this->quizPayload($q))->values()]);
    }

    public function startSession(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        if (! $this->isTeacher($uid)) return response()->json(['message' => 'forbidden'], 403);

        $validated = $request->validate([
            'quizId' => ['required'],
            'questionDurationSec' => ['nullable', 'integer', 'min:5', 'max:300'],
        ]);

        $quiz = LiveQuiz::query()->where('id', (string) $validated['quizId'])->where('teacher_id', $uid)->first();
        if (! $quiz) return response()->json(['message' => 'quiz not found'], 404);

        $questions = array_values((array) (($quiz->payload ?? [])['questions'] ?? []));
        $first = (array) ($questions[0] ?? []);
        $durationSec = max(5, (int) ($validated['questionDurationSec'] ?? ($first['durationSec'] ?? 30)));

        $session = LiveQuizSession::query()->create([
            'live_quiz_id' => (string) $quiz->id,
            'teacher_id' => $uid,
            'quiz_title' => (string) $quiz->title,
            'status' => 'live',
            'current_index' => 0,
            'target_class' => $quiz->target_class,
            'target_section' => $quiz->target_section,
            'payload' => [
                'joinCode' => strtoupper(Str::random(6)),
                'isLocked' => false,
                'endsAtMs' => (int) floor(microtime(true) * 1000) + ($durationSec * 1000),
                'questionDurationSec' => $durationSec,
                'questions' => $questions,
                'startedAtMs' => (int) floor(microtime(true) * 1000),
            ],
        ]);

        return response()->json(['session' => $this->sessionPayload($session, false)], 201);
    }

    public function getSession(Request $request, string $sessionId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session) return response()->json(['message' => 'session not found'], 404);
        $isTeacher = ((string) $session->teacher_id === $uid);
        return response()->json(['session' => $this->sessionPayload($session, ! $isTeacher)]);
    }

    public function getActiveTeacherSession(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $session = LiveQuizSession::query()
            ->where('teacher_id', $uid)
            ->where('status', 'live')
            ->orderByDesc('id')
            ->first();

        return response()->json(['session' => $session ? $this->sessionPayload($session, false) : null]);
    }

    public function getActiveStudentSession(Request $request): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $profile = UserProfile::query()->where('user_id', (int) $uid)->first();
        $className = (string) ($profile?->class_name ?? '');
        $section = (string) ($profile?->section ?? '');

        $rows = LiveQuizSession::query()->where('status', 'live')->orderByDesc('id')->limit(30)->get();
        $session = $rows->first(function (LiveQuizSession $s) use ($className, $section) {
            $targetClass = (string) ($s->target_class ?? '');
            $targetSection = (string) ($s->target_section ?? '');
            if ($targetClass !== '' && $targetClass !== $className) return false;
            if ($targetSection !== '' && $targetSection !== $section) return false;
            return true;
        });

        return response()->json(['session' => $session ? $this->sessionPayload($session, true) : null]);
    }

    public function submitAnswer(Request $request, string $sessionId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $validated = $request->validate([
            'questionIndex' => ['required', 'integer', 'min:0', 'max:1000'],
            'choice' => ['nullable'],
            'responseMs' => ['nullable', 'integer', 'min:0', 'max:600000'],
        ]);

        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session || $session->status !== 'live') return response()->json(['message' => 'session is not live'], 422);

        $payload = (array) ($session->payload ?? []);
        if (! empty($payload['isLocked'])) return response()->json(['message' => 'question locked'], 409);
        if ((int) ($payload['endsAtMs'] ?? 0) > 0 && (int) floor(microtime(true) * 1000) > (int) $payload['endsAtMs']) {
            return response()->json(['message' => 'time is over'], 409);
        }

        $questions = array_values((array) ($payload['questions'] ?? []));
        $qIndex = (int) $validated['questionIndex'];
        $question = (array) ($questions[$qIndex] ?? []);
        if (! $question) return response()->json(['message' => 'question not found'], 404);

        $existing = LiveQuizAnswer::query()
            ->where('session_id', (string) $sessionId)
            ->where('user_id', (int) $uid)
            ->where('question_index', $qIndex)
            ->first();
        if ($existing) return response()->json(['message' => 'already answered'], 409);

        $choice = $validated['choice'];
        $isCorrect = $this->isChoiceCorrect($question, $choice);
        $xpAward = $isCorrect ? $this->questionXp($question) : 0;

        DB::transaction(function () use ($sessionId, $uid, $qIndex, $choice, $isCorrect, $validated, $xpAward) {
            LiveQuizAnswer::query()->create([
                'session_id' => (string) $sessionId,
                'user_id' => (int) $uid,
                'question_index' => $qIndex,
                'choice' => is_scalar($choice) ? Str::upper(trim((string) $choice)) : json_encode($choice, JSON_UNESCAPED_UNICODE),
                'is_correct' => $isCorrect,
                'response_ms' => (int) ($validated['responseMs'] ?? 0),
                'answered_at_ms' => (int) floor(microtime(true) * 1000),
            ]);
            if ($xpAward > 0) {
                UserProfile::query()->where('user_id', (int) $uid)->increment('xp', $xpAward);
            }
        });

        return response()->json(['ok' => true, 'isCorrect' => $isCorrect, 'xp' => $xpAward]);
    }

    public function lockQuestion(Request $request, string $sessionId): JsonResponse { return $this->setLock($request, $sessionId, true); }
    public function unlockQuestion(Request $request, string $sessionId): JsonResponse { return $this->setLock($request, $sessionId, false); }

    public function nextQuestion(Request $request, string $sessionId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session || (string) $session->teacher_id !== $uid) return response()->json(['message' => 'forbidden'], 403);

        $payload = (array) ($session->payload ?? []);
        $questions = array_values((array) ($payload['questions'] ?? []));
        $next = ((int) $session->current_index) + 1;

        if ($next >= count($questions)) {
            $session->status = 'finished';
            $payload['isLocked'] = true;
            $payload['finishedAtMs'] = (int) floor(microtime(true) * 1000);
            $session->payload = $payload;
            $session->save();
            $this->persistSessionReports($session, 'questions-completed');
            return response()->json(['ok' => true, 'finished' => true]);
        }

        $q = (array) ($questions[$next] ?? []);
        $durationSec = max(5, (int) ($q['durationSec'] ?? ($payload['questionDurationSec'] ?? 30)));
        $session->current_index = $next;
        $payload['isLocked'] = false;
        $payload['endsAtMs'] = (int) floor(microtime(true) * 1000) + ($durationSec * 1000);
        $session->payload = $payload;
        $session->save();

        return response()->json(['ok' => true, 'currentIndex' => $next, 'endsAtMs' => (int) $payload['endsAtMs']]);
    }

    public function finishSession(Request $request, string $sessionId): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session || (string) $session->teacher_id !== $uid) return response()->json(['message' => 'forbidden'], 403);

        $payload = (array) ($session->payload ?? []);
        $payload['isLocked'] = true;
        $payload['finishedAtMs'] = (int) floor(microtime(true) * 1000);
        $session->status = 'finished';
        $session->payload = $payload;
        $session->save();

        $this->persistSessionReports($session, 'manual');
        return response()->json(['ok' => true]);
    }

    public function leaderboard(Request $request, string $sessionId): JsonResponse
    {
        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session) return response()->json(['rows' => []]);

        $rows = $this->buildLeaderboardRows($session);
        return response()->json(['rows' => $rows]);
    }

    private function setLock(Request $request, string $sessionId, bool $locked): JsonResponse
    {
        $uid = (string) $request->attributes->get('client_uid', '');
        $session = LiveQuizSession::query()->find($sessionId);
        if (! $session || (string) $session->teacher_id !== $uid) return response()->json(['message' => 'forbidden'], 403);

        $payload = (array) ($session->payload ?? []);
        $payload['isLocked'] = $locked;
        $session->payload = $payload;
        $session->save();
        return response()->json(['ok' => true, 'isLocked' => $locked]);
    }

    private function isTeacher(string $uid): bool
    {
        $role = (string) (UserProfile::query()->where('user_id', $uid)->value('role') ?? '');
        $r = Str::lower(Str::ascii(trim($role)));
        return in_array($r, ['teacher', 'admin', 'administrator', 'ogretmen'], true);
    }

    private function quizPayload(LiveQuiz $quiz): array
    {
        $payload = (array) ($quiz->payload ?? []);
        $questions = array_values((array) ($payload['questions'] ?? []));
        return [
            'id' => (string) $quiz->id,
            'title' => (string) $quiz->title,
            'targetClass' => $quiz->target_class,
            'targetSection' => $quiz->target_section,
            'questionsCount' => count($questions),
            'questions' => $questions,
            'createdAt' => optional($quiz->created_at)?->toIso8601String(),
            'updatedAt' => optional($quiz->updated_at)?->toIso8601String(),
        ];
    }

    private function sessionPayload(LiveQuizSession $session, bool $hideCorrect): array
    {
        $payload = (array) ($session->payload ?? []);
        $questions = array_values((array) ($payload['questions'] ?? []));
        if ($hideCorrect) {
            $questions = array_map(function ($q) {
                if (is_array($q)) unset($q['correct']);
                return $q;
            }, $questions);
        }
        return [
            'id' => (string) $session->id,
            'quizId' => (string) $session->live_quiz_id,
            'quizTitle' => (string) $session->quiz_title,
            'teacherId' => (string) $session->teacher_id,
            'joinCode' => (string) ($payload['joinCode'] ?? ''),
            'status' => (string) $session->status,
            'currentIndex' => (int) $session->current_index,
            'isLocked' => (bool) ($payload['isLocked'] ?? false),
            'endsAtMs' => (int) ($payload['endsAtMs'] ?? 0),
            'questions' => $questions,
            'startedAtMs' => (int) ($payload['startedAtMs'] ?? 0),
            'finishedAtMs' => (int) ($payload['finishedAtMs'] ?? 0),
            'targetClass' => $session->target_class,
            'targetSection' => $session->target_section,
        ];
    }

    private function questionXp(array $question): int
    {
        $base = max(0, (int) ($question['xp'] ?? 10));
        return !empty($question['doubleXp']) ? ($base * 2) : $base;
    }

    private function normalizeTf(string $v): string
    {
        $x = Str::lower(Str::ascii(trim($v)));
        if (in_array($x, ['dogru', 'true', '1', 'd'], true)) return 'dogru';
        return 'yanlis';
    }

    private function isChoiceCorrect(array $question, mixed $choice): bool
    {
        $type = Str::lower((string) ($question['type'] ?? 'multiple'));
        if ($type === 'truefalse') {
            return $this->normalizeTf((string) ($choice ?? '')) === $this->normalizeTf((string) ($question['correct'] ?? ''));
        }
        if ($type === 'matching') {
            $pairs = array_values((array) ($question['pairs'] ?? []));
            $incoming = is_array($choice) ? $choice : json_decode((string) $choice, true);
            if (!is_array($incoming) || empty($pairs)) return false;
            foreach ($pairs as $p) {
                $left = (string) ($p['left'] ?? '');
                $right = (string) ($p['right'] ?? '');
                if ($left === '' || $right === '') return false;
                if ((string) ($incoming[$left] ?? '') !== $right) return false;
            }
            return true;
        }
        $selected = Str::upper(trim((string) $choice));
        $correct = Str::upper(trim((string) ($question['correct'] ?? '')));
        return $selected !== '' && $selected === $correct;
    }

    private function buildLeaderboardRows(LiveQuizSession $session): array
    {
        $payload = (array) ($session->payload ?? []);
        $questions = array_values((array) ($payload['questions'] ?? []));

        $answers = LiveQuizAnswer::query()
            ->where('session_id', (string) $session->id)
            ->orderBy('answered_at_ms')
            ->get();

        $byUser = [];
        foreach ($answers as $a) {
            $uid = (string) $a->user_id;
            if (!isset($byUser[$uid])) {
                $byUser[$uid] = [
                    'userId' => $uid,
                    'answered' => 0,
                    'correct' => 0,
                    'wrong' => 0,
                    'xp' => 0,
                    'totalMs' => 0,
                ];
            }
            $row = &$byUser[$uid];
            $row['answered'] += 1;
            $row['correct'] += $a->is_correct ? 1 : 0;
            $row['wrong'] += $a->is_correct ? 0 : 1;
            $row['totalMs'] += max(0, (int) $a->response_ms);
            $question = (array) ($questions[(int) $a->question_index] ?? []);
            if ($a->is_correct) {
                $row['xp'] += $this->questionXp($question);
            }
        }

        $profiles = UserProfile::query()->whereIn('user_id', array_map('intval', array_keys($byUser)))->get()->keyBy(fn($p) => (string) $p->user_id);

        $rows = array_map(function (array $row) use ($profiles) {
            $profile = $profiles[(string) $row['userId']] ?? null;
            $name = (string) ($profile?->username ?? "user_{$row['userId']}");
            $answered = max(0, (int) $row['answered']);
            $correct = max(0, (int) $row['correct']);
            $wrong = max(0, (int) $row['wrong']);
            $rate = $answered > 0 ? (int) round(($correct / $answered) * 100) : 0;
            return [
                'userId' => (string) $row['userId'],
                'username' => $name,
                'name' => $name,
                'studentName' => $name,
                'answered' => $answered,
                'correct' => $correct,
                'wrong' => $wrong,
                'xp' => max(0, (int) $row['xp']),
                'xpEarned' => max(0, (int) $row['xp']),
                'totalMs' => max(0, (int) $row['totalMs']),
                'durationMs' => max(0, (int) $row['totalMs']),
                'successRate' => $rate,
            ];
        }, array_values($byUser));

        usort($rows, function (array $a, array $b) {
            $xp = (int) ($b['xp'] ?? 0) <=> (int) ($a['xp'] ?? 0);
            if ($xp !== 0) return $xp;
            $rate = (int) ($b['successRate'] ?? 0) <=> (int) ($a['successRate'] ?? 0);
            if ($rate !== 0) return $rate;
            return (int) ($a['totalMs'] ?? 0) <=> (int) ($b['totalMs'] ?? 0);
        });

        return array_values($rows);
    }

    private function persistSessionReports(LiveQuizSession $session, string $finishReason): void
    {
        $rows = $this->buildLeaderboardRows($session);
        if (empty($rows)) return;

        $payload = (array) ($session->payload ?? []);
        $startedAtMs = (int) ($payload['startedAtMs'] ?? 0);
        $finishedAtMs = (int) ($payload['finishedAtMs'] ?? floor(microtime(true) * 1000));
        $totalQuestions = count((array) ($payload['questions'] ?? []));

        foreach ($rows as $r) {
            $uid = (string) ($r['userId'] ?? '');
            if ($uid === '') continue;

            $item = [
                'sessionId' => (string) $session->id,
                'quizId' => (string) $session->live_quiz_id,
                'quizTitle' => (string) $session->quiz_title,
                'teacherId' => (string) $session->teacher_id,
                'userId' => $uid,
                'studentName' => (string) ($r['studentName'] ?? $uid),
                'totalQuestions' => $totalQuestions,
                'answered' => (int) ($r['answered'] ?? 0),
                'correct' => (int) ($r['correct'] ?? 0),
                'wrong' => (int) ($r['wrong'] ?? 0),
                'xpEarned' => (int) ($r['xp'] ?? 0),
                'successRate' => (int) ($r['successRate'] ?? 0),
                'startedAtMs' => $startedAtMs,
                'durationMs' => max(0, (int) ($r['durationMs'] ?? 0)),
                'durationMinutes' => round(max(0, (int) ($r['durationMs'] ?? 0)) / 60000, 1),
                'finishReason' => $finishReason,
                'finishedAtMs' => $finishedAtMs,
                'status' => 'finished',
                'updatedAt' => now()->toIso8601String(),
            ];

            $this->upsertDocument("studentReports/{$uid}/quizSessions/{$session->id}", $item);
            $this->upsertDocument("studentQuizResults/{$session->id}_{$uid}", $item);
            $this->refreshStudentSummary((int) $uid);
        }
    }

    private function upsertDocument(string $path, array $payload): void
    {
        $parts = array_values(array_filter(explode('/', trim($path, '/')), fn ($x) => $x !== ''));
        $id = (string) end($parts);
        $collection = count($parts) > 1 ? (string) $parts[count($parts) - 2] : '';
        $parent = count($parts) > 2 ? implode('/', array_slice($parts, 0, -2)) : null;

        $doc = DocumentRecord::query()->firstOrNew(['path' => $path]);
        $doc->collection_name = $collection;
        $doc->document_id = $id;
        $doc->parent_path = $parent;
        $doc->payload = $payload;
        $doc->save();
    }

    private function refreshStudentSummary(int $userId): void
    {
        $rows = DocumentRecord::query()
            ->where('collection_name', 'quizSessions')
            ->where('parent_path', "studentReports/{$userId}")
            ->get()
            ->map(fn ($d) => (array) ($d->payload ?? []))
            ->values();

        $quizzes = $rows->count();
        $answered = $rows->sum(fn ($r) => max(0, (int) ($r['answered'] ?? 0)));
        $correct = $rows->sum(fn ($r) => max(0, (int) ($r['correct'] ?? 0)));
        $wrong = $rows->sum(fn ($r) => max(0, (int) ($r['wrong'] ?? 0)));
        $totalXp = $rows->sum(fn ($r) => max(0, (int) ($r['xpEarned'] ?? 0)));
        $latest = $rows->sortByDesc(fn ($r) => (int) ($r['finishedAtMs'] ?? 0))->first() ?: [];

        $report = StudentReport::query()->firstOrNew(['user_id' => $userId]);
        $meta = (array) ($report->meta ?? []);
        $meta['quizSessionsCompleted'] = (int) $quizzes;
        $meta['quizAnswered'] = (int) $answered;
        $meta['quizCorrect'] = (int) $correct;
        $meta['quizWrong'] = (int) $wrong;
        $meta['quizTotalXP'] = (int) $totalXp;
        $meta['lastQuizTitle'] = (string) ($latest['quizTitle'] ?? '');
        $meta['lastQuizDurationMs'] = (int) ($latest['durationMs'] ?? 0);
        $meta['updatedAt'] = now()->toIso8601String();

        $report->meta = $meta;
        $report->save();
    }
}
