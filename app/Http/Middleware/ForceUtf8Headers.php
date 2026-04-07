<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceUtf8Headers
{
    public function handle(Request $request, Closure $next): Response
    {
        @ini_set('default_charset', 'UTF-8');
        if (function_exists('mb_internal_encoding')) {
            @mb_internal_encoding('UTF-8');
        }

        /** @var Response $response */
        $response = $next($request);

        $contentType = (string) $response->headers->get('Content-Type', '');
        if ($contentType !== '' && stripos($contentType, 'charset=') === false) {
            if (stripos($contentType, 'text/') === 0 || stripos($contentType, 'application/json') === 0 || stripos($contentType, 'application/javascript') === 0 || stripos($contentType, 'application/xml') === 0) {
                $response->headers->set('Content-Type', $contentType . '; charset=UTF-8');
            }
        }

        return $response;
    }
}

