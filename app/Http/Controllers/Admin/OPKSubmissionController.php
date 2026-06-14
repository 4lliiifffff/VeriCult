<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SubmissionNotification;

class OPKSubmissionController extends Controller
{
    /**
     * Display a listing of OPK submissions.
     */
    public function index(Request $request)
    {
        $query = CulturalSubmission::query()
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
     * Display the specific cultural submission.
     */
    public function show(CulturalSubmission $submission)
    {
        $submission->load(['user', 'files', 'reviewedBy', 'administrativeReviews', 'fieldVerifications']);
        return view('admin.opk-submissions.show', compact('submission'));
    }

    /**
     * Update the status (Publish/Unpublish) of the OPK submission.
     */
    public function updateStatus(Request $request, CulturalSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', [
                CulturalSubmission::STATUS_PUBLISHED,
                CulturalSubmission::STATUS_VERIFIED,
            ]),
        ]);

        $submission->status = $validated['status'];
        $submission->reviewed_by = Auth::id();
        $submission->save();

        // Notify the Pengusul
        $actionTitles = [
            CulturalSubmission::STATUS_PUBLISHED => 'Pengajuan Dipublikasikan',
            CulturalSubmission::STATUS_VERIFIED => 'Publikasi Ditarik'
        ];

        $title = $actionTitles[$submission->status] ?? 'Update Status Pengajuan';
        $message = 'Pengajuan "' . $submission->name . '" telah ' . ($submission->status === CulturalSubmission::STATUS_PUBLISHED ? 'dipublikasikan' : 'ditarik dari publikasi') . ' oleh Admin.';
        $url = $submission->submission_type === 'opk'
            ? route('pengusul-desa.opk-submissions.show', $submission)
            : route('pengusul.submissions.show', $submission);

        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));

        return back()->with('success', 'Status publikasi pengajuan berhasil diperbarui.');
    }
}
