<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $expiresAt = now()->addMinutes(5); // User considered 'online' for 5 mins

            // 1. Update Cache for fast "Who is online" lookup
            // Key format: user-online-{id}
            Cache::put('user-online-' . $user->id, [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->roles->first()?->name ?? 'user',
                'current_url' => $request->path(),
                'method' => $request->method(),
                'last_activity' => now()->timestamp
            ], $expiresAt);

            // 2. Add to a master set of online user IDs
            // This allows us to efficiently list all online users without scanning all cache keys
            $onlineUsers = Cache::get('online-users', []);
            if (!in_array($user->id, $onlineUsers)) {
                $onlineUsers[] = $user->id;
                Cache::put('online-users', $onlineUsers, $expiresAt);
            }

            // 3. Update Database (Throttled)
            // Only update DB if last update was more than 5 minutes ago to save performance
            if (is_null($user->last_seen_at) || $user->last_seen_at->diffInMinutes(now()) > 5) {
                // Determine model class properly
                $modelClass = get_class($user);
                $modelClass::where('id', $user->id)->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
