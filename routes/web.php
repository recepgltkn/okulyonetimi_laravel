<?php

use App\Http\Controllers\ClientDataController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\StudentPanelController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('legacy.home');
});
Route::get('/legacy-home', function () {
    return view('legacy.home');
});

// Shared hosting / stale frontend compatibility:
// older clients may still POST to /login instead of /api/client/auth/login.
Route::post('/login', [ClientDataController::class, 'login']);

Route::get('/ogrenci-paneli', fn () => redirect('/ogrenci-paneli/dashboard'));
Route::get('/ogrenci-paneli/{page?}', [StudentPanelController::class, 'show']);

Route::get('/block-3d-runner', fn () => response()->file(public_path('block-3d-runner/index.html')));
Route::get('/block-grid-runner', fn () => response()->file(public_path('block-grid-runner/index.html')));
Route::get('/compute-it-runner', fn () => response()->file(public_path('compute-it-runner/index.html')));
Route::get('/lightbot-runner', fn () => response()->file(public_path('lightbot-runner/index.html')));
Route::get('/line-trace-runner', fn () => response()->file(public_path('line-trace-runner/index.html')));
Route::get('/silent-teacher-runner', fn () => response()->file(public_path('silent-teacher-runner/index.html')));
Route::view('/keyboard-race', 'keyboard-race.index');
Route::view('/block-builder-studio', 'block-builder.index');

Route::get('/manifest.webmanifest', function (Request $request) {
    $base = rtrim($request->getBaseUrl(), '/');
    $appRoot = ($base !== '' ? $base : '') . '/';
    $publicBase = ($base !== '' ? $base : '') . '/public';

    $manifestPath = public_path('manifest.json');
    $manifest = [];
    if (is_file($manifestPath)) {
        $decoded = json_decode((string) file_get_contents($manifestPath), true);
        if (is_array($decoded)) {
            $manifest = $decoded;
        }
    }

    $manifest['id'] = $appRoot;
    $manifest['start_url'] = $appRoot;
    $manifest['scope'] = $appRoot;

    $icons = $manifest['icons'] ?? [];
    if (is_array($icons)) {
        foreach ($icons as $i => $icon) {
            if (!is_array($icon)) {
                continue;
            }
            $src = (string) ($icon['src'] ?? '');
            if ($src === '' || preg_match('/^https?:\/\//i', $src) || str_starts_with($src, '/')) {
                continue;
            }
            $icons[$i]['src'] = $publicBase . '/' . ltrim($src, '/');
        }
        $manifest['icons'] = $icons;
    }

    $shortcuts = $manifest['shortcuts'] ?? [];
    if (is_array($shortcuts)) {
        foreach ($shortcuts as $i => $shortcut) {
            if (!is_array($shortcut)) {
                continue;
            }
            $shortcuts[$i]['url'] = $appRoot;
        }
        $manifest['shortcuts'] = $shortcuts;
    }

    return response(
        json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        200,
        ['Content-Type' => 'application/manifest+json; charset=UTF-8']
    );
});

Route::get('/service-worker.js', function () {
    $path = public_path('service-worker.js');
    if (!is_file($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'application/javascript; charset=UTF-8',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
        'Service-Worker-Allowed' => '/',
    ]);
});

// Shared-hosting compatibility aliases for race API paths when rewrite rules alter prefixes.
foreach (['api/race', 'public/api/race', 'index.php/api/race'] as $racePrefix) {
    Route::prefix($racePrefix)->group(function (): void {
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
}

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
