<?php

use App\Http\Controllers\ClientDataController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    Route::post('/auth/login', [ClientDataController::class, 'login']);
    Route::post('/auth/register', [ClientDataController::class, 'register']);
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
});

