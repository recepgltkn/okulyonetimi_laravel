<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('legacy.home');
});

Route::get('/block-3d-runner', fn () => response()->file(public_path('block-3d-runner/index.html')));
Route::get('/block-grid-runner', fn () => response()->file(public_path('block-grid-runner/index.html')));
Route::get('/compute-it-runner', fn () => response()->file(public_path('compute-it-runner/index.html')));
Route::get('/lightbot-runner', fn () => response()->file(public_path('lightbot-runner/index.html')));
Route::get('/line-trace-runner', fn () => response()->file(public_path('line-trace-runner/index.html')));
Route::get('/silent-teacher-runner', fn () => response()->file(public_path('silent-teacher-runner/index.html')));

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
