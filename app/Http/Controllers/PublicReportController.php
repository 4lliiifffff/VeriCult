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
