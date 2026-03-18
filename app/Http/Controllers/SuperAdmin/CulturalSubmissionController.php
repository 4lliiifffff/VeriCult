<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\User;
use App\Notifications\SubmissionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CulturalSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = CulturalSubmission::with(['user', 'reviewedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            CulturalSubmission::STATUS_SUBMITTED,
            CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
            CulturalSubmission::STATUS_FIELD_VERIFICATION,
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED,
            CulturalSubmission::STATUS_REJECTED,
            CulturalSubmission::STATUS_REVISION,
        ];

        return view('super-admin.cultural-submissions.index', compact('submissions', 'categories', 'statuses'));
    }

    public function show(CulturalSubmission $submission)
    {
        $submission->load(['user', 'files', 'reviewedBy', 'administrativeReviews', 'fieldVerifications']);
        return view('super-admin.cultural-submissions.show', compact('submission'));
    }

    public function edit(CulturalSubmission $submission)
    {
        $categories = CulturalSubmission::CATEGORIES;
        $fields = $submission->getCategoryFields($submission->category);
        return view('super-admin.cultural-submissions.edit', compact('submission', 'categories', 'fields'));
    }

    public function update(Request $request, CulturalSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', [
                CulturalSubmission::STATUS_PUBLISHED,
                CulturalSubmission::STATUS_VERIFIED,
                CulturalSubmission::STATUS_REJECTED,
            ]),
        ]);

        $submission->status = $validated['status'];
        $submission->save();

        // Notify the Pengusul
        $actionTitles = [
            CulturalSubmission::STATUS_PUBLISHED => 'Pengajuan Dipublikasikan (Super Admin)',
            CulturalSubmission::STATUS_VERIFIED => 'Publikasi Ditarik (Dikembalikan ke Verified)',
            CulturalSubmission::STATUS_REJECTED => 'Pengajuan Ditolak (Super Admin)'
        ];
        $actionTypes = [
            CulturalSubmission::STATUS_PUBLISHED => 'success',
            CulturalSubmission::STATUS_VERIFIED => 'warning',
            CulturalSubmission::STATUS_REJECTED => 'error'
        ];
        
        $title = $actionTitles[$submission->status] ?? 'Update Status Super Admin';
        $message = 'Status pengajuan "' . $submission->name . '" telah diubah menjadi ' . $submission->status_label . ' oleh Super Admin.';
        $url = route('pengusul.submissions.show', $submission);
        
        $submission->user->notify(new SubmissionNotification($title, $message, $url, $actionTypes[$submission->status] ?? 'info', $submission->id));

        return redirect()->route('super-admin.cultural-submissions.show', $submission)
            ->with('success', 'Status publikasi data kebudayaan berhasil diperbarui.');
    }

    public function destroy(CulturalSubmission $submission)
    {
        // For safety, Super Admin can delete if absolutely necessary
        foreach ($submission->files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
        
        $submission->delete();

        return redirect()->route('super-admin.cultural-submissions.index')
            ->with('success', 'Data kebudayaan berhasil dihapus.');
    }
}
