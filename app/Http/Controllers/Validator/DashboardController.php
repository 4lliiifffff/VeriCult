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

        $stats = [
            'total_submitted' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_SUBMITTED)
                ->whereNull('reviewed_by')
                ->count(),
            'my_reviews' => (clone $yearQuery)->where('reviewed_by', Auth::id())
                ->where('status', CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                ->count(),
            'needs_revision' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_REVISION)->count(),
            'forwarded' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_FIELD_VERIFICATION)->count(),
            'rejected' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_REJECTED)->count(),
        ];

        $recentSubmissions = (clone $yearQuery)->with('user')
            ->where('status', CulturalSubmission::STATUS_SUBMITTED)
            ->latest()
            ->limit(5)
            ->get();

        // --- Dashboard Charts Data ---
        
        // 1. My Review Pipeline (Status of submissions reviewed by me)
        $myReviewStats = (clone $yearQuery)->where('reviewed_by', Auth::id())
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
            
        // 2. Global Category Distribution (Top performance areas)
        $categoryStats = (clone $yearQuery)->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 3. Yearly Comparison
        $yearlyComparison = CulturalSubmission::select(
            'period_year',
            DB::raw('count(*) as count')
        )
        ->whereNotNull('period_year')
        ->groupBy('period_year')
        ->orderBy('period_year', 'asc')
        ->get();

        return view('validator.dashboard', compact(
            'stats', 'recentSubmissions', 'myReviewStats', 'categoryStats',
            'availableYears', 'activeYear', 'yearlyComparison'
        ));
    }
}
