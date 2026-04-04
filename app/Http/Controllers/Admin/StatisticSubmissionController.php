<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use App\Notifications\SubmissionNotification;

class StatisticSubmissionController extends Controller
{
    /**
     * Display a listing of statistical submissions.
     */
    public function index(Request $request)
    {
        $query = CulturalSubmission::where('submission_type', 'statistik')
            ->with(['user', 'reviewedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to showing only Verified (awaiting publication) and Published
            $query->whereIn('status', [
                CulturalSubmission::STATUS_VERIFIED,
                CulturalSubmission::STATUS_PUBLISHED
            ]);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $submissions = $query->latest()->paginate(10)->withQueryString();
        $categories = CulturalSubmission::CATEGORIES;
        $statuses = [
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED,
        ];

        return view('admin.statistic-submissions.index', compact('submissions', 'categories', 'statuses'));
    }

    /**
     * Display the specific statistical submission.
     */
    public function show(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'statistik') {
            abort(403, 'Akses ditolak. Pengolah ini hanya untuk data statistik.');
        }

        $submission->load(['user', 'files', 'reviewedBy', 'administrativeReviews', 'fieldVerifications']);
        return view('admin.statistic-submissions.show', compact('submission'));
    }

    /**
     * Update the status (Publish/Unpublish) of the statistical submission.
     */
    public function updateStatus(Request $request, CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'statistik') {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', [
                CulturalSubmission::STATUS_PUBLISHED,
                CulturalSubmission::STATUS_VERIFIED,
            ]),
        ]);

        $submission->status = $validated['status'];
        $submission->reviewed_by = auth()->id();
        $submission->save();

        // Notify the Pengusul
        $actionTitles = [
            CulturalSubmission::STATUS_PUBLISHED => 'Laporan Statistik Dipublikasikan',
            CulturalSubmission::STATUS_VERIFIED => 'Publikasi Statistik Ditarik'
        ];
        
        $title = $actionTitles[$submission->status] ?? 'Update Status Statistik';
        $message = 'Laporan statistik "' . $submission->name . '" telah ' . ($submission->status === CulturalSubmission::STATUS_PUBLISHED ? 'dipublikasikan' : 'ditarik dari publikasi') . ' oleh Admin.';
        $url = route('pengusul-desa.statistic-submissions.show', $submission);
        
        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));

        return back()->with('success', 'Status publikasi laporan statistik berhasil diperbarui.');
    }
}
