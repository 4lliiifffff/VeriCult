<?php

namespace App\Http\Controllers\PengusulDesa;

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

class StatisticSubmissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                // Only pengusul-desa can access statistik submissions
                if (!Auth::check() || !Auth::user()->hasRole('pengusul-desa')) {
                    abort(403, 'Hanya pengusul desa yang dapat membuat laporan statistik.');
                }
    
                if (!Auth::user()->is_approved_by_admin) {
                    abort(403, 'Akun Anda sedang menunggu persetujuan dari super admin untuk membuat laporan statistik.');
                }
    
                return $next($request);
            }
        ];
    }

    /**
     * Display a listing of statistik submissions.
     */
    public function index()
    {
        $submissions = CulturalSubmission::ownedBy(Auth::id())
            ->where('submission_type', 'statistik')
            ->latest()
            ->paginate(10);

        return view('pengusul-desa.statistic-submissions.index', compact('submissions'));
    }

    /**
     * Show the category selection page for statistik.
     */
    public function create()
    {
        $categories = CulturalSubmission::CATEGORY_SLUGS;
        $descriptions = CulturalSubmission::CATEGORY_DESCRIPTIONS;
        $icons = CulturalSubmission::CATEGORY_ICONS;

        return view('pengusul-desa.statistic-submissions.create', compact('categories', 'descriptions', 'icons'));
    }

    /**
     * Show the form for a specific statistik category.
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

        return view('pengusul-desa.statistic-submissions.create-form', compact(
            'categoryName',
            'categorySlug',
            'categoryFields',
            'categoryDescription'
        ));
    }

    /**
     * Store a newly created statistik submission.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', CulturalSubmission::CATEGORIES)],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'min:50'],
            'period_year' => ['required', 'date'],
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
            'name' => $submissionName,
            'category' => $validated['category'],
            'address' => $submissionAddress,
            'description' => $validated['description'],
            'category_data' => !empty($categoryData) ? $categoryData : null,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => 'statistik',
            'period_year' => date('Y', strtotime($validated['period_year'])),
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul-desa.statistic-submissions.show', $submission)
            ->with('success', 'Draft laporan statistik berhasil dibuat.');
    }

    /**
     * Display the specified statistik submission.
     */
    public function show(CulturalSubmission $submission)
    {
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('view', $submission);

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
                'description' => $review->feedback,
                'reviewer' => $review->reviewer->name,
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
                'action' => $verification->action,
                'title' => $actionTitles[$verification->action] ?? 'Verifikasi Lapangan',
                'date' => $verification->created_at,
                'description' => $verification->feedback,
                'verifier' => $verification->verifier->name,
                'icon' => 'verification',
                'color' => $actionColors[$verification->action] ?? 'gray'
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

        return view('pengusul-desa.statistic-submissions.show', compact(
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
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('update', $submission);

        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        $categoryName = $submission->category;

        return view('pengusul-desa.statistic-submissions.edit', compact(
            'submission',
            'categoryFields',
            'categoryName'
        ));
    }

    /**
     * Update the submission.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
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
            'description' => ['nullable', 'string', 'min:50'],
            'address' => ['nullable', 'string'],
            'period_year' => ['required', 'date'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
        ];

        // Add category-specific validation
        $categoryFields = CulturalSubmission::getCategoryFields($submission->category);
        foreach ($categoryFields as $key => $field) {
            $rules["category_data.{$key}"] = ['nullable', 'string', 'max:5000'];
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

        // Update submission
        $submission->update([
            'name' => $validated['name'] ?? $submission->name,
            'description' => $validated['description'],
            'address' => $validated['address'] ?? $submission->address,
            'category_data' => !empty($categoryData) ? $categoryData : $submission->category_data,
            'period_year' => date('Y', strtotime($validated['period_year'])),
        ]);

        return redirect()->route('pengusul-desa.statistic-submissions.show', $submission)
            ->with('success', 'Laporan statistik berhasil diperbarui.');
    }

    /**
     * Delete the submission.
     */
    public function destroy(CulturalSubmission $submission)
    {
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
            abort(404, 'Laporan tidak ditemukan.');
        }

        $this->authorize('delete', $submission);

        // Delete associated files
        foreach ($submission->files as $file) {
            $file->delete();
        }

        $submission->delete();

        return redirect()->route('pengusul-desa.statistic-submissions.index')
            ->with('success', 'Laporan statistik berhasil dihapus.');
    }

    /**
     * Submit the statistik submission for review.
     */
    public function submit(CulturalSubmission $submission)
    {
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
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
        $title = 'Laporan Statistik Baru: ' . $submission->name;
        $message = 'Laporan statistik "' . $submission->name . '" telah dikirim oleh ' . Auth::user()->name . ' (Pengusul Desa) dan menunggu review.';
        $url = route('validator.submissions.show', $submission);

        foreach ($admins as $admin) {
            $admin->notify(new SubmissionNotification($title, $message, $url, 'info', $submission->id));
        }

        return redirect()->route('pengusul-desa.statistic-submissions.show', $submission)
            ->with('success', 'Laporan statistik telah dikirim untuk ditinjau.');
    }

    /**
     * Remove a file from the statistik submission.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
        // Make sure it's a statistik submission
        if ($submission->submission_type !== 'statistik') {
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
