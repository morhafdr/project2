<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User does not have the required role.'], 403);
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
