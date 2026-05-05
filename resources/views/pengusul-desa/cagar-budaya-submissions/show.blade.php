<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul-desa.cagar-budaya-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Potensi Cagar Budaya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[150px] sm:max-w-none">{{ $submission->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div class="space-y-3 w-full md:w-auto">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">CB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="font-black text-3xl sm:text-4xl text-[#03045E] leading-tight tracking-tight break-words">
                    {{ $submission->name }}
                </h2>
                <div class="flex items-center gap-2 text-slate-500 font-bold text-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#0077B6] shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span>{{ $submission->category }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto mt-2 md:mt-0">
                <a href="{{ route('pengusul-desa.cagar-budaya-submissions.index') }}" class="w-full md:w-auto justify-center inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm shadow-slate-200/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
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
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 0-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
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
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <div class="p-6 sm:p-14">
                        <div class="space-y-12">
                            <!-- Description -->
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Deskripsi Potensi</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] bg-blue-50/10 border border-blue-100/30 overflow-hidden">
                                    <div class="prose prose-slate max-w-none w-full break-words">
                                        <p class="text-slate-700 leading-[1.8] sm:leading-[2] font-medium text-base sm:text-lg italic">
                                            "{{ $submission->description ?? 'Tidak ada deskripsi.' }}"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Details -->
                            @if(!empty($submission->category_data))
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Data Potensi Cagar Budaya</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-8 border border-slate-100">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                        @foreach($categoryFields as $fieldKey => $field)
                                            @if(isset($submission->category_data[$fieldKey]))
                                                <div class="space-y-1">
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</p>
                                                    <p class="text-slate-800 font-bold text-base">
                                                        {{ is_array($submission->category_data[$fieldKey]) ? json_encode($submission->category_data[$fieldKey]) : $submission->category_data[$fieldKey] }}
                                                    </p>
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
                                        <span class="shrink-0">Lampiran Bukti Potensi</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <span class="ml-4 px-3 py-1 rounded-lg bg-[#0077B6] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                                </div>
                                
                                @if($submission->files->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($submission->files as $file)
                                            <div class="group/file relative flex flex-col p-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                                                <div class="relative w-full h-44 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-4 border border-slate-50/50 shadow-inner group-hover/file:border-[#0077B6]/20 transition-colors">
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
                                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="px-1 min-w-0 flex-1">
                                                    <p class="text-[14px] font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors mb-1" title="{{ $file->original_name }}">
                                                        {{ $file->original_name }}
                                                    </p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                                        <span>{{ $file->file_size_human }}</span>
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-100"></span>
                                                        <span class="text-[#00B4D8]">{{ strtoupper($file->file_type) }}</span>
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2 mt-5 pt-4 border-t border-slate-50">
                                                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-slate-50 text-slate-500 hover:bg-[#0077B6] hover:text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        Unduh Berkas
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-16 rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center group">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm tracking-wide">Belum ada lampiran pendukung.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Notes -->
                @php $latestReview = $submission->administrativeReviews->last(); @endphp
                @if($latestReview && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_REVISION, \App\Models\CulturalSubmission::STATUS_REJECTED]))
                <div class="bg-amber-50/50 rounded-[2.5rem] p-10 border border-amber-100 shadow-sm">
                    <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.25em] mb-6">
                        Catatan {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'Revisi' : 'Penolakan' }}
                    </h3>
                    <div class="p-8 rounded-[1.5rem] bg-white border border-amber-200 text-slate-700 leading-relaxed font-bold italic">
                        "{{ $latestReview->notes }}"
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4 space-y-10">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-10 space-y-8">
                    <div>
                        <h3 class="text-[#03045E] font-black text-2xl tracking-tight mb-2">Kelola Pengajuan</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Alur Pendaftaran</p>
                    </div>

                    <div class="space-y-4">
                        @if($submission->isEditable())
                            <a href="{{ route('pengusul-desa.cagar-budaya-submissions.edit', $submission) }}" 
                               class="flex items-center justify-center gap-3 w-full px-8 py-5 rounded-[1.25rem] bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-[0.2em] uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Perbarui Data
                            </a>

                            <form action="{{ route('pengusul-desa.cagar-budaya-submissions.submit', $submission) }}" method="POST">
                                @csrf
                                <button type="submit" @click="submitting = true" class="flex items-center justify-center gap-4 w-full px-8 py-6 rounded-[1.25rem] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.25em] uppercase shadow-2xl shadow-blue-900/40 hover:-translate-y-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Sekarang
                                </button>
                            </form>

                            <button type="button" @click="$dispatch('open-modal', 'confirm-delete')" class="w-full py-4 text-rose-600 font-black text-[10px] tracking-[0.2em] uppercase hover:text-rose-700 transition-colors">
                                Batalkan Pengajuan
                            </button>
                            
                            <x-modal name="confirm-delete" focusable maxWidth="md">
                                <form action="{{ route('pengusul-desa.cagar-budaya-submissions.destroy', $submission) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="p-10 text-center">
                                        <h3 class="text-2xl font-black text-[#03045E] mb-4">Hapus Pengajuan?</h3>
                                        <p class="text-slate-500 font-medium mb-8">Tindakan ini tidak dapat dibatalkan.</p>
                                        <div class="flex gap-4">
                                            <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="flex-1 py-4 bg-slate-100 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-500">Batal</button>
                                            <button type="submit" @click="deleting = true" class="flex-1 py-4 bg-rose-600 rounded-2xl font-black text-xs uppercase tracking-widest text-white shadow-xl shadow-rose-900/20">Ya, Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </x-modal>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                    <div class="p-10 border-b border-slate-50">
                        <h3 class="text-[#03045E] font-black text-lg">Riwayat Status</h3>
                    </div>
                    <div class="p-10 space-y-8">
                        @foreach($timeline as $event)
                            <div class="relative pl-8 group">
                                @if(!$loop->last)
                                    <div class="absolute left-[7px] top-6 bottom-[-24px] w-px bg-slate-100 group-hover:bg-[#0077B6]/30 transition-colors"></div>
                                @endif
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full border-2 border-white bg-{{ $event['color'] ?? 'blue' }}-500"></div>
                                <div class="space-y-1">
                                    <p class="text-xs font-black text-slate-800 uppercase">{{ $event['title'] }}</p>
                                    <p class="text-[10px] font-bold text-slate-400">{{ $event['date']->translatedFormat('d M Y, H:i') }}</p>
                                    @if(isset($event['description']))
                                        <div class="mt-2 p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-600 italic">
                                            "{{ $event['description'] }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.pengusul-desa>
