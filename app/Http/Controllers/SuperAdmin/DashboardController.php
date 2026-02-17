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

        // Return existing view but now it will use the new layout
        return view('super-admin.dashboard', compact(
            'totalUsers', 
            'newUsersThisMonth', 
            'suspendedUsersCount',
            'unverifiedUsersCount',
            'usersByRole', 
            'recentUsers',
            'auditLogs',
            'suspendedUsers'
        ));
    }
}
