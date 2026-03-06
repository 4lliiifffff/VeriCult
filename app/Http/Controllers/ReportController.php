<?php

namespace App\Http\Controllers;

use App\Models\CulturalSubmission;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the validated cultural submissions.
     */
    public function index(Request $request)
    {
        $categories = CulturalSubmission::CATEGORIES;
        $activeCategory = $request->input('category');

        $query = CulturalSubmission::published()->with(['user']);

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $submissions = $query->latest('published_at')->get();

        // Determine view based on user role for proper layout
        if (auth()->user()->hasRole('super-admin')) {
            return view('super-admin.reports.index', compact('submissions', 'categories', 'activeCategory'));
        } elseif (auth()->user()->hasRole('validator')) {
            return view('validator.reports.index', compact('submissions', 'categories', 'activeCategory'));
        }

        // Fallback
        abort(403, 'Unauthorized access to reports.');
    }

    /**
     * Print a summary of the validated cultural submissions.
     */
    public function print(Request $request)
    {
        $activeCategory = $request->input('category');

        $query = CulturalSubmission::published()->with(['user']);

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $submissions = $query->latest('published_at')->get();

        // Group submissions by category for the report
        $groupedSubmissions = $submissions->groupBy('category');

        return view('reports.print-summary', compact('groupedSubmissions', 'activeCategory'));
    }
}
