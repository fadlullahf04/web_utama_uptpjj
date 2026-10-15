<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        if (config('app.env') === 'production') {
            $csp = "default-src 'self'; "
                ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; "
                ."style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; "
                ."font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; "
                ."img-src 'self' data: https: blob:; "
                ."frame-src 'self' https://www.youtube.com https://youtube.com https://maps.google.com https://www.google.com; "
                ."connect-src 'self' https:;";
            $response->headers->set('Content-Security-Policy', $csp);
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        } else {
            $csp = "default-src 'self' 'unsafe-inline' 'unsafe-eval' data: blob: https: http:; "
                ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https: http: http://localhost:* http://127.0.0.1:* http://[::1]:* ws: wss:; "
                ."style-src 'self' 'unsafe-inline' https: http: http://localhost:* http://127.0.0.1:* http://[::1]:*; "
                ."font-src 'self' https: http: data:; "
                ."img-src 'self' data: https: blob: http:; "
                ."frame-src 'self' https: http:; "
                ."connect-src 'self' ws: wss: http: https: http://localhost:* http://127.0.0.1:* http://[::1]:*;";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Hide PHP/server signature
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }

        return $response;
    }
}
