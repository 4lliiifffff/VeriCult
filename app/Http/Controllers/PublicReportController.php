<?php

namespace App\Http\Controllers;

use App\Models\CulturalSubmission;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    /**
     * Print the public report.
     */
    public function print(Request $request)
    {
        if (!$request->has('year') || $request->input('year') === null || $request->input('year') === '') {
            $activeYear = 'all';
        } else {
            $activeYear = $request->input('year');
        }

        $query = CulturalSubmission::published();

        if (!empty($activeYear) && $activeYear !== 'all') {
            $query->where('period_year', $activeYear);
        }

        $submissions = $query->latest('published_at')->get();
        $categoryStats = $submissions->groupBy('category')->map->count();

        return view('public-reports.print', compact('submissions', 'activeYear', 'categoryStats'));
    }
}
