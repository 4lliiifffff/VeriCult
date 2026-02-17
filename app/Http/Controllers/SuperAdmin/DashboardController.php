<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $suspendedUsersCount = User::where('is_suspended', true)->count();
        
        // Users by Role
        $usersByRole = Role::withCount('users')->get();

        // Recent Users
        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        // Audit Logs
        $auditLogs = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();
            
        // Suspended Users List
        $suspendedUsers = User::where('is_suspended', true)->with('roles')->get();

        // Unverified Users
        $unverifiedUsersCount = User::whereNull('email_verified_at')->count();

        // Online Users Monitoring
        $onlineUserIds = \Illuminate\Support\Facades\Cache::get('online-users', []);
        $onlineUsers = collect();
        
        foreach ($onlineUserIds as $id) {
            $userData = \Illuminate\Support\Facades\Cache::get('user-online-' . $id);
            if ($userData) {
                // Calculate status based on last activity
                $lastActivity = \Illuminate\Support\Carbon::createFromTimestamp($userData['last_activity']);
                $userData['status'] = $lastActivity->diffInMinutes(now()) < 5 ? 'Online' : 'Idle';
                $userData['last_activity_human'] = $lastActivity->diffForHumans();
                $onlineUsers->push((object) $userData);
            }
        }

        // Return existing view but now it will use the new layout
        return view('super-admin.dashboard', compact(
            'totalUsers', 
            'newUsersThisMonth', 
            'suspendedUsersCount',
            'unverifiedUsersCount',
            'usersByRole', 
            'recentUsers',
            'auditLogs',
            'suspendedUsers',
            'onlineUsers'
        ));
    }

    public function getOnlineUsers()
    {
        // Online Users Monitoring (same logic as index)
        $onlineUserIds = \Illuminate\Support\Facades\Cache::get('online-users', []);
        $onlineUsers = collect();
        
        foreach ($onlineUserIds as $id) {
            $userData = \Illuminate\Support\Facades\Cache::get('user-online-' . $id);
            if ($userData) {
                // Calculate status based on last activity
                $lastActivity = \Illuminate\Support\Carbon::createFromTimestamp($userData['last_activity']);
                $userData['status'] = $lastActivity->diffInMinutes(now()) < 5 ? 'Online' : 'Idle';
                $userData['last_activity_human'] = $lastActivity->diffForHumans();
                $onlineUsers->push((object) $userData);
            }
        }

        return response()->json($onlineUsers);
    }
}
