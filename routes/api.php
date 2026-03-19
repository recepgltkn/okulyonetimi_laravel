<?php

use App\Http\Controllers\ClientDataController;
use App\Http\Controllers\ClientLiveQuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    // Okul gibi tek IP'den toplu girişlerde 429 riskini azalt.
    Route::middleware('throttle:1000,1')->group(function () {
        Route::post('/auth/login', [ClientDataController::class, 'login']);
        Route::post('/auth/register', [ClientDataController::class, 'register']);
    });

    // Auth sonrası yoğun polling trafiği için daha yüksek tavan.
    Route::middleware(['client.auth', 'throttle:12000,1'])->group(function () {
        Route::post('/auth/logout', [ClientDataController::class, 'logout']);
        Route::post('/auth/update-password', [ClientDataController::class, 'updatePassword']);
        Route::post('/auth/delete-user', [ClientDataController::class, 'deleteUser']);

        Route::get('/docs/get', [ClientDataController::class, 'getDoc']);
        Route::post('/docs/set', [ClientDataController::class, 'setDoc']);
        Route::post('/docs/update', [ClientDataController::class, 'updateDoc']);
        Route::post('/docs/delete', [ClientDataController::class, 'deleteDoc']);
        Route::post('/docs/add', [ClientDataController::class, 'addDoc']);
        Route::post('/docs/query', [ClientDataController::class, 'queryDocs']);
        Route::post('/docs/batch', [ClientDataController::class, 'batch']);

        Route::post('/callable/{name}', [ClientDataController::class, 'callable']);
        Route::prefix('/live-quiz')->group(function () {
            Route::post('/quizzes', [ClientLiveQuizController::class, 'createQuiz']);
            Route::get('/quizzes', [ClientLiveQuizController::class, 'listMyQuizzes']);
            Route::put('/quizzes/{quizId}', [ClientLiveQuizController::class, 'updateQuiz']);
            Route::delete('/quizzes/{quizId}', [ClientLiveQuizController::class, 'deleteQuiz']);
            Route::post('/sessions', [ClientLiveQuizController::class, 'startSession']);
            Route::get('/sessions/active/teacher', [ClientLiveQuizController::class, 'getActiveTeacherSession']);
            Route::get('/sessions/active/student', [ClientLiveQuizController::class, 'getActiveStudentSession']);
            Route::get('/sessions/{sessionId}', [ClientLiveQuizController::class, 'getSession']);
            Route::post('/sessions/{sessionId}/answer', [ClientLiveQuizController::class, 'submitAnswer']);
            Route::post('/sessions/{sessionId}/lock', [ClientLiveQuizController::class, 'lockQuestion']);
            Route::post('/sessions/{sessionId}/unlock', [ClientLiveQuizController::class, 'unlockQuestion']);
            Route::post('/sessions/{sessionId}/next', [ClientLiveQuizController::class, 'nextQuestion']);
            Route::post('/sessions/{sessionId}/finish', [ClientLiveQuizController::class, 'finishSession']);
            Route::get('/sessions/{sessionId}/leaderboard', [ClientLiveQuizController::class, 'leaderboard']);
        });
    });
});

