<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Pending Pengusul Desa Approvals
        $pendingApprovalsCount = User::role('pengusul-desa')
            ->whereHas('profile', fn($q) => $q->where('is_approved_by_admin', false))
            ->count();

        // 2. Statistical Submissions awaiting publication (Verified but not Published)
        $pendingPublicationCount = CulturalSubmission::where('submission_type', 'statistik')
            ->where('status', CulturalSubmission::STATUS_VERIFIED)
            ->count();
        
        // 3. Stats by Category (for Statistik)
        $categoryStats = CulturalSubmission::where('submission_type', 'statistik')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 4. Recent Statistical Submissions
        $recentStatistikalSubmissions = CulturalSubmission::where('submission_type', 'statistik')
            ->with(['user', 'village'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Recent Pending Users
        $recentPendingUsers = User::role('pengusul-desa')
            ->whereHas('profile', fn($q) => $q->where('is_approved_by_admin', false))
            ->with('profile')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingApprovalsCount',
            'pendingPublicationCount',
            'categoryStats',
            'recentStatistikalSubmissions',
            'recentPendingUsers'
        ));
    }
}
