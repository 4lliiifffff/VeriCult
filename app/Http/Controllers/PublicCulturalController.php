<?php

namespace App\Http\Controllers;

use App\Models\CulturalSubmission;
use Illuminate\Http\Request;

class PublicCulturalController extends Controller
{
    /**
     * Display the public gallery of cultural objects.
     */
    public function index(Request $request)
    {
        // Get available years with published data
        $availableYears = CulturalSubmission::published()
            ->select('period_year')
            ->whereNotNull('period_year')
            ->distinct()
            ->orderBy('period_year', 'desc')
            ->pluck('period_year')
            ->toArray();

        // Default to the latest year available, or current year if none
        $defaultYear = !empty($availableYears) ? $availableYears[0] : date('Y');
        $activeYear = $request->input('year', $defaultYear);

        $query = CulturalSubmission::published()
            ->where('period_year', $activeYear)
            ->with('files');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Append query strings so pagination links keep the filters
        $submissions = $query->latest('published_at')->paginate(12)->withQueryString();

        $categories = CulturalSubmission::CATEGORIES;
        $activeCategory = $request->category;

        return view('profil-kebudayaan.index', compact(
            'submissions', 'categories', 'activeCategory',
            'availableYears', 'activeYear', 'defaultYear'
        ));
    }

    /**
     * Display the public detail of a cultural object.
     */
    public function show($slug)
    {
        $submission = CulturalSubmission::published()
            ->where('slug', $slug)
            ->with(['files', 'user'])
            ->firstOrFail();

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);

        return view('profil-kebudayaan.show', compact('submission', 'categoryFields'));
    }
}
