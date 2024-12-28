<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Retrieve the token from cache (no email in the key)
        $token = Session::get('token');  // Use the same cache key as in AuthController

        // Check if token exists
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Token not found or expired.']);
        }

        // Optionally: Attach the token to the request headers for external API requests
        $request->headers->set('Authorization', 'Bearer ' . $token);

        return $next($request);
    }
}
