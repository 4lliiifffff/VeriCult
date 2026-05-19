<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePhoneNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && empty($user->no_hp) && in_array($user->roles->first()?->name, ['pengusul', 'pengusul-desa'])) {
            
            // Get dashboard route based on role
            $dashboardRoute = $user->hasRole('pengusul') ? 'pengusul.dashboard' : 'pengusul-desa.dashboard';
            
            return redirect()->route($dashboardRoute)
                ->with('error', 'Peringatan: Anda diwajibkan untuk memverifikasi Nomor Handphone sebelum dapat mengakses form pengajuan kebudayaan.')
                ->with('force_phone_verification', true);
        }

        return $next($request);
    }
}
