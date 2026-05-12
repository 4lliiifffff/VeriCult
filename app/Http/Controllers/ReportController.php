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
        abort(403, 'Anda Tidak Memiliki Akses');
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

    /**
     * Print a comprehensive report (Overall, Kecamatan, Desa).
     */
    public function printComprehensive(Request $request)
    {
        $activeYear = $request->input('year');
        if ($activeYear === null) {
            $activeYear = date('Y');
        }

        // Query only validated/published data
        $query = CulturalSubmission::with(['user', 'village.kecamatan'])
            ->whereIn('status', [CulturalSubmission::STATUS_PUBLISHED, CulturalSubmission::STATUS_VERIFIED]);

        if (!empty($activeYear)) {
            $query->where('period_year', $activeYear);
        }

        $submissions = $query->get();

        // 1. Overall Stats
        $totalSubmissions = $submissions->count();
        $categoryStats = $submissions->groupBy('category')->map->count();

        // 2. Kecamatan Stats
        $kecamatanStats = $submissions->groupBy(function($sub) {
            return $sub->village->kecamatan->name ?? 'Tanpa Wilayah';
        })->map->count()->sortDesc();

        $topKecamatan = $kecamatanStats->keys()->first();
        $topKecamatanCount = $kecamatanStats->first();

        // 3. Desa Stats
        $desaStats = $submissions->groupBy(function($sub) {
            return $sub->village->name ?? 'Tanpa Desa';
        })->map->count()->sortDesc();

        $topDesa = $desaStats->keys()->first();
        $topDesaCount = $desaStats->first();

        // Auto-generated Analysis Text
        $analysisText = [
            'overall' => "Pada tahun {$activeYear}, terdapat total {$totalSubmissions} data kebudayaan tervalidasi.",
            'kecamatan' => $totalSubmissions > 0 && $topKecamatan ? "Kecamatan dengan kontribusi pengajuan data terbanyak adalah Kecamatan {$topKecamatan} dengan total {$topKecamatanCount} data." : "Belum ada persebaran data per kecamatan yang valid.",
            'desa' => $totalSubmissions > 0 && $topDesa ? "Sedangkan pada tingkat desa/kelurahan, Desa {$topDesa} menjadi penyumbang data terbanyak dengan {$topDesaCount} usulan." : "Belum ada persebaran data per desa yang valid."
        ];

        return view('reports.print-comprehensive', compact(
            'activeYear',
            'submissions',
            'totalSubmissions',
            'categoryStats',
            'kecamatanStats',
            'desaStats',
            'analysisText'
        ));
    }
}
