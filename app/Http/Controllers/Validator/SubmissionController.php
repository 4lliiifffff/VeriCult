<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeReview;
use App\Models\CulturalSubmission;
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

        return view('validator.submissions.show', compact('submission'));
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

        return redirect()->back()->with('success', 'Berhasil mengklaim submission. Status kini dalam tinjauan administratif.');
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

        return redirect()->back()->with('success', 'Klaim review dibatalkan. Status dikembalikan ke Submitted.');
    }

    /**
     * Show the review workspace.
     */
    public function reviewForm(CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        $submission->load(['user', 'files', 'administrativeReviews.validator', 'fieldVerifications.validator']);

        return view('validator.submissions.review', compact('submission'));
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
        });

        return redirect()->route('validator.submissions.index')
            ->with('success', 'Verifikasi lapangan berhasil disimpan.');
    }
}
