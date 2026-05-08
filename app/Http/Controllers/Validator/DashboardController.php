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
        // Ambil semua tahun dari YEAR(created_at) agar data lama (period_year NULL) ikut muncul
        $availableYears = CulturalSubmission::selectRaw('YEAR(created_at) as yr')
            ->groupBy('yr')
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->map(fn($y) => (int)$y)
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        // Jika tidak ada year dipilih (atau ""), tampilkan semua periode
        $activeYear = request('year');
        $activeYear = ($activeYear !== null && $activeYear !== '') ? (int)$activeYear : null;

        // Base query: filter per tahun jika dipilih, atau semua data jika tidak dipilih
        $yearQuery = CulturalSubmission::when(
            $activeYear,
            fn($q) => $q->whereRaw('YEAR(created_at) = ?', [$activeYear])
        );

        $stats = [
            'total_submitted' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_SUBMITTED)
                ->whereNull('reviewed_by')
                ->count(),
            'my_reviews' => (clone $yearQuery)->where('reviewed_by', Auth::id())
                ->where('status', CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                ->count(),
            'needs_revision' => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_REVISION)->count(),
            'forwarded'      => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_FIELD_VERIFICATION)->count(),
            'rejected'       => (clone $yearQuery)->where('status', CulturalSubmission::STATUS_REJECTED)->count(),
            'my_submissions' => CulturalSubmission::ownedBy(Auth::id())->count(),
        ];

        // Antrean verifikasi: ikut filter tahun jika dipilih, batas 10
        $recentSubmissions = (clone $yearQuery)
            ->with('user')
            ->where('status', CulturalSubmission::STATUS_SUBMITTED)
            ->latest()
            ->limit(10)
            ->get();

        // --- Dashboard Charts Data ---

        // 1. My Review Pipeline
        $myReviewStats = (clone $yearQuery)->where('reviewed_by', Auth::id())
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // 2. Global Category Distribution
        $categoryStats = (clone $yearQuery)
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 3. Tren Pertumbuhan — 5 tahun ke belakang dari tahun terbaru
        $latestYear = CulturalSubmission::max(DB::raw('YEAR(created_at)')) ?? (int)date('Y');
        $startYear  = $latestYear - 4;

        $yearlyRaw = CulturalSubmission::selectRaw('YEAR(created_at) as yr, count(*) as count')
            ->whereRaw('YEAR(created_at) BETWEEN ? AND ?', [$startYear, $latestYear])
            ->groupBy('yr')
            ->orderBy('yr', 'asc')
            ->pluck('count', 'yr');

        // Isi tahun tanpa data dengan 0 agar sumbu X lengkap
        $yearlyComparison = collect(range($startYear, $latestYear))
            ->mapWithKeys(fn($y) => [$y => (int)$yearlyRaw->get($y, 0)]);

        // 4. Review Distribution by Village
        $villageReviewStats = (clone $yearQuery)->where('reviewed_by', Auth::id())
            ->join('villages', 'cultural_submissions.village_id', '=', 'villages.id')
            ->select('villages.name', DB::raw('count(*) as count'))
            ->groupBy('villages.name')
            ->get()
            ->pluck('count', 'name')
            ->toArray();

        // 5. Active Culture Categories
        $aktifSubmissions = (clone $yearQuery)->where('submission_type', 'aktif')->get();
        $aktifCategoryStats = [];
        foreach ($aktifSubmissions as $sub) {
            $cat = $sub->category_data['kategori_opk'] ?? 'Lainnya';
            $aktifCategoryStats[$cat] = ($aktifCategoryStats[$cat] ?? 0) + 1;
        }

        return view('validator.dashboard', compact(
            'stats', 'recentSubmissions', 'myReviewStats', 'categoryStats',
            'availableYears', 'activeYear', 'yearlyComparison',
            'villageReviewStats', 'aktifCategoryStats'
        ));
    }
}
