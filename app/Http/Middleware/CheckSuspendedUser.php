<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspendedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_suspended) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $rememberCookie = Auth::guard('web')->getRecallerName();

            return redirect()->route('login')
                ->withCookie(cookie()->forget($rememberCookie))
                ->withCookie(cookie()->forget(config('session.cookie')))
                ->withErrors([
                    'email' => 'Akun Anda telah ditangguhkan. Silakan hubungi administrator.',
                ]);
        }

        return $next($request);
    }
}
