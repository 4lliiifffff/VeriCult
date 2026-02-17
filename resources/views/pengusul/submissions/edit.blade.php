@extends('layouts.pengusul')

@section('content')
<script>
    document.addEventListener('alpine:init', () => {
        // Only register if not already registered (shared with create page)
        if (!Alpine.Components || !Alpine.Components.submissionForm) {
            Alpine.data('submissionForm', () => ({
                loading: false,
                files: [],
                dragover: false,
                submitForm(e) {
                    this.loading = true;
                },
                handleFileSelect(e) {
                    const newFiles = Array.from(e.target.files);
                    this.addFiles(newFiles);
                },
                handleDrop(e) {
                    const droppedFiles = Array.from(e.dataTransfer.files);
                    this.addFiles(droppedFiles);
                },
                addFiles(newFiles) {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f));

                    newFiles.forEach(f => {
                        if (!this.files.some(existing =>
                            existing.name === f.name &&
                            existing.size === f.size &&
                            existing.lastModified === f.lastModified
                        )) {
                            dt.items.add(f);
                        }
                    });

                    if (dt.items.length > 5) {
                        alert('Maksimal 5 file yang dapat diupload sekaligus.');
                        const limitedDt = new DataTransfer();
                        for (let i = 0; i < 5; i++) {
                            limitedDt.items.add(dt.files[i]);
                        }
                        this.updateFiles(limitedDt);
                    } else {
                        this.updateFiles(dt);
                    }
                },
                removeFile(index) {
                    const dt = new DataTransfer();
                    this.files.filter((_, i) => i !== index).forEach(f => dt.items.add(f));
                    this.updateFiles(dt);
                },
                updateFiles(dt) {
                    this.files = Array.from(dt.files);
                    const input = document.getElementById('files');
                    if (input) input.files = dt.files;
                },
                formatSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }
            }));
        }
    });
</script>

<div class="py-6 bg-[#F8FAFC] min-h-screen font-sans">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">

        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('pengusul.submissions.show', $submission) }}" class="p-2 rounded-lg hover:bg-white transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    Edit Pengajuan
                </h2>
                <p class="text-sm text-slate-500 mt-1">{{ $submission->name }}</p>
            </div>
            <span class="ml-auto inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100">
                {{ $submission->status_label }}
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden relative" x-data="submissionForm">
            <div class="p-6">
                <form action="{{ route('pengusul.submissions.update', $submission) }}" method="POST" enctype="multipart/form-data" @submit="submitForm">
                    @csrf
                    @method('PUT')

                    @include('pengusul.submissions.partials.form')

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                        <a href="{{ route('pengusul.submissions.show', $submission) }}" class="px-4 py-2 border-2 border-slate-200 text-slate-600 font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white font-semibold rounded-lg shadow-lg shadow-[#0077B6]/30 hover:from-[#023E8A] hover:to-[#0077B6] transition-all" :disabled="loading">
                            <span x-show="!loading">Perbarui</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Loading Overlay -->
            <div x-show="loading"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 border-4 border-[#0077B6]/30 border-t-[#0077B6] rounded-full animate-spin mb-4"></div>
                    <p class="text-[#0077B6] font-bold text-lg animate-pulse">Mengupdate Data...</p>
                    <p class="text-slate-500 text-sm mt-1">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
