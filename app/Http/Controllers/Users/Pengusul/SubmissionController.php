<?php

namespace App\Http\Controllers\Users\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = CulturalSubmission::ownedBy(Auth::id())
            ->latest()
            ->paginate(10);

        return view('pengusul.submissions.index', compact('submissions'));
    }

    /**
     * Show the category selection page.
     */
    public function create()
    {
        $categories = CulturalSubmission::CATEGORY_SLUGS;
        $descriptions = CulturalSubmission::CATEGORY_DESCRIPTIONS;
        $icons = CulturalSubmission::CATEGORY_ICONS;

        return view('pengusul.submissions.create', compact('categories', 'descriptions', 'icons'));
    }

    /**
     * Show the form for a specific category.
     */
    public function createForm(string $category)
    {
        // Validate category slug
        if (!array_key_exists($category, CulturalSubmission::CATEGORY_SLUGS)) {
            abort(404, 'Kategori tidak ditemukan.');
        }

        $categoryName = CulturalSubmission::CATEGORY_SLUGS[$category];
        $categorySlug = $category;
        $categoryFields = CulturalSubmission::getCategoryFields($categoryName);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$categoryName] ?? '';

        return view('pengusul.submissions.create-form', compact(
            'categoryName',
            'categorySlug',
            'categoryFields',
            'categoryDescription'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['required', 'string'],
            'description' => ['required', 'string', 'min:50'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        // Add category-specific validation rules
        $categoryFields = CulturalSubmission::getCategoryFields($request->input('category', ''));
        foreach ($categoryFields as $key => $field) {
            $rules["category_data.{$key}"] = ['nullable', 'string', 'max:5000'];
        }

        try {
            $validated = $request->validate($rules);
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

        // Clean category_data — remove empty values
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, fn($v) => !is_null($v) && $v !== '');

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category' => $validated['category'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'status' => CulturalSubmission::STATUS_DRAFT,
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
        $this->authorize('view', $submission);

        $submission->load(['administrativeReviews', 'fieldVerifications']);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);

        // Build chronological timeline
        $timeline = collect();

        // 1. Draft Created
        $timeline->push([
            'type' => 'status',
            'status' => 'draft',
            'title' => 'Draft Dibuat',
            'date' => $submission->created_at,
            'description' => null,
            'icon' => 'draft',
            'color' => 'gray'
        ]);

        // 2. Submitted
        if ($submission->submitted_at) {
            $timeline->push([
                'type' => 'status',
                'status' => 'submitted',
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
                'status' => $review->action,
                'title' => $actionTitles[$review->action] ?? 'Review Administratif',
                'date' => $review->created_at,
                'description' => $review->notes,
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
                'status' => 'verified',
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
                'status' => 'published',
                'title' => 'Dipublikasikan',
                'date' => $submission->published_at,
                'description' => null,
                'icon' => 'published',
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
        $this->authorize('update', $submission);

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('pengusul.submissions.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diubah pada status saat ini.');
        }

        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);
        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$submission->category] ?? '';

        return view('pengusul.submissions.edit', compact('submission', 'categorySlug', 'categoryFields', 'categoryDescription'));
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
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['required', 'string'],
            'description' => ['required', 'string', 'min:50'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        // Add category-specific validation rules
        $categoryFields = CulturalSubmission::getCategoryFields($request->input('category', ''));
        foreach ($categoryFields as $key => $field) {
            $rules["category_data.{$key}"] = ['nullable', 'string', 'max:5000'];
        }

        try {
            $validated = $request->validate($rules);
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

        // Clean category_data — remove empty values
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, fn($v) => !is_null($v) && $v !== '');

        $submission->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
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
