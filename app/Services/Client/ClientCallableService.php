<?php

namespace App\Services\Client;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientCallableService
{
    public function __construct(
        private readonly ClientAuthService $authService,
        private readonly ClientStatsService $statsService,
    ) {
    }

    public function handle(Request $request, string $name): JsonResponse
    {
        $data = (array) $request->input('data', []);

        if ($name === 'deleteUserByAdmin') {
            $requesterUid = (string) $request->attributes->get('client_uid', '');
            $targetUid = (string) ($data['uid'] ?? $data['userId'] ?? '');
            if ($requesterUid === '' || $targetUid === '') {
                return response()->json(['data' => ['ok' => false, 'message' => 'invalid user']], 422);
            }

            return $this->authService->deleteUserByAdmin($targetUid);
        }

        if ($name === 'setUserPasswordByAdmin') {
            $uid = (string) ($data['uid'] ?? $data['userId'] ?? '');
            return $this->authService->setUserPasswordByAdmin($uid, $data['newPassword'] ?? null);
        }

        if ($name === 'studentAiAssistant') {
            return response()->json(['data' => ['reply' => 'AI assistant is not configured on Laravel API yet.']]);
        }

        if ($name === 'getMyStats') {
            $uid = (string) $request->attributes->get('client_uid', '');
            if ($uid === '') {
                return response()->json(['data' => ['ok' => false, 'message' => 'unauthenticated']], 401);
            }
            return response()->json(['data' => $this->statsService->buildMyStatsSummary($uid)]);
        }

        return response()->json(['data' => ['ok' => false, 'message' => "Unknown callable: {$name}"]], 404);
    }
}
