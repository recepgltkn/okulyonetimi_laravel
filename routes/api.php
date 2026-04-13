<?php

use App\Http\Controllers\ClientDataController;
use App\Http\Controllers\ClientLiveQuizController;
use App\Http\Controllers\ClientBlockBuilderController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    // Okul gibi tek IP'den toplu giriÅŸlerde 429 riskini azalt.
    Route::middleware('throttle:client-auth')->group(function () {
        Route::post('/auth/login', [ClientDataController::class, 'login']);
        Route::post('/auth/register', [ClientDataController::class, 'register']);
    });

    // Auth sonrasÄ± yoÄŸun polling trafiÄŸi iÃ§in daha yÃ¼ksek tavan.
    Route::middleware(['client.auth', 'throttle:client-api'])->group(function () {
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

        Route::prefix('/block-builder')->group(function () {
            Route::get('/designs/latest', [ClientBlockBuilderController::class, 'latest']);
            Route::get('/designs/{id}', [ClientBlockBuilderController::class, 'show'])->whereNumber('id');
            Route::post('/designs', [ClientBlockBuilderController::class, 'store']);
        });
    });
});

Route::prefix('race')->group(function () {
    Route::get('/rooms/active', [RaceController::class, 'active']);
    Route::get('/my-runs', [RaceController::class, 'myRuns']);
    Route::post('/rooms', [RoomController::class, 'store']);
    Route::get('/rooms/{room:code}', [RoomController::class, 'show']);
    Route::post('/rooms/{room:code}/join', [RoomController::class, 'join']);

    Route::post('/rooms/{room:code}/start', [RaceController::class, 'start']);
    Route::post('/rooms/{room:code}/end', [RaceController::class, 'end']);
    Route::post('/rooms/{room:code}/finish', [RaceController::class, 'finish']);
    Route::get('/rooms/{room:code}/leaderboard', [RaceController::class, 'leaderboard']);
    Route::get('/rooms/{room:code}/report', [RaceController::class, 'report']);
});

