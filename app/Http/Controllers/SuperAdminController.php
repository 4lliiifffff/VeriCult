<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    protected $governanceService;

    public function __construct(\App\Services\GovernanceService $governanceService)
    {
        $this->governanceService = $governanceService;
    }

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
        $auditLogs = \App\Models\AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();
            
        // Suspended Users List
        $suspendedUsers = User::where('is_suspended', true)->with('roles')->get();

        return view('users.super-admin.dashboard', compact(
            'totalUsers', 
            'newUsersThisMonth', 
            'suspendedUsersCount',
            'usersByRole', 
            'recentUsers',
            'auditLogs',
            'suspendedUsers'
        ));
    }

    public function suspend(User $user)
    {
        try {
            $this->governanceService->suspendUser($user, auth()->user());
            return back()->with('success', 'User suspended successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function unsuspend(User $user)
    {
        try {
            $this->governanceService->unsuspendUser($user, auth()->user());
            return back()->with('success', 'User unsuspended successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
