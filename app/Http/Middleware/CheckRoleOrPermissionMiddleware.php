<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $permission = null)
    {
        if (!Auth::user()->hasRole($role) && !Auth::user()->can($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User does not have the required role or permission.'], 403);
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
