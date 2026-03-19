<?php

namespace App\Http\Controllers;

use App\Services\Client\ClientLiveQuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientLiveQuizController extends Controller
{
    public function __construct(private readonly ClientLiveQuizService $service)
    {
    }

    public function createQuiz(Request $request): JsonResponse
    {
        return $this->service->createQuiz($request);
    }

    public function listMyQuizzes(Request $request): JsonResponse
    {
        return $this->service->listMyQuizzes($request);
    }

    public function updateQuiz(Request $request, string $quizId): JsonResponse
    {
        return $this->service->updateQuiz($request, $quizId);
    }

    public function deleteQuiz(Request $request, string $quizId): JsonResponse
    {
        return $this->service->deleteQuiz($request, $quizId);
    }

    public function startSession(Request $request): JsonResponse
    {
        return $this->service->startSession($request);
    }

    public function getActiveTeacherSession(Request $request): JsonResponse
    {
        return $this->service->getActiveTeacherSession($request);
    }

    public function getActiveStudentSession(Request $request): JsonResponse
    {
        return $this->service->getActiveStudentSession($request);
    }

    public function getSession(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->getSession($request, $sessionId);
    }

    public function submitAnswer(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->submitAnswer($request, $sessionId);
    }

    public function lockQuestion(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->lockQuestion($request, $sessionId);
    }

    public function unlockQuestion(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->unlockQuestion($request, $sessionId);
    }

    public function nextQuestion(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->nextQuestion($request, $sessionId);
    }

    public function finishSession(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->finishSession($request, $sessionId);
    }

    public function leaderboard(Request $request, string $sessionId): JsonResponse
    {
        return $this->service->leaderboard($request, $sessionId);
    }
}
