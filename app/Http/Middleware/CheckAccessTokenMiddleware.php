<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CheckAccessTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->get('access_token');

        if (!$token) {
            throw new AuthorizationException("Access Token is needed to proceed to this API!");
        }

        if ($token != env('ACCESS_TOKEN')) {
            throw new AuthorizationException("Access Token is invalid!");
        }
        return $next($request);
    }
}
