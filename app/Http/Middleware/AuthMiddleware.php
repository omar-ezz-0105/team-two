<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the custom 'user' key is in the session
        if (!session('user')) {
            // Redirect to the named login route if not authenticated
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        return $next($request);
    }
}