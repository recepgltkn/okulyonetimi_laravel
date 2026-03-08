<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateClientApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->extractToken($request);
        $uid = $this->extractUid($request);
        if ($token === '' || $uid === '') {
            return new JsonResponse(['message' => 'unauthenticated'], 401);
        }

        $cacheKey = "client_api_token:{$uid}";
        $storedHash = (string) Cache::get($cacheKey, '');
        $incomingHash = hash('sha256', $token);
        if ($storedHash === '' || ! hash_equals($storedHash, $incomingHash)) {
            return new JsonResponse(['message' => 'unauthenticated'], 401);
        }

        $request->attributes->set('client_uid', $uid);
        $request->attributes->set('client_token_hash', $incomingHash);

        return $next($request);
    }

    private function extractToken(Request $request): string
    {
        $bearer = (string) $request->bearerToken();
        if ($bearer !== '') return $bearer;
        return trim((string) $request->header('X-Client-Token', ''));
    }

    private function extractUid(Request $request): string
    {
        $candidates = [
            $request->header('X-Client-Uid'),
            $request->input('uid'),
            $request->query('uid'),
        ];
        foreach ($candidates as $candidate) {
            $uid = trim((string) $candidate);
            if ($uid !== '') return $uid;
        }
        return '';
    }
}
