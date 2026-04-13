<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('client-auth', function (Request $request) {
            $identifier = strtolower((string) ($request->input('identifier') ?: $request->input('email') ?: $request->ip()));
            return [
                Limit::perMinute(20)->by($identifier),
                Limit::perMinute(120)->by($request->ip()),
            ];
        });

        RateLimiter::for('client-api', function (Request $request) {
            $uid = (string) ($request->header('X-Client-Uid') ?: $request->input('uid') ?: $request->query('uid') ?: '');
            $key = $uid !== '' ? "uid:{$uid}" : "ip:{$request->ip()}";
            return [
                Limit::perMinute(1800)->by($key),
                Limit::perMinute(20000)->by($request->ip()),
            ];
        });
    }
}
