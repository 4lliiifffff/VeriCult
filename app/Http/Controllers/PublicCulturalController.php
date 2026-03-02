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
        $query = CulturalSubmission::published()->with('files');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $submissions = $query->latest('published_at')->paginate(12);

        $categories = CulturalSubmission::CATEGORIES;
        $activeCategory = $request->category;

        return view('profil-kebudayaan.index', compact('submissions', 'categories', 'activeCategory'));
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
