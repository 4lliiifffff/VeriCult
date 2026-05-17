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

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CulturalSubmission::ownedBy(Auth::id());

        // Search filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($request->filled('type') && $request->query('type') !== 'all') {
            $query->where('submission_type', $request->query('type'));
        }

        $submissions = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pengusul.submissions.index', compact('submissions'));
    }

    /**
     * Show the category selection page.
     */
    public function create()
    {
        return view('pengusul.submissions.create');
    }

    /**
     * Show the form for a specific category.
     */
    public function createForm(string $category)
    {
        // Special handling for Active Culture Report
        if ($category === 'laporan-kebudayaan-aktif') {
            $categoryName = 'Laporan Kebudayaan Aktif';
            $categorySlug = $category;
            $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
            $categoryDescription = 'Formulir untuk melaporkan kebudayaan yang sedang dilaksanakan secara aktif di masyarakat.';

            $villages = \App\Models\Village::orderBy('name')->get();

            return view('pengusul.submissions.create-form', compact(
                'categoryName',
                'categorySlug',
                'categoryFields',
                'categoryDescription',
                'villages'
            ));
        }

        // Regular Pengusul shouldn't access other categories directly anymore
        if (!Auth::user()->hasRole('pengusul')) {
            return redirect()->route('pengusul.submissions.create-form', 'laporan-kebudayaan-aktif');
        }

        // ... rest of the original logic for other roles if they access this ...
        // Validate category slug
        if (!array_key_exists($category, CulturalSubmission::CATEGORY_SLUGS)) {
            abort(404, 'Kategori tidak ditemukan.');
        }

        $categoryName = CulturalSubmission::CATEGORY_SLUGS[$category];
        $categorySlug = $category;
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$categoryName] ?? '';

        $villages = \App\Models\Village::orderBy('name')->get();

        return view('pengusul.submissions.create-form', compact(
            'categoryName',
            'categorySlug',
            'categoryFields',
            'categoryDescription',
            'villages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'period_year' => ['nullable', 'string'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov,webm'],
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
                'files.max' => 'Maksimal 5 file diizinkan.',
                'category.required' => 'Kategori wajib dipilih.',
                'category.in' => 'Kategori tidak valid.',
            ];

            // Add friendly labels for category_data fields
            foreach ($categoryFields as $key => $field) {
                $messages["category_data.{$key}.required"] = "Kolom {$field['label']} wajib diisi.";
                $messages["category_data.{$key}.array"] = "Format kolom {$field['label']} tidak valid.";
                $messages["category_data.{$key}.string"] = "Format kolom {$field['label']} harus berupa teks.";
            }

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
        // Auto-populate name from relevant fields if not provided
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            // Check for specific fields based on category
            $nameFallback = $categoryData['nama_dan_jenis_kebudayaan'] 
                ?? ($categoryData['nama_objek'] 
                ?? ($categoryData['b1_nama_objek'] 
                ?? ($validated['category'] . ' - ' . now()->format('d/m/Y'))));
            
            $submissionName = $nameFallback;
        }

        // Address and Description: handled as nullable in DB
        $submissionAddress = $validated['address'] ?? null;
        $submissionDescription = $validated['description'] ?? null;

        $category = $validated['category'];
        if ($category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA) {
            $category = CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA;
        }

        $villageId = null;
        if ($category === CulturalSubmission::CATEGORY_LAPORAN_AKTIF) {
            if (!empty($categoryData['desa_lokasi'])) {
                $village = \App\Models\Village::where('name', 'like', trim($categoryData['desa_lokasi']))->first();
                if ($village) {
                    $villageId = $village->id;
                }
            }
            if (!empty($categoryData['detail_lokasi'])) {
                $submissionAddress = $categoryData['detail_lokasi'];
            }
        }

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'village_id' => $villageId,
            'name' => $submissionName,
            'category' => $category,
            'address' => $submissionAddress,
            'description' => $submissionDescription,
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => $request->input('category') === CulturalSubmission::CATEGORY_LAPORAN_AKTIF ? 'aktif' : 'opk',
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : date('Y'),
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Draft pengajuan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CulturalSubmission $submission)
    {
        // Handle redirection based on type
        if ($submission->submission_type === 'opk') {
            return redirect()->route('pengusul.opk-submissions.show', $submission);
        }
        if ($submission->submission_type === 'cagar-budaya') {
            return redirect()->route('pengusul.cagar-budaya-submissions.show', $submission);
        }
        if ($submission->submission_type === 'potensi-kebudayaan') {
            return redirect()->route('pengusul.dashboard')->with('error', 'Akses tidak diizinkan.');
        }

        $this->authorize('view', $submission);

        $submission->load([
            'administrativeReviews.validator', 
            'fieldVerifications.validator',
            'reviewedBy'
        ]);

        $categoryFields = CulturalSubmission::getFlatCategoryFields($submission->category, $submission->getSubCategory());

        // Build chronological timeline
        $timeline = collect();

        // 1. Draft Created
        $timeline->push([
            'type' => 'status',
            'status' => CulturalSubmission::STATUS_DRAFT,
            'title' => 'Draf Disimpan',
            'display_status' => 'Draf',
            'date' => $submission->created_at,
            'description' => null,
            'icon' => 'draf',
            'color' => 'gray'
        ]);

        // 2. Submitted
        if ($submission->submitted_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_SUBMITTED,
                'title' => 'Pengajuan Dikirim',
                'display_status' => 'Diajukan',
                'date' => $submission->submitted_at,
                'description' => null,
                'icon' => 'diajukan',
                'color' => 'blue'
            ]);
        }

        // 2b. Claimed & Mulai Diproses
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
                'status' => $review->action,
                'title' => $actionTitles[$review->action] ?? 'Review Administratif',
                'date' => $review->created_at,
                'description' => $review->notes,
                'reviewer' => $review->validator->name ?? 'Validator',
                'icon' => $review->action,
                'color' => $actionColors[$review->action] ?? 'indigo'
            ]);
        }

        // 4. Field Verifications
        foreach ($submission->fieldVerifications as $review) {
            $actionTitles = [
                'verified' => 'Verifikasi Lapangan Disetujui',
                'revision' => 'Butuh Revisi (Verifikasi Lapangan)',
                'rejected' => 'Ditolak (Verifikasi Lapangan)'
            ];
            $actionColors = [
                'verified' => 'emerald',
                'revision' => 'amber',
                'rejected' => 'red'
            ];
            $timeline->push([
                'type' => 'review',
                'status' => $review->action,
                'title' => $actionTitles[$review->action] ?? 'Verifikasi Lapangan',
                'date' => $review->created_at,
                'description' => $review->notes,
                'verifier' => $review->validator->name ?? 'Validator',
                'icon' => $review->action,
                'color' => $actionColors[$review->action] ?? 'emerald'
            ]);
        }

        // 5. Publisher / Verified At
        if ($submission->verified_at) {
            // Check if we don't already have a 'verified' from field verifications right at this exact time to avoid dupes,
            // but normally it's fine.
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_VERIFIED,
                'title' => 'Diverifikasi',
                'date' => $submission->verified_at,
                'description' => null,
                'icon' => 'verified',
                'color' => 'emerald'
            ]);
        }

        if ($submission->published_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_PUBLISHED,
                'title' => 'Data Diterbitkan',
                'display_status' => 'Diterbitkan',
                'date' => $submission->published_at,
                'description' => null,
                'icon' => 'diterbitkan',
                'color' => 'green'
            ]);
        }

        // Sort timeline by date ascending
        $timeline = $timeline->sortBy('date')->values();

        return view('pengusul.submissions.show', compact('submission', 'categoryFields', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CulturalSubmission $submission)
    {
        // Handle redirection based on type
        if ($submission->submission_type === 'opk') {
            return redirect()->route('pengusul.opk-submissions.edit', $submission);
        }
        if ($submission->submission_type === 'cagar-budaya') {
            return redirect()->route('pengusul.cagar-budaya-submissions.edit', $submission);
        }
        if ($submission->submission_type === 'potensi-kebudayaan') {
            return redirect()->route('pengusul.dashboard')->with('error', 'Akses tidak diizinkan.');
        }

        $this->authorize('update', $submission);

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('pengusul.submissions.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diubah pada status saat ini.');
        }

        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);
        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$submission->category] ?? '';

        $villages = \App\Models\Village::orderBy('name')->get();

        return view('pengusul.submissions.edit', compact('submission', 'categorySlug', 'categoryFields', 'categoryDescription', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        $this->authorize('update', $submission);

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('pengusul.submissions.show', $submission)
                ->with('error', 'This submission cannot be edited in its current status.');
        }

        // Base validation rules
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
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
                'files.max' => 'Maksimal 5 file diizinkan.',
                'category.required' => 'Kategori wajib dipilih.',
            ];

            // Add friendly labels for category_data fields
            foreach ($categoryFields as $key => $field) {
                $messages["category_data.{$key}.required"] = "Kolom {$field['label']} wajib diisi.";
            }

            $validated = $request->validate($rules, $messages);
        } catch (\Symfony\Component\Mime\Exception\LogicException $e) {
            return back()->with('error', 'Gagal memvalidasi file. Mohon aktifkan ekstensi "fileinfo" pada PHP di Laragon Anda (Menu -> PHP -> Extensions -> fileinfo).')->withInput();
        }

        // Custom validation for file sizes based on type
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            // Count existing + new files
            $totalFiles = $submission->files()->count() + count($files);

            if ($totalFiles > 5) {
                return back()->withErrors(['files' => 'Maksimal 5 file diperbolehkan. Anda sudah memiliki ' . $submission->files()->count() . ' file.'])->withInput();
            }

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                // Video files: max 1GB
                if (str_starts_with($mimeType, 'video/') && $fileSize > 1073741824) {
                    return back()->withErrors(['files' => 'File video tidak boleh melebihi 1GB.'])->withInput();
                }

                // Documents and images: max 10MB
                if (!str_starts_with($mimeType, 'video/') && $fileSize > 10485760) {
                    return back()->withErrors(['files' => 'Dokumen dan gambar tidak boleh melebihi 10MB.'])->withInput();
                }
            }
        }

        // Clean category_data — remove empty values but keep arrays
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name from relevant fields if not provided
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            $nameFallback = $categoryData['nama_dan_jenis_kebudayaan'] 
                ?? ($categoryData['nama_objek'] 
                ?? ($categoryData['b1_nama_objek'] 
                ?? $submission->name));
                
            $submissionName = $nameFallback;
        }

        $category = $validated['category'];
        if ($category === CulturalSubmission::CATEGORY_CAGAR_BUDAYA) {
            $category = CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA;
        }

        $villageId = null;
        $submissionAddress = $validated['address'] ?? $submission->address;
        if ($category === CulturalSubmission::CATEGORY_LAPORAN_AKTIF) {
            if (!empty($categoryData['desa_lokasi'])) {
                $village = \App\Models\Village::where('name', 'like', trim($categoryData['desa_lokasi']))->first();
                if ($village) {
                    $villageId = $village->id;
                }
            }
            if (!empty($categoryData['detail_lokasi'])) {
                $submissionAddress = $categoryData['detail_lokasi'];
            }
        }

        $submission->update([
            'name' => $submissionName,
            'category' => $category,
            'village_id' => $villageId,
            'address' => $submissionAddress,
            'description' => $validated['description'] ?? $submission->description,
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'period_year' => !empty($validated['period_year']) ? date('Y', strtotime($validated['period_year'])) : ($submission->period_year ?? date('Y')),
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CulturalSubmission $submission)
    {
        if ($submission->status !== CulturalSubmission::STATUS_DRAFT) {
            abort(403, 'Hanya draft yang dapat dihapus.');
        }

        Gate::authorize('delete', $submission);

        $submission->delete();

        return redirect()->route('pengusul.submissions.index')
            ->with('success', 'Draft pengajuan berhasil dihapus.');
    }

    /**
     * Submit the submission for review.
     */
    public function submit(CulturalSubmission $submission)
    {
        Gate::authorize('update', $submission);

        if (!$submission->canBeSubmitted()) {
            return back()->with('error', 'Pengajuan tidak dapat dikirim pada tahap ini.');
        }

        $submission->update([
            'status' => CulturalSubmission::STATUS_SUBMITTED,
            'submitted_at' => now(),
            // Remove the clear reviewer info block to preserve history
        ]);

        // Notify Validators and Super Admins
        $admins = User::role(['super-admin', 'validator'])->get();
        $title = 'Pengajuan Baru: ' . $submission->name;
        $message = 'Objek budaya baru "' . $submission->name . '" telah dikirim oleh ' . Auth::user()->name . ' dan menunggu review.';
        $url = route('validator.submissions.show', $submission); // Most likely destination for review

        foreach ($admins as $admin) {
            $admin->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));
        }

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Pengajuan telah dikirim untuk ditinjau.');
    }

    /**
     * Remove a file from the submission.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
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
     * Handle file uploads for submission.
     */
    private function handleFileUploads(CulturalSubmission $submission, array $files)
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            // Generate unique filename
            $storedName = time() . '_' . uniqid() . '.' . $extension;

            try {
                // Store file
                $path = $file->storeAs(
                    'submissions/' . $submission->id,
                    $storedName,
                    'public'
                );

                if (!$path) {
                    \Log::error("Failed to store file: " . $originalName);
                    continue;
                }

                // Determine file type
                $fileType = SubmissionFile::TYPE_DOCUMENT;
                if (str_starts_with($mimeType, 'image/')) {
                    $fileType = SubmissionFile::TYPE_IMAGE;
                } elseif (str_starts_with($mimeType, 'video/')) {
                    $fileType = SubmissionFile::TYPE_VIDEO;
                }

                // Create database record
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

