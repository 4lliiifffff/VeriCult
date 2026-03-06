<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized');
        }

        $roles = explode('|', $role);

        // Check against both the 'role' column (temporary) and Spatie permissions
        if (!in_array($request->user()->role, $roles) && !$request->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
