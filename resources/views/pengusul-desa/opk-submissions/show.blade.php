<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[200px] sm:max-w-none">{{ $submission->name }}</span>
        </nav>

        <!-- Premium Page Header Card -->
        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-6 sm:p-10 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-md shadow-sm">
                            {{ $submission->status_label }}
                        </span>
                        <span class="text-[10px] font-black text-blue-100/60 uppercase tracking-[0.2em] bg-white/5 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10">OPK-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight break-words max-w-4xl">
                        {{ $submission->name }}
                    </h2>
                    
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 text-blue-100/80 font-bold text-sm bg-white/5 backdrop-blur-md px-3 py-2 rounded-xl border border-white/10">
                            <svg class="w-4 h-4 text-[#00B4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            <span>{{ $submission->category }}</span>
                        </div>
                    </div>
                </div>
                    
                <div class="flex items-center gap-4 mt-4 md:mt-0">
                    <a href="{{ route('pengusul-desa.submissions.index') }}" class="w-full md:w-auto justify-center bg-white text-[#03045E] px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-all shadow-xl shadow-blue-900/20 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ 
        submitting: false, 
        deleting: false,
        showPreviewModal: false,
        previewFile: null,
        openPreview(url, type, name) {
            this.previewFile = { url, type, name };
            this.showPreviewModal = true;
        },
        closePreview() {
            this.showPreviewModal = false;
            document.querySelectorAll('video').forEach(v => v.pause());
            setTimeout(() => { this.previewFile = null; }, 300);
        }
    }">
        <!-- Action Loading Overlay -->
        <div x-show="submitting || deleting"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-slate-900/75 flex items-center justify-center z-[100]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center" x-text="submitting ? 'Mengirim Laporan' : 'Menghapus Laporan'"></h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Sistem sedang memproses...</p>
            </div>
        </div>

        <!-- Fullscreen Preview Modal -->
        <template x-teleport="body">
            <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6" x-show="showPreviewModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
                <div class="relative w-full max-w-6xl max-h-full bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 flex flex-col">
                    <!-- Modal Header -->
                    <div class="p-6 sm:p-8 flex items-center justify-between border-b border-white/5 bg-slate-900/50 backdrop-blur-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#00B4D8]">
                                <template x-if="previewFile?.type === 'image'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </template>
                                <template x-if="previewFile?.type === 'video'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </template>
                            </div>
                            <div>
                                <h3 class="text-white font-black text-lg tracking-tight" x-text="previewFile?.name"></h3>
                            </div>
                        </div>
                        <button type="button" @click="closePreview()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/50 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all group">
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full bg-black/20 rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl flex items-center justify-center relative group/inner min-h-[300px]">
                        <template x-if="previewFile?.type === 'image'">
                            <img :src="previewFile?.url" class="max-w-full max-h-[70vh] object-contain select-none">
                        </template>
                        <template x-if="previewFile?.type === 'video'">
                            <video :src="previewFile?.url" controls autoplay class="max-w-full max-h-[70vh]"></video>
                        </template>
                        
                        <!-- Floating Download Link -->
                        <a :href="previewFile?.url" target="_blank" class="absolute bottom-8 right-8 px-6 py-3 bg-white text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all opacity-0 group-hover/inner:opacity-100 translate-y-4 group-hover/inner:translate-y-0 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Berkas
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left Info Column -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Admin Remarks Section (If exists) - Moved to Top for better visibility -->
                @php
                    $latestReview = $submission->administrativeReviews->last();
                @endphp
                @if($latestReview && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_REVISION, \App\Models\CulturalSubmission::STATUS_REJECTED]))
                <div class="group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'from-amber-500 to-orange-600' : 'from-rose-500 to-red-600' }} opacity-10 rounded-[2.5rem]"></div>
                    <div class="relative bg-white/40 backdrop-blur-xl rounded-[2.5rem] p-8 sm:p-12 border {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'border-amber-200/50 shadow-amber-200/20' : 'border-rose-200/50 shadow-rose-200/20' }} shadow-2xl overflow-hidden group/card transition-all duration-500 hover:bg-white/60">
                        <!-- Animated background elements -->
                        <div class="absolute -right-10 -top-10 w-48 h-48 {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'bg-amber-100/50' : 'bg-rose-100/50' }} rounded-full blur-3xl group-hover/card:scale-150 transition-transform duration-1000"></div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'bg-orange-50/50' : 'bg-red-50/50' }} rounded-full blur-2xl"></div>

                        <div class="relative z-10">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'bg-amber-500 text-white shadow-amber-500/30' : 'bg-rose-500 text-white shadow-rose-500/30' }} flex items-center justify-center shadow-lg group-hover/card:scale-110 transition-transform duration-500">
                                        @if($submission->status === \App\Models\CulturalSubmission::STATUS_REVISION)
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        @else
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="{{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'text-amber-900' : 'text-rose-900' }} font-black text-2xl tracking-tight mb-1">
                                            Catatan {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'Revisi' : 'Penolakan' }}
                                        </h3>
                                        <div class="flex items-center gap-3">
                                            <span class="w-2 h-2 rounded-full {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'bg-amber-500' : 'bg-rose-500' }} animate-pulse"></span>
                                            <p class="{{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'text-amber-600/80' : 'text-rose-600/80' }} text-[10px] font-black uppercase tracking-[0.2em]">{{ $latestReview->created_at->translatedFormat('d M Y') }} • Oleh {{ $latestReview->validator->name ?? 'Tim Review' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($submission->status === \App\Models\CulturalSubmission::STATUS_REVISION)
                                    <a href="{{ route('pengusul-desa.opk-submissions.edit', $submission) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'text-amber-600 border-amber-100 hover:bg-amber-50' : 'text-rose-600 border-rose-100 hover:bg-rose-50' }} border-2 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-sm active:scale-95 gap-3 group/btn">
                                        <span>Perbaiki Sekarang</span>
                                        <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                @endif
                            </div>

                            <div class="relative">
                                <div class="absolute -left-6 top-0 bottom-0 w-1.5 {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'bg-amber-200' : 'bg-rose-200' }} rounded-full opacity-50"></div>
                                <div class="p-8 sm:p-10 rounded-[2rem] bg-white border {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'border-amber-100 shadow-amber-100/20' : 'border-rose-100 shadow-rose-100/20' }} text-slate-700 leading-relaxed font-bold italic text-base sm:text-xl shadow-xl break-words">
                                    "{{ $latestReview->notes }}"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <div class="p-8 sm:p-12">
                        <div class="space-y-12">
                            <!-- Description -->
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Deskripsi Laporan</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="p-8 sm:p-10 rounded-[2.5rem] bg-blue-50/10 border border-blue-100/30 overflow-hidden">
                                    <div class="prose prose-slate max-w-none w-full break-words">
                                        <p class="text-slate-700 leading-[1.8] sm:leading-[2] font-medium text-base sm:text-lg italic">
                                            "{{ $submission->description }}"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- OPK Details -->
                            @if(!empty($submission->category_data))
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0 text-[#03045E]">Detail OPK {{ $submission->category }}</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-8 sm:p-12 border border-slate-100 shadow-inner overflow-hidden">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-10">
                                        @foreach($categoryFields as $fieldKey => $field)
                                            @if(isset($submission->category_data[$fieldKey]))
                                                <div class="space-y-2 min-w-0 flex-1 overflow-hidden">
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">{{ $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</p>
                                                    <div class="text-[#03045E] font-black text-base sm:text-lg tracking-tight break-words leading-relaxed">
                                                        @if(is_array($submission->category_data[$fieldKey]))
                                                            <div class="flex flex-wrap gap-2 mt-2">
                                                                @foreach($submission->category_data[$fieldKey] as $item)
                                                                    <span class="px-3 py-1 bg-blue-50 text-[#0077B6] rounded-lg text-xs font-bold border border-blue-100/50">{{ $item }}</span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            {{ $submission->category_data[$fieldKey] }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Files Section -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4 flex-1">
                                        <span class="shrink-0">Laporan Pendukung</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <span class="ml-4 px-4 py-2 rounded-xl bg-[#0077B6] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                                </div>
                                
                                @if($submission->files->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($submission->files as $file)
                                            <div class="group/file relative flex flex-col p-5 bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                                                <!-- Preview Area -->
                                                <div class="relative w-full h-48 rounded-[2rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-6 border border-slate-50/50 shadow-inner group-hover/file:border-[#0077B6]/20 transition-colors">
                                                    @if($file->file_icon == 'image')
                                                        <img src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110">
                                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                                            <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'image', '{{ $file->original_name }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            </button>
                                                        </div>
                                                    @elseif($file->file_icon == 'video')
                                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center relative">
                                                            <video src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" preload="metadata"></video>
                                                            <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                                                <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'video', '{{ $file->original_name }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-slate-300">
                                                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Content Area -->
                                                <div class="px-2 min-w-0 flex-1">
                                                    <p class="text-base font-black text-slate-800 truncate group-hover/file:text-[#0077B6] transition-colors mb-2" title="{{ $file->original_name }}">
                                                        {{ $file->original_name }}
                                                    </p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
                                                        <span class="px-2 py-0.5 rounded-lg bg-slate-50 border border-slate-100">{{ $file->file_size_human }}</span>
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                                        <span class="text-[#00B4D8]">{{ strtoupper($file->file_type) }}</span>
                                                    </p>
                                                </div>

                                                <!-- Footer Actions -->
                                                <div class="flex items-center gap-2 mt-6 pt-6 border-t border-slate-50">
                                                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex-1 flex items-center justify-center gap-3 px-6 py-4 bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95 group/dl">
                                                        <svg class="w-4 h-4 transition-transform group-hover/dl:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        Unduh Berkas
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-20 rounded-[3rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center group">
                                        <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm tracking-widest uppercase">Belum ada lampiran pendukung.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submission Meta -->
                        <div class="mt-16 sm:mt-20 pt-10 sm:pt-12 border-t border-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-12">
                            <div class="flex items-start sm:items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-1">Dilaporkan Pada</p>
                                    <p class="text-sm sm:text-base font-black text-slate-700 tracking-tight break-words">{{ $submission->created_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium lowercase">pukul</span> {{ $submission->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start sm:items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400 mb-1">Terakhir Diperbarui</p>
                                    <p class="text-sm sm:text-base font-black text-slate-700 tracking-tight break-words">{{ $submission->updated_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium lowercase">pukul</span> {{ $submission->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Action & Sidebar -->
            <div class="lg:col-span-4 space-y-10">
                
                <!-- Main Action Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-10 space-y-10 relative overflow-hidden group">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-[#03045E] font-black text-2xl tracking-tight mb-2">Tindakan Cepat</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.25em]">Workflow Laporan</p>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            @if($submission->status === \App\Models\CulturalSubmission::STATUS_DRAFT || $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION)
                                <a href="{{ route('pengusul-desa.opk-submissions.edit', $submission) }}" 
                                   class="flex items-center justify-center gap-4 w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-[0.2em] uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] hover:shadow-xl hover:shadow-blue-500/10 transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Ubah Konten
                                </a>

                                <form action="{{ route('pengusul-desa.opk-submissions.submit', $submission) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            @click="submitting = true" 
                                            class="flex items-center justify-center gap-4 w-full px-8 py-6 rounded-2xl bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.25em] uppercase shadow-2xl shadow-blue-900/40 hover:shadow-blue-900/50 hover:-translate-y-1 transition-all active:scale-95 group/submit">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        Kirim Final
                                    </button>
                                </form>

                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-delete')" 
                                        class="flex items-center justify-center gap-3 w-full px-8 py-4 rounded-xl bg-rose-50 text-rose-600 font-black text-[10px] tracking-[0.25em] uppercase hover:bg-rose-600 hover:text-white transition-all active:scale-[0.98] mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Batalkan Laporan
                                </button>
                                
                                <x-modal name="confirm-delete" :show="false" focusable>
                                    <div class="p-10 sm:p-16 text-center">
                                        <div class="w-28 h-28 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner group/del overflow-hidden border border-rose-100">
                                            <svg class="w-14 h-14 transition-transform duration-500 group-hover/del:scale-110 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </div>
                                        <h2 class="text-4xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Hapus Data?</h2>
                                        <p class="text-slate-500 max-w-xs mx-auto leading-relaxed font-bold text-sm mb-12">Tindakan ini permanen. Seluruh data dan berkas yang telah Anda unggah akan dihapus selamanya.</p>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                                            <button type="button" 
                                                    @click="$dispatch('close')" 
                                                    class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                                                Batal
                                            </button>
                                            <form action="{{ route('pengusul-desa.opk-submissions.destroy', $submission) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        @click="deleting = true; $dispatch('close')" 
                                                        class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-[0_20px_40px_-10px_rgba(225,29,72,0.3)] hover:bg-rose-700 transition-all active:scale-[0.98]">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline Sidebar -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden overflow-y-auto max-h-[600px] scrollbar-hide">
                    <div class="p-10 pb-6 sticky top-0 bg-white/95 backdrop-blur-sm z-10 flex items-center justify-between border-b border-slate-50">
                        <h3 class="text-[#03045E] font-black text-xl tracking-tight flex items-center gap-4">
                            <span class="w-1.5 h-7 bg-gradient-to-b from-[#03045E] to-[#0077B6] rounded-full"></span>
                            Jejak Laporan
                        </h3>
                    </div>
                    <div class="p-10 pt-8">
                        <div class="space-y-10">
                            @forelse($timeline as $event)
                                <div class="relative pl-10 group/item">
                                    @if(!$loop->last)
                                        <div class="absolute left-[7px] top-6 bottom-[-32px] w-px bg-slate-100 group-hover/item:bg-[#0077B6]/30 transition-colors"></div>
                                    @endif
                                    <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full border-2 border-white bg-{{ $event['color'] }}-500 shadow-[0_0_0_4px_rgba(var(--bg-{{ $event['color'] }}-500),0.1)] group-hover/item:scale-125 transition-transform"></div>
                                    <div class="space-y-2">
                                        <p class="text-xs font-black text-[#03045E] uppercase tracking-tight">{{ $event['title'] }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 tracking-widest">{{ $event['date']->translatedFormat('d M Y, H:i') }}</p>
                                        @if($event['description'])
                                            <div class="mt-3 p-4 rounded-2xl bg-slate-50 border border-slate-100/50 text-[11px] text-slate-600 font-bold leading-relaxed shadow-sm">
                                                {{ $event['description'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 border border-slate-100 shadow-inner">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Belum ada aktivitas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.pengusul-desa>
