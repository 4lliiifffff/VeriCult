<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\Notifications\SubmissionNotification;
use App\Models\User;

class CulturalController extends Controller
{
    /**
     * Display a listing of the validator's own submissions.
     */
    public function index()
    {
        $submissions = CulturalSubmission::ownedBy(Auth::id())
            ->latest()
            ->paginate(10);

        return view('validator.cultural.index', compact('submissions'));
    }

    /**
     * Show the category selection page.
     */
    public function create()
    {
        $categories = CulturalSubmission::CATEGORY_SLUGS;
        $descriptions = CulturalSubmission::CATEGORY_DESCRIPTIONS;
        $icons = CulturalSubmission::CATEGORY_ICONS;

        return view('validator.cultural.create', compact('categories', 'descriptions', 'icons'));
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

        return view('validator.cultural.create-form', compact(
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
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
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

        // Clean category_data — remove empty values but keep arrays (checkbox, dynamic table)
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name from b1_nama_objek if not provided
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            $submissionName = $categoryData['b1_nama_objek'] ?? ($validated['category'] . ' - ' . now()->format('d/m/Y'));
        }

        // Auto-populate address from category data if empty
        $submissionAddress = $validated['address'] ?? '-';

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'reviewed_by' => Auth::id(),
            'review_started_at' => now(),
            'name' => $submissionName,
            'category' => $validated['category'],
            'address' => $submissionAddress,
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

        return redirect()->route('validator.cultural.show', $submission)
            ->with('success', 'Draft pengajuan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CulturalSubmission $cultural)
    {
        $submission = $cultural;

        // Only allow viewing own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        $submission->load(['administrativeReviews', 'fieldVerifications']);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);

        // Build chronological timeline
        $timeline = collect();

        // 1. Draft Created
        $timeline->push([
            'type' => 'status',
            'status' => CulturalSubmission::STATUS_DRAFT,
            'title' => 'Draf Disimpan',
            'status' => 'Draf',
            'color' => 'gray',
            'icon' => 'draf',
        ]);

        // 2. Submitted
        if ($submission->submitted_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_SUBMITTED,
                'title' => 'Pengajuan Dikirim',
                'status' => 'Diajukan',
                'color' => 'blue',
                'icon' => 'diajukan',
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
                'rejected' => 'Verifikasi Lapangan Ditolak',
                'revision' => 'Butuh Revisi (Verifikasi Lapangan)'
            ];
            $actionColors = [
                'verified' => 'emerald',
                'rejected' => 'rose',
                'revision' => 'amber'
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

        // 5. Verified
        if ($submission->verified_at) {
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

        // 6. Published
        if ($submission->published_at) {
            $timeline->push([
                'type' => 'status',
                'status' => CulturalSubmission::STATUS_PUBLISHED,
                'title' => 'Data Diterbitkan',
                'status' => 'Diterbitkan',
                'color' => 'green',
                'icon' => 'diterbitkan',
            ]);
        }

        // Sort timeline by date ascending
        $timeline = $timeline->sortBy('date')->values();

        return view('validator.cultural.show', compact('submission', 'categoryFields', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CulturalSubmission $cultural)
    {
        $submission = $cultural;

        // Only allow editing own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('validator.cultural.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diubah pada status saat ini.');
        }

        $categorySlug = CulturalSubmission::getCategorySlug($submission->category);
        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryDescription = CulturalSubmission::CATEGORY_DESCRIPTIONS[$submission->category] ?? '';

        return view('validator.cultural.edit', compact('submission', 'categorySlug', 'categoryFields', 'categoryDescription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CulturalSubmission $cultural)
    {
        $submission = $cultural;

        // Only allow updating own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('validator.cultural.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diubah pada status saat ini.');
        }

        // Base validation rules
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
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
            return back()->with('error', 'Gagal memvalidasi file. Mohon aktifkan ekstensi "fileinfo" pada PHP.')->withInput();
        }

        // Custom validation for file sizes based on type
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $totalFiles = $submission->files()->count() + count($files);
            
            if ($totalFiles > 5) {
                return back()->withErrors(['files' => 'Maksimal 5 file diperbolehkan. Anda sudah memiliki ' . $submission->files()->count() . ' file.'])->withInput();
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
        }

        // Clean category_data
        $categoryData = $request->input('category_data', []);
        $categoryData = array_filter($categoryData, function($v) {
            if (is_array($v)) return !empty($v);
            return !is_null($v) && $v !== '';
        });

        // Auto-populate name
        $submissionName = $validated['name'] ?? '';
        if (empty($submissionName) || $submissionName === '') {
            $submissionName = $categoryData['b1_nama_objek'] ?? $submission->name;
        }

        $submission->update([
            'name' => $submissionName,
            'category' => $validated['category'],
            'address' => $validated['address'] ?? $submission->address,
            'description' => $validated['description'],
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('validator.cultural.show', $submission)
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CulturalSubmission $cultural)
    {
        $submission = $cultural;

        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        if ($submission->status !== CulturalSubmission::STATUS_DRAFT) {
            abort(403, 'Hanya draft yang dapat dihapus.');
        }

        $submission->delete();

        return redirect()->route('validator.cultural.index')
            ->with('success', 'Draft pengajuan berhasil dihapus.');
    }

    /**
     * Submit the submission for review (Auto-verified for validators).
     */
    public function submit(CulturalSubmission $submission)
    {
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        if (!$submission->canBeSubmitted()) {
            return back()->with('error', 'Pengajuan tidak dapat dikirim pada tahap ini.');
        }

        // Auto-verify validator submissions
        $submission->update([
            'status' => CulturalSubmission::STATUS_VERIFIED,
            'submitted_at' => now(),
            'verified_at' => now(),
        ]);

        // Create an automatic field verification record
        $submission->fieldVerifications()->create([
            'validator_id' => Auth::id(),
            'visit_date' => now(),
            'notes' => 'Pengajuan dibuat langsung oleh Validator dan diverifikasi secara otomatis.',
            'recommendation' => 'verified',
        ]);

        // Notify Super Admins
        $admins = User::role('super-admin')->get();
        $title = 'Pengajuan Validator Diverifikasi: ' . $submission->name;
        $message = 'Objek budaya "' . $submission->name . '" telah diajukan dan diverifikasi secara otomatis oleh Validator ' . Auth::user()->name . '.';
        $url = route('super-admin.cultural-submissions.show', $submission);

        foreach ($admins as $admin) {
            $admin->notify(new SubmissionNotification($title, $message, $url, 'success', $submission->id));
        }

        return redirect()->route('validator.cultural.show', $submission)
            ->with('success', 'Pengajuan telah dikirim dan diverifikasi secara otomatis.');
    }

    /**
     * Remove a file from the submission.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }
        
        if (!$submission->isEditable()) {
            abort(403, 'Pengajuan tidak dapat diedit.');
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
