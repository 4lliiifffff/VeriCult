<?php

namespace App\Http\Controllers\PengusulDesa;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Statistics
        $totalSubmissions = CulturalSubmission::ownedBy($userId)->count();
        $draftCount = CulturalSubmission::ownedBy($userId)->status(CulturalSubmission::STATUS_DRAFT)->count();
        $inReviewCount = CulturalSubmission::ownedBy($userId)->inReview()->count();
        $publishedCount = CulturalSubmission::ownedBy($userId)->status(CulturalSubmission::STATUS_PUBLISHED)->count();
        $rejectedCount = CulturalSubmission::ownedBy($userId)->status(CulturalSubmission::STATUS_REJECTED)->count();

        // Recent submissions
        $recentSubmissions = CulturalSubmission::ownedBy($userId)
            ->latest()
            ->take(5)
            ->get();

        // Role & Approval Info
        $isPenguslDesa = $user->hasRole('pengusul-desa');
        $isApprovedByAdmin = $user->is_approved_by_admin;
        $hasStatistikAccess = $isPenguslDesa && $isApprovedByAdmin;

        // Statistics for submission types
        $activeCultureCount = CulturalSubmission::ownedBy($userId)
            ->where('submission_type', 'aktif')
            ->count();
        $statistikCount = CulturalSubmission::ownedBy($userId)
            ->where('submission_type', 'statistik')
            ->count();

        return view('pengusul-desa.dashboard', compact(
            'totalSubmissions',
            'draftCount',
            'inReviewCount',
            'publishedCount',
            'rejectedCount',
            'recentSubmissions',
            'isPenguslDesa',
            'isApprovedByAdmin',
            'hasStatistikAccess',
            'activeCultureCount',
            'statistikCount'
        ));
    }
}
