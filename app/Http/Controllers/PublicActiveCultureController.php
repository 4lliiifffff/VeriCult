<?php

namespace App\Http\Controllers;

use App\Models\CulturalSubmission;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class PublicActiveCultureController extends Controller
{
    /**
     * Display the public active culture feed.
     */
    public function index(Request $request)
    {
        $query = CulturalSubmission::with(['files', 'user', 'village.kecamatan'])
            ->published()
            ->where('category', CulturalSubmission::CATEGORY_LAPORAN_AKTIF);

        // Filter by search keyword
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by kecamatan
        if ($request->filled('kecamatan')) {
            $query->whereHas('village.kecamatan', function ($q) use ($request) {
                $q->where('id', $request->kecamatan);
            });
        }

        // Sort order
        $sort = $request->input('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest('published_at');
        } else {
            $query->latest('published_at');
        }

        $posts = $query->paginate(12)->withQueryString();
        $totalCount = CulturalSubmission::published()
            ->where('category', CulturalSubmission::CATEGORY_LAPORAN_AKTIF)
            ->count();

        $kecamatans = Kecamatan::orderBy('name')->get();

        return view('kebudayaan-aktif.index', compact('posts', 'totalCount', 'kecamatans'));
    }

    /**
     * Display a single active culture post.
     */
    public function show(string $slug)
    {
        $post = CulturalSubmission::with(['files', 'user', 'village.kecamatan'])
            ->published()
            ->where('category', CulturalSubmission::CATEGORY_LAPORAN_AKTIF)
            ->where('slug', $slug)
            ->firstOrFail();

        // Related posts from same area or similar
        $related = CulturalSubmission::with(['files'])
            ->published()
            ->where('category', CulturalSubmission::CATEGORY_LAPORAN_AKTIF)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $categoryFields = CulturalSubmission::getFlatCategoryFields(
            $post->category,
            $post->getSubCategory()
        );

        return view('kebudayaan-aktif.show', compact('post', 'related', 'categoryFields'));
    }
}
