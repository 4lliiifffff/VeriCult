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
        // Get available years with published data (exclude Laporan Kebudayaan Aktif)
        $availableYears = CulturalSubmission::published()
            ->where('category', '!=', CulturalSubmission::CATEGORY_LAPORAN_AKTIF)
            ->select('period_year')
            ->whereNotNull('period_year')
            ->distinct()
            ->orderBy('period_year', 'desc')
            ->pluck('period_year')
            ->toArray();

        $defaultYear = !empty($availableYears) ? $availableYears[0] : date('Y');
        
        if (!$request->has('year')) {
            $activeYear = $defaultYear;
        } else {
            $activeYear = $request->input('year');
        }

        $query = CulturalSubmission::published()
            ->with('files')
            ->where('category', '!=', CulturalSubmission::CATEGORY_LAPORAN_AKTIF);

        // Only filter by year if it's not empty and not 'all' (Semua Periode)
        if (!empty($activeYear) && $activeYear !== 'all') {
            $query->where('period_year', $activeYear);
        }

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

        // Exclude 'Laporan Kebudayaan Aktif' — ditampilkan di feed tersendiri
        $categories = array_filter(CulturalSubmission::CATEGORIES, fn($c) => $c !== CulturalSubmission::CATEGORY_LAPORAN_AKTIF);
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

        $categoryFields = CulturalSubmission::getFlatCategoryFields($submission->category, $submission->getSubCategory());

        return view('profil-kebudayaan.show', compact('submission', 'categoryFields'));
    }
}
