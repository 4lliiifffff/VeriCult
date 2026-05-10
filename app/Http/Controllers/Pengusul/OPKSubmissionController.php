<?php

namespace App\Http\Controllers\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\Notifications\SubmissionNotification;
use App\Models\User;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OPKSubmissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                // Only pengusul-desa can access opk submissions
                if (!Auth::check() || !Auth::user()->hasRole('pengusul')) {
                    abort(403, 'Hanya pengusul umum yang dapat membuat laporan OPK.');
                }
    
                // if (!Auth::user()->is_approved_by_admin) {
                //     abort(403, 'Akun Anda sedang menunggu persetujuan dari super admin untuk membuat laporan OPK.');
                // }
    
                return $next($request);
            }
        ];
    }

    /**
     * Display a listing of opk submissions.
     */
    public function index()
    {
        $submissions = CulturalSubmission::ownedBy(Auth::id())
            ->where('submission_type', 'opk')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pengusul.opk-submissions.index', compact('submissions'));
    }

    /**
     * Show the category selection page for opk.
     */
    public function create()
    {
        $categories = collect(CulturalSubmission::CATEGORY_SLUGS)
            ->except(['cagar-budaya', 'potensi-cagar-budaya', 'laporan-kebudayaan-aktif'])
            ->toArray();
        $descriptions = CulturalSubmission::CATEGORY_DESCRIPTIONS;
        $icons = CulturalSubmission::CATEGORY_ICONS;

        return view('pengusul.opk-submissions.create', compact('categories', 'descriptions', 'icons'));
    }

    /**
     * Show the form for a specific opk category.
     */
    public function createForm(string $category)
    {
        // Validate category slug and ensure it's not Cagar Budaya or Laporan Aktif
        if (!array_key_exists($category, CulturalSubmission::CATEGORY_SLUGS) || in_array($category, ['cagar-budaya', 'potensi-cagar-budaya', 'laporan-kebudayaan-aktif'])) {
            abort(404, 'Kategori tidak ditemukan.');
        }

        $categoryName = CulturalSubmission::CATEGORY_SLUGS[$category];
        $categorySlug = $category;
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$categoryName] ?? '';

        return view('pengusul.opk-submissions.create-form', compact(
            'categoryName',
            'categorySlug',
            'categoryFields',
            'categoryDescription'
        ));
    }

    /**
     * Store a newly created opk submission.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'period_year' => ['nullable', 'string'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        // Add category-specific validation rules
        $categoryFields = CulturalSubmission::getFlatCategoryFields($request->input('category', ''));
        foreach ($categoryFields as $key => $field) {
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

        try {
            $messages = [
                'files.max' => 'Maximum 5 files allowed.',
                'category_data.*.required' => 'Kolom :attribute wajib diisi.',
            ];
            $validated = $request->validate($rules, $messages);
        } catch (\Symfony\Component\Mime\Exception\LogicException $e) {
            return back()->with('error', 'Gagal memvalidasi file. Mohon aktifkan ekstensi "fileinfo" pada PHP di Laragon Anda (Menu -> PHP -> Extensions -> fileinfo).')->withInput();
        }

        // Custom validation for file sizes based on type
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (count($files) > 5) {
                return back()->withErrors(['files' => 'Maximum 5 files allowed.'])->withInput();
            }

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                // Video files: max 1GB (1073741824 bytes)
                if (str_starts_with($mimeType, 'video/') && $fileSize > 1073741824) {
                    return back()->withErrors(['files' => 'File video tidak boleh melebihi 1GB.'])->withInput();
                }

                // Documents and images: max 10MB (10485760 bytes)
                if (!str_starts_with($mimeType, 'video/') && $fileSize > 10485760) {
                    return back()->withErrors(['files' => 'Dokumen dan gambar tidak boleh melebihi 10MB.'])->withInput();
                }
            }
        }

        // Clean category_data — remove empty values but keep arrays (checkbox, dynamic table)
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name from b1_nama_objek if not provided
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            $submissionName = $categoryData['nama_objek'] ?? ($validated['category'] . ' - ' . now()->format('d/m/Y'));
        }

        // Auto-populate address from category data if empty
        $submissionAddress = $validated['address'] ?? '-';

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'village_id' => null,
            'name' => $submissionName,
            'category' => $validated['category'],
            'address' => $submissionAddress,
            'description' => $validated['description'] ?? null,
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => 'opk',
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : date('Y'),
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul.opk-submissions.show', $submission)
            ->with('success', 'Draft laporan OPK berhasil dibuat.');
    }

    /**
     * Display the specified opk submission.
     */
    public function show(CulturalSubmission $submission)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('view', $submission);

        $submission->load([
            'administrativeReviews.validator', 
            'fieldVerifications.validator'
        ]);

        $categoryFields = CulturalSubmission::getFlatCategoryFields($submission->category, $submission->getSubCategory());

        // Build chronological timeline
        $timeline = collect();

        // 1. Draft Created
        $timeline->push([
            'type' => 'status',
            'status' => CulturalSubmission::STATUS_DRAFT,
            'title' => 'Draf Disimpan',
            'status' => 'Draf',
            'icon' => 'draf',
            'color' => 'gray',
            'date' => $submission->created_at,
            'description' => null,
        ]);

        // 2. Submitted
        if ($submission->submitted_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_SUBMITTED,
                'title' => 'Dikirim untuk Review',
                'date' => $submission->submitted_at,
                'description' => null,
                'icon' => 'submitted',
                'color' => 'blue'
            ]);
        }

        // 3. Administrative Reviews
        foreach ($submission->administrativeReviews as $review) {
            $actionTitles = [
                'forwarded' => 'Diteruskan ke Lapangan (Review Administratif)',
                'revision' => 'Butuh Revisi (Review Administratif)',
                'rejected' => 'Ditolak (Review Administratif)'
            ];
            $actionColors = [
                'forwarded' => 'indigo',
                'revision' => 'amber',
                'rejected' => 'red'
            ];

            $timeline->push([
                'type' => 'review',
                'action' => $review->action,
                'title' => $actionTitles[$review->action] ?? 'Review Administratif',
                'date' => $review->created_at,
                'description' => $review->notes ?? $review->feedback ?? null,
                'reviewer' => $review->validator->name ?? 'Validator',
                'icon' => 'review',
                'color' => $actionColors[$review->action] ?? 'gray'
            ]);
        }

        // 4. Field Verifications
        foreach ($submission->fieldVerifications as $verification) {
            $actionTitles = [
                'verified' => 'Terverifikasi (Verifikasi Lapangan)',
                'revision' => 'Butuh Revisi (Verifikasi Lapangan)',
                'rejected' => 'Ditolak (Verifikasi Lapangan)'
            ];
            $actionColors = [
                'verified' => 'green',
                'revision' => 'amber',
                'rejected' => 'red'
            ];

            $timeline->push([
                'type' => 'verification',
                'action' => $verification->action ?? $verification->recommendation ?? null,
                'title' => $actionTitles[$verification->action ?? $verification->recommendation ?? ''] ?? 'Verifikasi Lapangan',
                'date' => $verification->created_at,
                'description' => $verification->notes ?? $verification->feedback ?? null,
                'verifier' => $verification->validator->name ?? 'Validator',
                'icon' => 'verification',
                'color' => $actionColors[$verification->action ?? $verification->recommendation ?? ''] ?? 'gray'
            ]);
        }

        // 5. Published
        if ($submission->status === CulturalSubmission::STATUS_PUBLISHED) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_PUBLISHED,
                'title' => 'Pengajuan Dikirim',
                'status' => 'Diajukan',
                'color' => 'blue',
                'icon' => 'diajukan',
                'date' => $submission->updated_at,
                'description' => null,
            ]);
        }

        $timeline = $timeline->sortBy('date');

        return view('pengusul.opk-submissions.show', compact(
            'submission',
            'categoryFields',
            'timeline'
        ));
    }

    /**
     * Show form for editing submission.
     */
    public function edit(CulturalSubmission $submission)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('update', $submission);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryName = $submission->category;
        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);

        return view('pengusul.opk-submissions.edit', compact(
            'submission',
            'categoryFields',
            'categoryName',
            'categorySlug'
        ));
    }

    /**
     * Update the submission.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('update', $submission);

        // Only allow update if still in draft or revision status
        if (!in_array($submission->status, [CulturalSubmission::STATUS_DRAFT, CulturalSubmission::STATUS_REVISION])) {
            return back()->with('error', 'Tidak dapat mengedit laporan yang sudah diajukan.');
        }

        // Base validation rules (similar to store)
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'period_year' => ['nullable', 'string'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        // Add category-specific validation
        $categoryFields = CulturalSubmission::getFlatCategoryFields($submission->category);
        foreach ($categoryFields as $key => $field) {
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

        try {
            $validated = $request->validate($rules);
        } catch (\Symfony\Component\Mime\Exception\LogicException $e) {
            return back()->with('error', 'Gagal memvalidasi file.')->withInput();
        }

        // Handle new file uploads
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (count($submission->files) + count($files) > 5) {
                return back()->withErrors(['files' => 'Total files tidak boleh melebihi 5.'])->withInput();
            }

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                if (str_starts_with($mimeType, 'video/') && $fileSize > 1073741824) {
                    return back()->withErrors(['files' => 'File video tidak boleh melebihi 1GB.'])->withInput();
                }

                if (!str_starts_with($mimeType, 'video/') && $fileSize > 10485760) {
                    return back()->withErrors(['files' => 'Dokumen dan gambar tidak boleh melebihi 10MB.'])->withInput();
                }
            }

            $this->handleFileUploads($submission, $files);
        }

        // Clean category_data
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name from nama_objek if not provided
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            $submissionName = $categoryData['nama_objek'] ?? $submission->name;
        }

        // Update submission
        $submission->update([
            'name' => $submissionName,
            'village_id' => null,
            'description' => $validated['description'] ?? $submission->description,
            'address' => $validated['address'] ?? $submission->address,
            'category_data' => !empty($categoryData) ? $categoryData : $submission->category_data,
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : ($submission->period_year ?? date('Y')),
        ]);

        return redirect()->route('pengusul.opk-submissions.show', $submission)
            ->with('success', 'Laporan OPK berhasil diperbarui.');
    }

    /**
     * Delete the submission.
     */
    public function destroy(CulturalSubmission $submission)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('delete', $submission);

        // Delete associated files
        foreach ($submission->files as $file) {
            $file->delete();
        }

        $submission->delete();

        return redirect()->route('pengusul.opk-submissions.index')
            ->with('success', 'Laporan OPK berhasil dihapus.');
    }

    /**
     * Submit the opk submission for review.
     */
    public function submit(CulturalSubmission $submission)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        Gate::authorize('update', $submission);

        if (!$submission->canBeSubmitted()) {
            return back()->with('error', 'Pengajuan tidak dapat dikirim pada tahap ini.');
        }

        $submission->update([
            'status' => CulturalSubmission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        // Notify Validators and Super Admins
        $admins = User::role(['super-admin', 'validator'])->get();
        $title = 'Laporan OPK Baru: ' . $submission->name;
        $message = 'Laporan OPK "' . $submission->name . '" telah dikirim oleh ' . Auth::user()->name . ' (pengusul umum) dan menunggu review.';
        $url = route('validator.submissions.show', $submission);

        foreach ($admins as $admin) {
            $admin->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));
        }

        return redirect()->route('pengusul.opk-submissions.show', $submission)
            ->with('success', 'Laporan OPK telah dikirim untuk ditinjau.');
    }

    /**
     * Remove a file from the opk submission.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
        // Make sure it's a opk submission
        if ($submission->submission_type !== 'opk') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        Gate::authorize('update', $submission);

        if (!$submission->isEditable()) {
            abort(403, 'Submission is not editable.');
        }

        if ($file->cultural_submission_id !== $submission->id) {
            abort(404);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Handle file uploads for a submission.
     */
    private function handleFileUploads(CulturalSubmission $submission, $files)
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $storedName = time() . '_' . $originalName;
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            try {
                $path = $file->storeAs('submissions/' . $submission->id, $storedName, 'public');

                if (!$path) continue;

                // Determine file type
                $fileType = SubmissionFile::TYPE_DOCUMENT;
                if (str_starts_with($mimeType, 'image/')) {
                    $fileType = SubmissionFile::TYPE_IMAGE;
                } elseif (str_starts_with($mimeType, 'video/')) {
                    $fileType = SubmissionFile::TYPE_VIDEO;
                }

                $submission->files()->create([
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'file_type' => $fileType,
                    'mime_type' => $mimeType,
                    'file_size' => $size,
                    'path' => $path,
                ]);
            } catch (\Exception $e) {
                \Log::error("Error handling file upload " . $originalName . ": " . $e->getMessage());
            }
        }
    }
}

