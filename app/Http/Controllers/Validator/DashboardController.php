<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the validator dashboard.
     */
    public function index()
    {
        $stats = [
            'total_submitted' => CulturalSubmission::where('status', CulturalSubmission::STATUS_SUBMITTED)
                ->whereNull('reviewed_by')
                ->count(),
            'my_reviews' => CulturalSubmission::where('reviewed_by', Auth::id())
                ->where('status', CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                ->count(),
            'needs_revision' => CulturalSubmission::where('status', CulturalSubmission::STATUS_REVISION)->count(),
            'forwarded' => CulturalSubmission::where('status', CulturalSubmission::STATUS_FIELD_VERIFICATION)->count(),
            'rejected' => CulturalSubmission::where('status', CulturalSubmission::STATUS_REJECTED)->count(),
        ];

        $recentSubmissions = CulturalSubmission::with('user')
            ->where('status', CulturalSubmission::STATUS_SUBMITTED)
            ->latest()
            ->limit(5)
            ->get();

        // --- NEW: Dashboard Charts Data ---
        
        // 1. My Review Pipeline (Status of submissions reviewed by me)
        $myReviewStats = CulturalSubmission::where('reviewed_by', Auth::id())
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
            
        // 2. Global Category Distribution (Top performance areas)
        $categoryStats = CulturalSubmission::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        return view('validator.dashboard', compact('stats', 'recentSubmissions', 'myReviewStats', 'categoryStats'));
    }
}
