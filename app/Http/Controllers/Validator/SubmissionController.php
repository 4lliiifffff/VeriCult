<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeReview;
use App\Models\CulturalSubmission;
use App\Notifications\SubmissionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SubmissionController extends Controller
{
    /**
     * Display a listing of submissions.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', CulturalSubmission::class);

        $query = CulturalSubmission::with(['user', 'reviewedBy']);

        // Only show submitted or in-review status for validator
        $query->whereIn('status', [
            CulturalSubmission::STATUS_SUBMITTED,
            CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
            CulturalSubmission::STATUS_FIELD_VERIFICATION,
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED,
            CulturalSubmission::STATUS_REVISION,
            CulturalSubmission::STATUS_REJECTED
        ]);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('claimed')) {
            if ($request->claimed === 'yes') {
                $query->whereNotNull('reviewed_by');
            } else {
                $query->whereNull('reviewed_by');
            }
        }

        if ($request->filled('by_me')) {
            $query->where('reviewed_by', Auth::id());
        }

        $submissions = $query->latest()->paginate(10);

        return view('validator.submissions.index', compact('submissions'));
    }

    /**
     * Display the specified submission.
     */
    public function show(CulturalSubmission $submission)
    {
        Gate::authorize('view', $submission);

        $submission->load(['user', 'files', 'reviewedBy', 'administrativeReviews.validator']);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);

        return view('validator.submissions.show', compact('submission', 'categoryFields'));
    }

    /**
     * Claim a submission for review.
     */
    public function claim(CulturalSubmission $submission)
    {
        Gate::authorize('claim', $submission);

        $submission->update([
            'reviewed_by' => Auth::id(),
            'review_started_at' => now(),
            'status' => CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
        ]);

        // Notify the Pengusul
        $title = 'Pengajuan Diproses';
        $message = 'Pengajuan "' . $submission->name . '" Anda sedang ditinjau oleh Validator.';
        $url = route('pengusul.submissions.show', $submission);
        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));

        return redirect()->route('validator.submissions.review-form', $submission)
            ->with('success', 'Berhasil mengklaim submission. Anda kini berada di ruang kerja review.');
    }

    /**
     * Unclaim a submission.
     */
    public function unclaim(CulturalSubmission $submission)
    {
        Gate::authorize('unclaim', $submission);

        $submission->update([
            'reviewed_by' => null,
            'review_started_at' => null,
            'status' => CulturalSubmission::STATUS_SUBMITTED,
        ]);

        return redirect()->back()->with('success', 'Klaim review dibatalkan. Status dikembalikan ke Diajukan.');
    }

    /**
     * Show the review workspace.
     */
    public function reviewForm(CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        $submission->load(['user', 'files', 'administrativeReviews.validator', 'fieldVerifications.validator']);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);

        return view('validator.submissions.review', compact('submission', 'categoryFields'));
    }

    /**
     * Store an administrative review.
     */
    public function review(Request $request, CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        $request->validate([
            'action' => 'required|in:forwarded,revision,rejected',
            'notes' => 'required|string|min:10',
        ]);

        DB::transaction(function () use ($request, $submission) {
            // Create review record
            AdministrativeReview::create([
                'submission_id' => $submission->id,
                'validator_id' => Auth::id(),
                'action' => $request->action,
                'notes' => $request->notes,
            ]);

            // Map action to status
            $status = match ($request->action) {
                'forwarded' => CulturalSubmission::STATUS_FIELD_VERIFICATION,
                'revision' => CulturalSubmission::STATUS_REVISION,
                'rejected' => CulturalSubmission::STATUS_REJECTED,
            };

            // Update submission status
            $submission->update([
                'status' => $status,
                // We keep reviewed_by for history
            ]);

            // Notify the Pengusul
            $actionTitles = [
                'forwarded' => 'Lolos Review Administratif',
                'revision' => 'Revisi Diperlukan (Administratif)',
                'rejected' => 'Pengajuan Ditolak (Administratif)'
            ];
            $actionTypes = [
                'forwarded' => 'success',
                'revision' => 'warning',
                'rejected' => 'error'
            ];
            
            $title = $actionTitles[$request->action] ?? 'Update Review';
            $message = 'Hasil Review Administratif untuk "' . $submission->name . '" telah diperbarui.';
            $url = route('pengusul.submissions.show', $submission);
            
            $submission->user->notify(new SubmissionNotification($title, $message, $url, $actionTypes[$request->action] ?? 'info', $submission->id));
        });

        return redirect()->route('validator.submissions.index')
            ->with('success', 'Review administratif berhasil disimpan.');
    }

    /**
     * Store a field verification.
     */
    public function storeFieldVerification(Request $request, CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        $request->validate([
            'visit_date' => 'required|date',
            'verified_latitude' => 'nullable|numeric|between:-90,90',
            'verified_longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'required|string|min:10',
            'recommendation' => 'required|in:verified,rejected,revision',
        ]);

        DB::transaction(function () use ($request, $submission) {
            // Create field verification record
            \App\Models\FieldVerification::create([
                'submission_id' => $submission->id,
                'validator_id' => Auth::id(),
                'visit_date' => $request->visit_date,
                'verified_latitude' => $request->verified_latitude,
                'verified_longitude' => $request->verified_longitude,
                'notes' => $request->notes,
                'recommendation' => $request->recommendation,
            ]);

            // Map recommendation to status
            $status = match ($request->recommendation) {
                'verified' => CulturalSubmission::STATUS_VERIFIED,
                'revision' => CulturalSubmission::STATUS_REVISION,
                'rejected' => CulturalSubmission::STATUS_REJECTED,
            };

            // Update submission status
            $submission->update([
                'status' => $status,
                'verified_at' => $status === CulturalSubmission::STATUS_VERIFIED ? now() : null,
            ]);

            // Notify the Pengusul
            $actionTitles = [
                'verified' => 'Verifikasi Lapangan Disetujui',
                'revision' => 'Revisi Diperlukan (Lapangan)',
                'rejected' => 'Pengajuan Ditolak (Lapangan)'
            ];
            $actionTypes = [
                'verified' => 'success',
                'revision' => 'warning',
                'rejected' => 'error'
            ];
            
            $title = $actionTitles[$request->recommendation] ?? 'Update Verifikasi';
            $message = 'Hasil Verifikasi Lapangan untuk "' . $submission->name . '" telah diperbarui.';
            $url = route('pengusul.submissions.show', $submission);
            
            $submission->user->notify(new SubmissionNotification($title, $message, $url, $actionTypes[$request->recommendation] ?? 'info', $submission->id));
        });

        return redirect()->route('validator.submissions.index')
            ->with('success', 'Verifikasi lapangan berhasil disimpan.');
    }

    /**
     * Publish a verified submission.
     */
    public function publish(CulturalSubmission $submission)
    {
        Gate::authorize('publish', $submission);

        if ($submission->status !== CulturalSubmission::STATUS_VERIFIED) {
            return redirect()->back()->with('error', 'Hanya pengajuan berstatus "Diverifikasi" yang dapat dipublikasikan.');
        }

        $submission->update([
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'slug' => CulturalSubmission::generateUniqueSlug($submission->name),
            'published_at' => now(),
        ]);

        // Notify the Pengusul
        $title = 'Pengajuan Dipublikasikan!';
        $message = 'Selamat! Objek budaya "' . $submission->name . '" telah resmi dipublikasikan.';
        $url = route('pengusul.submissions.show', $submission);
        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'success', $submission->id));

        return redirect()->route('validator.submissions.show', $submission)
            ->with('success', 'Objek kebudayaan berhasil dipublikasikan ke profil publik!');
    }
}
