<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use App\Notifications\SubmissionNotification;

class OPKSubmissionController extends Controller
{
    /**
     * Display a listing of OPK submissions.
     */
    public function index(Request $request)
    {
        $query = CulturalSubmission::where('submission_type', 'opk')
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

        return view('admin.opk-submissions.index', compact('submissions', 'categories', 'statuses'));
    }

    /**
     * Display the specific OPK submission.
     */
    public function show(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'opk') {
            abort(403, 'Akses ditolak. Pengolah ini hanya untuk data opk.');
        }

        $submission->load(['user', 'files', 'reviewedBy', 'administrativeReviews', 'fieldVerifications']);
        return view('admin.opk-submissions.show', compact('submission'));
    }

    /**
     * Update the status (Publish/Unpublish) of the OPK submission.
     */
    public function updateStatus(Request $request, CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'opk') {
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
            CulturalSubmission::STATUS_PUBLISHED => 'Laporan opk Dipublikasikan',
            CulturalSubmission::STATUS_VERIFIED => 'Publikasi opk Ditarik'
        ];
        
        $title = $actionTitles[$submission->status] ?? 'Update Status opk';
        $message = 'Laporan opk "' . $submission->name . '" telah ' . ($submission->status === CulturalSubmission::STATUS_PUBLISHED ? 'dipublikasikan' : 'ditarik dari publikasi') . ' oleh Admin.';
        $url = route('pengusul-desa.opk-submissions.show', $submission);
        
        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));

        return back()->with('success', 'Status publikasi laporan opk berhasil diperbarui.');
    }
}
