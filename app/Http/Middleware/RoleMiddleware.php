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

        // For pengusul-desa users, check if they are approved by admin
        // Allow if not pengusul-desa role, or if approved
        if (in_array('pengusul-desa', $roles) && $request->user()->hasRole('pengusul-desa')) {
            if (!$request->user()->is_approved_by_admin) {
                abort(403, 'Akun Anda sedang menunggu persetujuan dari super admin. Silahkan tunggu email konfirmasi.');
            }
        }

        return $next($request);
    }
}
