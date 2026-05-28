<?php

namespace App\Http\Controllers\PengusulDesa;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\SubmissionNotification;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class PotensiSubmissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (!Auth::check() || !Auth::user()->hasRole('pengusul-desa')) {
                    abort(403, 'Hanya pengusul desa yang dapat membuat laporan Potensi Kebudayaan.');
                }
    
                if (!Auth::user()->is_approved_by_admin) {
                    abort(403, 'Akun Anda sedang menunggu persetujuan dari super admin.');
                }
    
                return $next($request);
            }
        ];
    }

    /**
     * Display a listing of Potensi Kebudayaan submissions.
     */
    public function index()
    {
        $submissions = CulturalSubmission::ownedBy(Auth::id())
            ->where('submission_type', 'potensi-kebudayaan')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pengusul-desa.potensi-submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new Potensi Kebudayaan submission.
     */
    public function create()
    {
        $categoryName = CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN;
        $categorySlug = 'potensi-kebudayaan';
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$categoryName] ?? '';

        return view('pengusul-desa.potensi-submissions.create', compact(
            'categoryName',
            'categorySlug',
            'categoryFields',
            'categoryDescription'
        ));
    }

    /**
     * Store a newly created Potensi Kebudayaan submission.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'period_year' => ['nullable', 'string'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        $categoryName = CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN;
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        
        if (!empty($categoryFields['has_sub'])) {
            $subField = $categoryFields['sub_field'] ?? 'sub_category';
            $rules["category_data.{$subField}"] = ['required', 'string'];
        }

        $flatFields = CulturalSubmission::getFlatCategoryFields($categoryName);
        foreach ($flatFields as $key => $field) {
            $is_array = isset($field['type']) && in_array($field['type'], ['checkbox_group', 'dynamic_table']);
            $rules["category_data.{$key}"] = ['nullable', $is_array ? 'array' : 'string', 'max:5000'];
        }

        $messages = [
            'files.required' => 'Anda wajib mengunggah setidaknya 1 file dokumentasi.',
            'files.min' => 'Anda wajib mengunggah setidaknya 1 file dokumentasi.',
        ];
        $validated = $request->validate($rules, $messages);

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (count($files) > 5) {
                return back()->withErrors(['files' => 'Maximum 5 files allowed.'])->withInput();
            }
        }

        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        $submissionName = $validated['name'] ?? ($categoryData['nama_objek'] ?? ($categoryName . ' - ' . now()->format('d/m/Y')));

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'village_id' => Auth::user()->village_id,
            'name' => $submissionName,
            'category' => $categoryName,
            'address' => $validated['address'] ?? '-',
            'description' => $validated['description'] ?? null,
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => 'potensi-kebudayaan',
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : date('Y'),
        ]);

        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul-desa.potensi-submissions.show', $submission)
            ->with('success', 'Draft Potensi Kebudayaan berhasil dibuat.');
    }

    /**
     * Display the specified Potensi Kebudayaan submission.
     */
    public function show(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        $this->authorize('view', $submission);

        $submission->load([
            'administrativeReviews.validator', 
            'fieldVerifications.validator',
            'reviewedBy'
        ]);
        $categoryFields = CulturalSubmission::getFlatCategoryFields($submission->category, $submission->getSubCategory());

        $timeline = collect();
        $timeline->push([
            'type' => 'status',
            'status' => CulturalSubmission::STATUS_DRAFT,
            'title' => 'Draf Disimpan',
            'date' => $submission->created_at,
            'icon' => 'draf',
            'color' => 'gray'
        ]);

        if ($submission->submitted_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_SUBMITTED,
                'title' => 'Dikirim untuk Review',
                'date' => $submission->submitted_at,
                'icon' => 'submitted',
                'color' => 'blue'
            ]);
        }

        // Claimed & Mulai Diproses
        if ($submission->review_started_at && $submission->reviewedBy) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
                'title' => 'Diklaim & Mulai Diproses oleh Validator',
                'display_status' => 'Proses Review',
                'date' => $submission->review_started_at,
                'description' => 'Validator: ' . $submission->reviewedBy->name,
                'icon' => 'diajukan',
                'color' => 'indigo'
            ]);
        }

        foreach ($submission->administrativeReviews as $review) {
            $actionTitles = ['forwarded' => 'Lolos Review Administratif', 'revision' => 'Butuh Revisi', 'rejected' => 'Ditolak'];
            $timeline->push([
                'type' => 'review',
                'title' => $actionTitles[$review->action] ?? 'Review Administratif',
                'date' => $review->created_at,
                'description' => $review->notes ?? $review->feedback ?? null,
                'reviewer' => $review->validator->name ?? 'Validator',
                'color' => match($review->action) { 'forwarded' => 'indigo', 'revision' => 'amber', 'rejected' => 'red', default => 'gray' }
            ]);
        }

        foreach ($submission->fieldVerifications as $verification) {
            $actionTitles = ['verified' => 'Terverifikasi', 'revision' => 'Butuh Revisi', 'rejected' => 'Ditolak'];
            $timeline->push([
                'type' => 'verification',
                'title' => $actionTitles[$verification->recommendation] ?? 'Verifikasi Lapangan',
                'date' => $verification->created_at,
                'description' => $verification->notes ?? $verification->feedback ?? null,
                'verifier' => $verification->validator->name ?? 'Validator',
                'color' => match($verification->recommendation) { 'verified' => 'green', 'revision' => 'amber', 'rejected' => 'red', default => 'gray' }
            ]);
        }

        $timeline = $timeline->sortBy('date');

        return view('pengusul-desa.potensi-submissions.show', compact('submission', 'categoryFields', 'timeline'));
    }

    /**
     * Show form for editing Potensi Kebudayaan submission.
     */
    public function edit(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        $this->authorize('update', $submission);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryName = $submission->category;
        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);

        return view('pengusul-desa.potensi-submissions.edit', compact('submission', 'categoryFields', 'categoryName', 'categorySlug'));
    }

    /**
     * Update the Potensi Kebudayaan submission.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        $this->authorize('update', $submission);

        if (!$submission->isEditable()) {
            return back()->with('error', 'Tidak dapat mengedit laporan yang sudah diajukan.');
        }

        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'period_year' => ['nullable', 'string'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        $categoryName = $submission->category;
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        
        if (!empty($categoryFields['has_sub'])) {
            $subField = $categoryFields['sub_field'] ?? 'sub_category';
            $rules["category_data.{$subField}"] = ['required', 'string'];
        }

        $flatFields = CulturalSubmission::getFlatCategoryFields($categoryName);
        foreach ($flatFields as $key => $field) {
            $is_array = isset($field['type']) && in_array($field['type'], ['checkbox_group', 'dynamic_table']);
            $isRequired = !empty($field['required']);
            
            $fieldRules = [$isRequired ? 'required' : 'nullable'];
            if ($is_array) {
                $fieldRules[] = 'array';
            } else {
                $fieldRules[] = 'string';
            }
            $fieldRules[] = 'max:5000';

            $rules["category_data.{$key}"] = $fieldRules;
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('files')) {
            if ($submission->files()->count() + count($request->file('files')) > 5) {
                return back()->withErrors(['files' => 'Total files tidak boleh melebihi 5.'])->withInput();
            }
            $this->handleFileUploads($submission, $request->file('files'));
        }

        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        $submission->update([
            'name' => $validated['name'] ?? ($categoryData['nama_objek'] ?? $submission->name),
            'description' => $validated['description'] ?? $submission->description,
            'address' => $validated['address'] ?? $submission->address,
            'village_id' => Auth::user()->village_id,
            'category_data' => !empty($categoryData) ? $categoryData : $submission->category_data,
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : $submission->period_year,
        ]);

        return redirect()->route('pengusul-desa.potensi-submissions.show', $submission)
            ->with('success', 'Potensi Kebudayaan berhasil diperbarui.');
    }

    /**
     * Delete the submission.
     */
    public function destroy(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        $this->authorize('delete', $submission);
        $submission->delete();

        return redirect()->route('pengusul-desa.potensi-submissions.index')
            ->with('success', 'Laporan Potensi Kebudayaan berhasil dihapus.');
    }

    /**
     * Submit for review.
     */
    public function submit(CulturalSubmission $submission)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        Gate::authorize('update', $submission);

        if (!$submission->canBeSubmitted()) {
            return back()->with('error', 'Pengajuan tidak dapat dikirim pada tahap ini.');
        }

        $submission->update([
            'status' => CulturalSubmission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        // Notify
        $admins = User::role(['super-admin', 'validator'])->get();
        $title = 'Potensi Kebudayaan Baru: ' . $submission->name;
        $message = 'Laporan Potensi Kebudayaan "' . $submission->name . '" telah dikirim dan menunggu review.';
        // Don't hardcode URL - let NotificationController route based on role and submission_type
        $url = null;

        foreach ($admins as $admin) {
            $admin->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));
        }

        return redirect()->route('pengusul-desa.potensi-submissions.show', $submission)
            ->with('success', 'Laporan Potensi Kebudayaan telah dikirim untuk ditinjau.');
    }

    /**
     * Remove a file.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
        if ($submission->submission_type !== 'potensi-kebudayaan') {
            abort(404);
        }

        Gate::authorize('update', $submission);
        if ($file->cultural_submission_id !== $submission->id) {
            abort(404);
        }

        $file->delete();
        return back()->with('success', 'File berhasil dihapus.');
    }

    private function handleFileUploads(CulturalSubmission $submission, $files)
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $storedName = time() . '_' . $originalName;
            $path = $file->storeAs('submissions/' . $submission->id, $storedName, 'public');

            if ($path) {
                $mimeType = $file->getMimeType();
                $fileType = SubmissionFile::TYPE_DOCUMENT;
                if (str_starts_with($mimeType, 'image/')) $fileType = SubmissionFile::TYPE_IMAGE;
                elseif (str_starts_with($mimeType, 'video/')) $fileType = SubmissionFile::TYPE_VIDEO;

                $submission->files()->create([
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'file_type' => $fileType,
                    'mime_type' => $mimeType,
                    'file_size' => $file->getSize(),
                    'path' => $path,
                ]);
            }
        }
    }
}
