<?php

namespace App\Http\Controllers\Users\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

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

        return view('pengusul.dashboard', compact(
            'totalSubmissions',
            'draftCount',
            'inReviewCount',
            'publishedCount',
            'rejectedCount',
            'recentSubmissions'
        ));
    }
}
