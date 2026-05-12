<?php

namespace App\Http\Controllers;

use App\Models\CulturalSubmission;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    /**
     * Display a listing of public reports filterable by year.
     */
    public function index(Request $request)
    {
        $availableYears = CulturalSubmission::select('period_year')
            ->whereNotNull('period_year')
            ->distinct()
            ->orderBy('period_year', 'desc')
            ->pluck('period_year')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        $activeYear = $request->input('year', $availableYears[0]);

        $query = CulturalSubmission::whereIn('status', [
            CulturalSubmission::STATUS_PUBLISHED,
            CulturalSubmission::STATUS_VERIFIED
        ])->where('period_year', $activeYear);

        $submissions = $query->latest('published_at')->get();

        // Stats for chart
        $categoryStats = $submissions->groupBy('category')->map->count();

        return view('public-reports.index', compact('submissions', 'availableYears', 'activeYear', 'categoryStats'));
    }

    /**
     * Print the public report.
     */
    public function print(Request $request)
    {
        $activeYear = $request->input('year', date('Y'));

        $query = CulturalSubmission::whereIn('status', [
            CulturalSubmission::STATUS_PUBLISHED,
            CulturalSubmission::STATUS_VERIFIED
        ])->where('period_year', $activeYear);

        $submissions = $query->latest('published_at')->get();
        $categoryStats = $submissions->groupBy('category')->map->count();

        return view('public-reports.print', compact('submissions', 'activeYear', 'categoryStats'));
    }
}
