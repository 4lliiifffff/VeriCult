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

        $submissions = $query->latest()->paginate(10)->withQueryString();

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
        // Determine the correct redirect URL based on category
        $isCagarBudaya = ($submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA || 
                         $submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA);
        
        $routeName = $isCagarBudaya 
            ? 'pengusul-desa.cagar-budaya-submissions.show' 
            : 'pengusul-desa.submissions.show';
        
        $url = route($routeName, $submission);
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
            'action' => 'required|in:forwarded,revision,rejected,verified',
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
                'verified' => CulturalSubmission::STATUS_VERIFIED,
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
                'verified' => 'Validasi Pengajuan Disetujui',
                'revision' => 'Revisi Diperlukan (Administratif)',
                'rejected' => 'Pengajuan Ditolak (Administratif)'
            ];
            $actionTypes = [
                'forwarded' => 'success',
                'verified' => 'success',
                'revision' => 'warning',
                'rejected' => 'error'
            ];
            
            $title = $actionTitles[$request->action] ?? 'Update Review';
            $message = 'Hasil Review Administratif untuk "' . $submission->name . '" telah diperbarui.';
            
            // Determine the correct redirect URL based on category
            $isCagarBudaya = ($submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA || 
                             $submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA);
            
            $routeName = $isCagarBudaya 
                ? 'pengusul-desa.cagar-budaya-submissions.show' 
                : 'pengusul-desa.submissions.show';
            
            $url = route($routeName, $submission);
            
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

        $rules = [
            'visit_date' => 'required|date',
            'verified_latitude' => 'nullable|numeric|between:-90,90',
            'verified_longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'required|string|min:10',
            'recommendation' => 'required|in:verified,rejected,revision',
            'category_data' => 'nullable|array',
        ];

        // Add category-specific validation
        $subCat = $submission->getSubCategory();
        $flatFields = CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
        foreach ($flatFields as $key => $field) {
            $rules["category_data.{$key}"] = ['nullable', 'string', 'max:10000'];
            // Also allow "lainnya" fields
            $rules["category_data.{$key}_lainnya"] = ['nullable', 'string', 'max:5000'];
        }
        
        // Ensure sub-category field is also allowed
        if ($submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA || $submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA) {
            $rules["category_data.jenis_cagar_budaya"] = ['nullable', 'string'];
        }

        $request->validate($rules);

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

            // Update submission status and category_data
            $categoryData = $request->input('category_data', []);
            $categoryData = array_filter($categoryData, function($v) {
                if (is_array($v)) return !empty($v);
                return !is_null($v) && $v !== '';
            });

            // Merge with existing category data to not lose fields like unesco_categories or files
            $existingCategoryData = $submission->category_data ?? [];
            $mergedCategoryData = array_merge($existingCategoryData, $categoryData);

            $updateData = [
                'status' => $status,
                'category_data' => !empty($mergedCategoryData) ? $mergedCategoryData : null,
                'verified_at' => $status === CulturalSubmission::STATUS_VERIFIED ? now() : null,
            ];

            // Transition from Potensi Cagar Budaya to Cagar Budaya if verified
            if ($status === CulturalSubmission::STATUS_VERIFIED && $submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA) {
                $updateData['category'] = CulturalSubmission::CATEGORY_CAGAR_BUDAYA;
                
                // If validator provided a new name in category_data, use it
                if (isset($mergedCategoryData['nama_objek']) && !empty($mergedCategoryData['nama_objek'])) {
                    $updateData['name'] = $mergedCategoryData['nama_objek'];
                }
            }

            $submission->update($updateData);

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
            
            // Determine the correct redirect URL based on category
            $isCagarBudaya = ($submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA || 
                             $submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA);
            
            $routeName = $isCagarBudaya 
                ? 'pengusul-desa.cagar-budaya-submissions.show' 
                : 'pengusul-desa.submissions.show';
            
            $url = route($routeName, $submission);
            
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
        
        // Determine the correct redirect URL based on category
        $isCagarBudaya = ($submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA || 
                         $submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA);
        
        $routeName = $isCagarBudaya 
            ? 'pengusul-desa.cagar-budaya-submissions.show' 
            : 'pengusul-desa.submissions.show';
            
        $url = route($routeName, $submission);
        $submission->user->notify(new SubmissionNotification($title, $message, $url, 'success', $submission->id));

        return redirect()->route('validator.submissions.show', $submission)
            ->with('success', 'Objek kebudayaan berhasil dipublikasikan ke profil publik!');
    }

    /**
     * Show the form for editing the specified submission (only category_data).
     */
    public function edit(CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        if ($submission->status !== CulturalSubmission::STATUS_FIELD_VERIFICATION) {
            return redirect()->route('validator.submissions.review-form', $submission)
                ->with('error', 'Data hanya dapat diedit pada tahap Verifikasi Lapangan.');
        }

        $submission->load(['user', 'files']);
        
        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);
        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$submission->category] ?? '';

        return view('validator.submissions.edit', compact('submission', 'categorySlug', 'categoryFields', 'categoryDescription'));
    }

    /**
     * Update the specified submission in storage.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        Gate::authorize('review', $submission);

        if ($submission->status !== CulturalSubmission::STATUS_FIELD_VERIFICATION) {
            return redirect()->route('validator.submissions.review-form', $submission)
                ->with('error', 'Data hanya dapat diedit pada tahap Verifikasi Lapangan.');
        }

        // We only allow validators to edit category_data and description
        $rules = [
            'description' => ['nullable', 'string', 'min:50'],
        ];

        // Add category-specific validation rules
        $subCat = $submission->getSubCategory();
        $flatFields = CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
        foreach ($flatFields as $key => $field) {
            $rules["category_data.{$key}"] = ['nullable', 'string', 'max:10000'];
            $rules["category_data.{$key}_lainnya"] = ['nullable', 'string', 'max:5000'];
        }
        
        if ($submission->category === CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA || $submission->category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA) {
            $rules["category_data.jenis_cagar_budaya"] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        // Clean category_data
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name if available
        $submissionName = $submission->name;
        if (isset($categoryData['b1_nama_objek']) && !empty($categoryData['b1_nama_objek'])) {
            $submissionName = $categoryData['b1_nama_objek'];
        }
        if (isset($categoryData['nama_objek']) && !empty($categoryData['nama_objek'])) {
            $submissionName = $categoryData['nama_objek'];
        }
        if (isset($categoryData['nama_dan_jenis_kebudayaan']) && !empty($categoryData['nama_dan_jenis_kebudayaan'])) {
            $submissionName = $categoryData['nama_dan_jenis_kebudayaan'];
        }

        // Preserve unesco_categories and existing document URLs if they are not passed in form
        $existingCategoryData = $submission->category_data ?? [];
        $mergedCategoryData = array_merge($existingCategoryData, $categoryData);

        $submission->update([
            'name' => $submissionName,
            'description' => $validated['description'] ?? $submission->description,
            'category_data' => !empty($mergedCategoryData) ? $mergedCategoryData : null,
        ]);

        return redirect()->route('validator.submissions.review-form', $submission)
            ->with('success', 'Data pengajuan berhasil diperbarui.');
    }
}
