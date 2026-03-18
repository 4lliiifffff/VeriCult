<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\AuditLog;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Unverified Users (Email)
        $unverifiedUsersCount = User::whereNull('email_verified_at')->count();

        // Pending Pengusul Desa Approvals
        $pendingApprovalsCount = User::role('pengusul-desa')
            ->where('is_approved_by_admin', false)
            ->whereNotNull('email_verified_at')
            ->count();

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

        // --- Dashboard Charts Data ---

        // Get available years
        $availableYears = CulturalSubmission::select('period_year')
            ->whereNotNull('period_year')
            ->distinct()
            ->orderBy('period_year', 'desc')
            ->pluck('period_year')
            ->toArray();

        // If availableYears is empty, fallback to current year
        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        $defaultYear = $availableYears[0];
        $activeYear = request('year', $defaultYear);

        // Base query filtered by year
        $yearQuery = CulturalSubmission::where('period_year', $activeYear);

        // Basic Stats for active year
        $totalSubmissionsThisYear = (clone $yearQuery)->count();
        $verifiedThisYear = (clone $yearQuery)->where('status', CulturalSubmission::STATUS_VERIFIED)->count();
        $publishedThisYear = (clone $yearQuery)->where('status', CulturalSubmission::STATUS_PUBLISHED)->count();

        // 1. Status Distribution Chart
        $statusStats = (clone $yearQuery)->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        
        // 2. Category Distribution Chart (11 Categories)
        $categoryStats = (clone $yearQuery)->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 3. Monthly Trend (For selected year)
        $monthlyTrend = (clone $yearQuery)->select(
            DB::raw('DATE_FORMAT(created_at, "%b") as month_name'),
            DB::raw('MONTH(created_at) as month_num'),
            DB::raw('count(*) as count')
        )
        ->groupBy('month_name', 'month_num')
        ->orderBy('month_num', 'asc')
        ->get();

        // 4. Yearly Comparison
        $yearlyComparison = CulturalSubmission::select(
            'period_year',
            DB::raw('count(*) as count')
        )
        ->whereNotNull('period_year')
        ->groupBy('period_year')
        ->orderBy('period_year', 'asc')
        ->get();

        // Return existing view with charts data
        return view('super-admin.dashboard', compact(
            'totalUsers', 
            'newUsersThisMonth', 
            'suspendedUsersCount',
            'unverifiedUsersCount',
            'pendingApprovalsCount',
            'usersByRole', 
            'recentUsers',
            'auditLogs',
            'suspendedUsers',
            'onlineUsers',
            'availableYears',
            'activeYear',
            'totalSubmissionsThisYear',
            'verifiedThisYear',
            'publishedThisYear',
            'statusStats',
            'categoryStats',
            'monthlyTrend',
            'yearlyComparison'
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
