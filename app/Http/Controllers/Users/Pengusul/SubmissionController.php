<?php

namespace App\Http\Controllers\Users\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengusul.submissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category' => ['required', 'string'],
                'address' => ['required', 'string'],
                'description' => ['required', 'string', 'min:50'],
                'latitude' => ['nullable', 'numeric', 'between:-90,90'],
                'longitude' => ['nullable', 'numeric', 'between:-180,180'],
                'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
            ]);
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
                    return back()->withErrors(['files' => 'Video files must not exceed 1GB.'])->withInput();
                }
                
                // Documents and images: max 10MB (10485760 bytes)
                if (!str_starts_with($mimeType, 'video/') && $fileSize > 10485760) {
                    return back()->withErrors(['files' => 'Documents and images must not exceed 10MB.'])->withInput();
                }
            }
        }

        $submission = CulturalSubmission::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category' => $validated['category'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'status' => CulturalSubmission::STATUS_DRAFT,
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Draft submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CulturalSubmission $submission)
    {
        // Ensure user can only view their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('pengusul.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CulturalSubmission $submission)
    {
        // Ensure user can only edit their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('pengusul.submissions.show', $submission)
                ->with('error', 'This submission cannot be edited in its current status.');
        }

        return view('pengusul.submissions.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CulturalSubmission $submission)
    {
        // Ensure user can only update their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Check if submission is editable
        if (!$submission->isEditable()) {
            return redirect()->route('pengusul.submissions.show', $submission)
                ->with('error', 'This submission cannot be edited in its current status.');
        }

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category' => ['required', 'string'],
                'address' => ['required', 'string'],
                'description' => ['required', 'string', 'min:50'],
                'latitude' => ['nullable', 'numeric', 'between:-90,90'],
                'longitude' => ['nullable', 'numeric', 'between:-180,180'],
                'files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,mp4,avi,mov'],
            ]);
        } catch (\Symfony\Component\Mime\Exception\LogicException $e) {
            return back()->with('error', 'Gagal memvalidasi file. Mohon aktifkan ekstensi "fileinfo" pada PHP di Laragon Anda (Menu -> PHP -> Extensions -> fileinfo).')->withInput();
        }

        // Custom validation for file sizes based on type
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            // Count existing + new files
            $totalFiles = $submission->files()->count() + count($files);
            
            if ($totalFiles > 5) {
                return back()->withErrors(['files' => 'Maximum 5 files allowed total. You already has ' . $submission->files()->count() . ' files.'])->withInput();
            }

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();
                
                // Video files: max 1GB
                if (str_starts_with($mimeType, 'video/') && $fileSize > 1073741824) {
                    return back()->withErrors(['files' => 'Video files must not exceed 1GB.'])->withInput();
                }
                
                // Documents and images: max 10MB
                if (!str_starts_with($mimeType, 'video/') && $fileSize > 10485760) {
                    return back()->withErrors(['files' => 'Documents and images must not exceed 10MB.'])->withInput();
                }
            }
        }

        $submission->update($validated);

        // Handle file uploads
        if ($request->hasFile('files')) {
            $this->handleFileUploads($submission, $request->file('files'));
        }

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CulturalSubmission $submission)
    {
        if ($submission->status !== CulturalSubmission::STATUS_DRAFT) {
            abort(403, 'Hanya draft yang dapat dihapus.');
        }

        $this->authorize('delete', $submission);

        $submission->delete();

        return redirect()->route('pengusul.submissions.index')
            ->with('success', 'Draft submission deleted successfully.');
    }

    /**
     * Submit the submission for review.
     */
    public function submit(CulturalSubmission $submission)
    {
        $this->authorize('update', $submission);

        if (!$submission->canBeSubmitted()) {
            return back()->with('error', 'Submission cannot be submitted at this stage.');
        }

        $submission->update([
            'status' => CulturalSubmission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        return redirect()->route('pengusul.submissions.show', $submission)
            ->with('success', 'Submission has been submitted for review.');
    }

    /**
     * Remove a file from the submission.
     */
    public function destroyFile(CulturalSubmission $submission, SubmissionFile $file)
    {
        $this->authorize('update', $submission);
        
        if (!$submission->isEditable()) {
            abort(403, 'Submission is not editable.');
        }

        if ($file->cultural_submission_id !== $submission->id) {
            abort(404);
        }

        $file->delete();

        return back()->with('success', 'File deleted successfully.');
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
