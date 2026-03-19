<?php

namespace App\Services\Client;

use App\Models\DocumentRecord;
use App\Models\UserProfile;
use Illuminate\Support\Str;

class ClientStatsService
{
    public function buildMyStatsSummary(string $uid): array
    {
        $profile = UserProfile::query()->where('user_id', $uid)->first();
        $meta = $this->normalizeMeta($profile?->meta);
        $ownerTeacherId = (string) ($meta['ownerTeacherId'] ?? $meta['createdBy'] ?? '');
        $studentClass = (string) ($profile?->class_name ?? '');
        $studentSection = (string) ($profile?->section ?? '');

        $matchesOwner = function (array $payload) use ($ownerTeacherId): bool {
            $recordUserId = (string) ($payload['userId'] ?? '');
            if ($ownerTeacherId !== '' && $recordUserId !== '' && $recordUserId !== $ownerTeacherId) return false;
            return true;
        };
        $matchesTarget = function (array $payload, bool $requireClassWhenTargetEmpty) use ($studentClass, $studentSection): bool {
            $targetClass = (string) ($payload['targetClass'] ?? '');
            $targetSection = (string) ($payload['targetSection'] ?? '');
            if ($targetClass === '') {
                return $requireClassWhenTargetEmpty ? ($studentClass !== '') : true;
            }
            if ($studentClass === '') return false;
            if ($targetSection !== '') return $targetClass === $studentClass && $targetSection === $studentSection;
            return $targetClass === $studentClass;
        };

        $activityDocs = DocumentRecord::query()->where('collection_name', 'activities')->get(['payload']);
        $studentTasks = $activityDocs->filter(function ($row) use ($matchesOwner, $matchesTarget) {
            $payload = (array) ($row->payload ?? []);
            if (! $matchesOwner($payload)) return false;
            return $matchesTarget($payload, true);
        });
        $totalTasks = $studentTasks->count();

        $completions = DocumentRecord::query()->where('collection_name', 'completions')->where('payload->userId', $uid)->get(['payload']);
        $approvedManualCount = DocumentRecord::query()->where('collection_name', 'bookTaskProgress')->where('payload->userId', $uid)->where('payload->approved', true)->count();
        $completedCount = $completions->count() + $approvedManualCount;
        $totalScore = 0;
        foreach ($completions as $row) {
            $p = (array) ($row->payload ?? []);
            $correct = (float) ($p['correctAnswers'] ?? 0);
            $totalQ = (float) ($p['totalQuestions'] ?? 1);
            $totalScore += ($correct / max(1, $totalQ)) * 100;
        }
        $avgScore = $completedCount > 0 ? (int) round($totalScore / $completedCount) : 0;
        $taskRate = $totalTasks > 0 ? (int) round(($completedCount / $totalTasks) * 100) : 0;

        $contentAssignments = DocumentRecord::query()->where('collection_name', 'contentAssignments')->get(['payload', 'document_id']);
        $assignmentsForStudent = $contentAssignments->filter(function ($row) use ($matchesOwner, $matchesTarget) {
            $payload = (array) ($row->payload ?? []);
            if (! $matchesOwner($payload)) return false;
            return $matchesTarget($payload, false);
        });
        $contentProgressDocs = DocumentRecord::query()->where('collection_name', 'contentProgress')->where('payload->userId', $uid)->get(['payload']);
        $contentProgressByContentId = [];
        foreach ($contentProgressDocs as $row) {
            $p = (array) ($row->payload ?? []);
            $contentId = (string) ($p['contentId'] ?? '');
            if ($contentId !== '') $contentProgressByContentId[$contentId] = $p;
        }
        $activityCompleted = 0;
        foreach ($assignmentsForStudent as $row) {
            $payload = (array) ($row->payload ?? []);
            $contentId = (string) ($payload['contentId'] ?? '');
            $progress = $contentId !== '' ? ($contentProgressByContentId[$contentId] ?? null) : null;
            if (! $progress) continue;
            $appUsage = (array) ($progress['appUsage'] ?? []);
            $done = false;
            foreach ($appUsage as $usage) {
                $u = (array) $usage;
                if ((float) ($u['percent'] ?? 0) > 0 || (float) ($u['seconds'] ?? 0) > 0) { $done = true; break; }
            }
            if ($done) $activityCompleted++;
        }
        $totalActivities = $assignmentsForStudent->count();
        $activityRate = $totalActivities > 0 ? (int) round(($activityCompleted / $totalActivities) * 100) : 0;

        $lessons = DocumentRecord::query()->where('collection_name', 'lessons')->get(['payload', 'document_id']);
        $lessonsForStudent = $lessons->filter(function ($row) use ($matchesOwner, $matchesTarget) {
            $payload = (array) ($row->payload ?? []);
            if (($payload['isPublished'] ?? null) === false) return false;
            if (! $matchesOwner($payload)) return false;
            return $matchesTarget($payload, false);
        });
        $lessonProgressDocs = DocumentRecord::query()->where('collection_name', 'lessonProgress')->where('payload->userId', $uid)->get(['payload']);
        $lessonProgressByLessonId = [];
        foreach ($lessonProgressDocs as $row) {
            $p = (array) ($row->payload ?? []);
            $lessonId = (string) ($p['lessonId'] ?? '');
            if ($lessonId !== '') $lessonProgressByLessonId[$lessonId] = $p;
        }
        $lessonCompleted = 0;
        foreach ($lessonsForStudent as $row) {
            $lessonId = (string) ($row->document_id ?? '');
            $progress = $lessonId !== '' ? ($lessonProgressByLessonId[$lessonId] ?? null) : null;
            if ($progress) $lessonCompleted++;
        }
        $lessonTotal = $lessonsForStudent->count();
        $lessonRate = $lessonTotal > 0 ? (int) round(($lessonCompleted / $lessonTotal) * 100) : 0;

        $blockAssignments = DocumentRecord::query()->where('collection_name', 'blockAssignments')->get(['payload', 'document_id']);
        $blockAssignmentsForStudent = $blockAssignments->filter(function ($row) use ($matchesOwner, $matchesTarget) {
            $payload = (array) ($row->payload ?? []);
            if (! empty($payload['isDeleted'])) return false;
            if (! $matchesOwner($payload)) return false;
            return $matchesTarget($payload, false);
        });
        $blockProgressDocs = DocumentRecord::query()->where('collection_name', 'blockAssignmentProgress')->where('payload->userId', $uid)->get(['payload']);
        $blockProgressByAssignmentId = [];
        foreach ($blockProgressDocs as $row) {
            $p = (array) ($row->payload ?? []);
            $assignmentId = (string) ($p['assignmentId'] ?? '');
            if ($assignmentId !== '') $blockProgressByAssignmentId[$assignmentId] = $p;
        }
        $isBlockDone = function (array $progress): bool {
            $completedLevels = max(0, (int) ($progress['completedLevels'] ?? 0));
            $totalLevels = max(0, (int) ($progress['totalLevels'] ?? 0));
            $percent = max(0, (float) ($progress['percent'] ?? 0));
            return ! empty($progress['completed']) || $percent >= 100 || ($totalLevels > 0 && $completedLevels >= $totalLevels);
        };
        $block2DTotal = 0; $block2DCompleted = 0; $block3DTotal = 0; $block3DCompleted = 0; $pythonQuizTotal = 0; $pythonQuizCompleted = 0;
        foreach ($blockAssignmentsForStudent as $row) {
            $payload = (array) ($row->payload ?? []);
            $assignmentId = (string) ($row->document_id ?? '');
            $progress = $assignmentId !== '' ? ($blockProgressByAssignmentId[$assignmentId] ?? []) : [];
            $type = (string) ($payload['assignmentType'] ?? '');
            if ($type === 'block3d') {
                $block3DTotal++;
                if ($progress && $isBlockDone($progress)) $block3DCompleted++;
            } elseif ($type === 'silentteacher') {
                $pythonQuizTotal++;
                if ($progress && $isBlockDone($progress)) $pythonQuizCompleted++;
            } elseif ($type === 'flowchart' || $type === 'lightbot') {
            } else {
                $block2DTotal++;
                if ($progress && $isBlockDone($progress)) $block2DCompleted++;
            }
        }
        $block2DRate = $block2DTotal > 0 ? (int) round(($block2DCompleted / $block2DTotal) * 100) : 0;
        $block3DRate = $block3DTotal > 0 ? (int) round(($block3DCompleted / $block3DTotal) * 100) : 0;
        $pythonQuizRate = $pythonQuizTotal > 0 ? (int) round(($pythonQuizCompleted / $pythonQuizTotal) * 100) : 0;

        $computeAssignments = DocumentRecord::query()->where('collection_name', 'computeAssignments')->get(['payload', 'document_id']);
        $computeAssignmentsForStudent = $computeAssignments->filter(function ($row) use ($matchesOwner, $matchesTarget) {
            $payload = (array) ($row->payload ?? []);
            if (! empty($payload['isDeleted'])) return false;
            if (! $matchesOwner($payload)) return false;
            return $matchesTarget($payload, false);
        });
        $computeProgressDocs = DocumentRecord::query()->where('collection_name', 'computeAssignmentProgress')->where('payload->userId', $uid)->get(['payload']);
        $computeProgressByAssignmentId = [];
        foreach ($computeProgressDocs as $row) {
            $p = (array) ($row->payload ?? []);
            $assignmentId = (string) ($p['assignmentId'] ?? '');
            if ($assignmentId !== '') $computeProgressByAssignmentId[$assignmentId] = $p;
        }
        $isComputeDone = function (array $progress, array $assignment): bool {
            $percent = max(0, (float) ($progress['percent'] ?? 0));
            $completedLevels = max(0, (int) ($progress['completedLevels'] ?? 0));
            $levelStart = (int) ($assignment['levelStart'] ?? 1);
            $levelEnd = (int) ($assignment['levelEnd'] ?? $levelStart);
            $assignmentTotalLevels = max(1, $levelEnd - $levelStart + 1);
            $totalLevels = max((int) ($progress['totalLevels'] ?? 0), $assignmentTotalLevels);
            $completedIds = is_array($progress['completedLevelIds'] ?? null) ? $progress['completedLevelIds'] : [];
            $completedByIds = count($completedIds);
            $currentIndex = max(0, (int) ($progress['currentLevelIndex'] ?? 0));
            $completedCount = max($completedLevels, $completedByIds, $currentIndex);
            return ! empty($progress['completed']) || $percent >= 100 || ($totalLevels > 0 && $completedCount >= $totalLevels);
        };
        $computeTotal = 0; $computeCompleted = 0;
        foreach ($computeAssignmentsForStudent as $row) {
            $payload = (array) ($row->payload ?? []);
            $assignmentId = (string) ($row->document_id ?? '');
            $progress = $assignmentId !== '' ? ($computeProgressByAssignmentId[$assignmentId] ?? []) : [];
            $computeTotal++;
            if ($progress && $isComputeDone($progress, $payload)) $computeCompleted++;
        }
        $computeRate = $computeTotal > 0 ? (int) round(($computeCompleted / $computeTotal) * 100) : 0;

        $totalXP = (int) ($profile?->xp ?? 0);

        $schoolRank = null;
        $classRank = null;
        $baseQuery = UserProfile::query()
            ->join('users', 'users.id', '=', 'user_profiles.user_id')
            ->leftJoin('student_reports', 'student_reports.user_id', '=', 'user_profiles.user_id')
            ->where(function ($q) {
                $q->whereNull('user_profiles.role')->orWhereNotIn('user_profiles.role', ['teacher', 'admin', 'administrator', 'ogretmen']);
            })
            ->select(['user_profiles.user_id', 'user_profiles.xp', 'user_profiles.class_name', 'user_profiles.section', 'user_profiles.meta', 'student_reports.total_xp']);

        $rows = $baseQuery->get();
        $rankRows = $rows->map(function ($row) {
            $primaryXp = (int) ($row->xp ?? 0);
            $fallbackXp = (int) ($row->total_xp ?? 0);
            $row->rank_xp = $primaryXp > 0 ? $primaryXp : $fallbackXp;
            return $row;
        })->values()->all();
        usort($rankRows, function ($a, $b) {
            $diff = (int) ($b->rank_xp <=> $a->rank_xp);
            if ($diff !== 0) return $diff;
            return (int) ((int) $a->user_id <=> (int) $b->user_id);
        });
        $rank = 0;
        $lastXp = null;
        foreach ($rankRows as $index => $row) {
            $xp = (int) ($row->rank_xp ?? 0);
            if ($lastXp === null || $xp !== $lastXp) {
                $rank = $index + 1;
            }
            if ((string) $row->user_id === $uid) {
                $schoolRank = $rank;
                break;
            }
            $lastXp = $xp;
        }

        $normalizedClass = Str::lower(Str::ascii(trim($studentClass)));
        $normalizedSection = Str::lower(Str::ascii(trim($studentSection)));
        if ($normalizedClass !== '') {
            $classRows = collect($rankRows)->filter(function ($row) use ($normalizedClass, $normalizedSection) {
                $rowClass = Str::lower(Str::ascii(trim((string) ($row->class_name ?? ''))));
                $rowSection = Str::lower(Str::ascii(trim((string) ($row->section ?? ''))));
                if ($rowClass !== $normalizedClass) return false;
                if ($normalizedSection !== '' && $rowSection !== $normalizedSection) return false;
                return true;
            })->values();
            $classRankIndex = null;
            $rank = 0;
            $lastXp = null;
            foreach ($classRows as $index => $row) {
                $xp = (int) ($row->rank_xp ?? 0);
                if ($lastXp === null || $xp !== $lastXp) {
                    $rank = $index + 1;
                }
                if ((string) $row->user_id === $uid) {
                    $classRankIndex = $rank;
                    break;
                }
                $lastXp = $xp;
            }
            $classRank = $classRankIndex;
        }

        return [
            'ok' => true,
            'uid' => $uid,
            'totalTasks' => $totalTasks,
            'completedCount' => $completedCount,
            'avgScore' => $avgScore,
            'taskRate' => $taskRate,
            'totalActivities' => $totalActivities,
            'activityCompleted' => $activityCompleted,
            'activityRate' => $activityRate,
            'lessonTotal' => $lessonTotal,
            'lessonCompleted' => $lessonCompleted,
            'lessonRate' => $lessonRate,
            'block2DTotal' => $block2DTotal,
            'block2DCompleted' => $block2DCompleted,
            'block2DRate' => $block2DRate,
            'block3DTotal' => $block3DTotal,
            'block3DCompleted' => $block3DCompleted,
            'block3DRate' => $block3DRate,
            'pythonQuizTotal' => $pythonQuizTotal,
            'pythonQuizCompleted' => $pythonQuizCompleted,
            'pythonQuizRate' => $pythonQuizRate,
            'computeTotal' => $computeTotal,
            'computeCompleted' => $computeCompleted,
            'computeRate' => $computeRate,
            'totalXP' => $totalXP,
            'classRank' => $classRank,
            'schoolRank' => $schoolRank,
        ];
    }

    private function normalizeMeta(mixed $meta): array
    {
        if (is_array($meta)) return $meta;
        if (is_string($meta) && $meta !== '') {
            $decoded = json_decode($meta, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }
}
