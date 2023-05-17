<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $th) {
            if ($th instanceof TokenInvalidException) {
                return response()->json([
                    'error' => ' invalid token ',
                ], 401);
            } else if ($th instanceof TokenExpiredException) {
                return response()->json([
                    'error' => ' expired token ',
                ], 401);
            } else {
                return response()->json([
                    'error' => ' not found token ',
                ], 401);
            }
        }
        return $next($request);
    }
}
