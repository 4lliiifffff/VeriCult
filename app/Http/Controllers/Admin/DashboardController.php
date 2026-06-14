<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CulturalSubmission;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. General Metrics
        $totalUsers = User::count('*');

        $pendingApprovalsCount = User::role('pengusul-desa')
            ->whereHas('pengusulDesaProfile', fn($q) => $q->where('is_approved_by_admin', false))
            ->count();

        // 2. Cultural Submission Metrics
        $totalOPK = CulturalSubmission::count('*');

        $pendingPublicationCount = CulturalSubmission::where('status', '=', CulturalSubmission::STATUS_VERIFIED, 'and')
            ->count('*');

        $publishedOPKCount = CulturalSubmission::where('status', '=', CulturalSubmission::STATUS_PUBLISHED, 'and')
            ->count('*');

        // 3. Wilayah Metrics
        $totalKecamatan = \App\Models\Kecamatan::count('*');
        $totalDesa = \App\Models\Village::count('*');

        // 4. OPK Distribution by Kecamatan
        $kecamatanOPKDistribution = DB::table('kecamatans')
            ->leftJoin('villages', 'kecamatans.id', '=', 'villages.kecamatan_id')
            ->leftJoin('cultural_submissions', function($join) {
                $join->on('villages.id', '=', 'cultural_submissions.village_id')
                     ->where('cultural_submissions.submission_type', '=', 'opk');
            })
            ->select('kecamatans.name', DB::raw('count(cultural_submissions.id) as count'))
            ->groupBy('kecamatans.id', 'kecamatans.name')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // 5. Recent Cultural Submissions
        $recentOPKSubmissions = CulturalSubmission::with(['user', 'village'])
            ->latest()
            ->take(5)
            ->get();

        // 6. Recent Pending Users
        $recentPendingUsers = User::role('pengusul-desa')
            ->whereHas('pengusulDesaProfile', fn($q) => $q->where('is_approved_by_admin', false))
            ->with('pengusulDesaProfile.village')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingApprovalsCount',
            'totalOPK',
            'pendingPublicationCount',
            'publishedOPKCount',
            'totalKecamatan',
            'totalDesa',
            'kecamatanOPKDistribution',
            'recentOPKSubmissions',
            'recentPendingUsers'
        ));
    }
}
