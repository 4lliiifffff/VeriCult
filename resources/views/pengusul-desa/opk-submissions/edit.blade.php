<x-layouts.pengusul-desa>
    <x-slot name="header">
        <div class="space-y-4">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.opk-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Laporan OPK</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.opk-submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors">Detail</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">Ubah Laporan</span>
            </nav>

            <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-12 overflow-hidden shadow-2xl shadow-blue-900/20 group">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="px-5 py-2 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                                {{ $submission->status_label }}
                            </span>
                            <span class="px-5 py-2 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-black/10 text-[#00B4D8] border border-white/10">
                                ID: #{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                            Ubah <span class="text-[#00B4D8]">Laporan OPK</span>
                        </h2>
                        <div class="flex items-center gap-3 bg-white/5 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10 w-fit">
                            <svg class="w-4 h-4 text-[#00B4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-white font-bold text-sm italic">{{ $submission->name }}</span>
                        </div>
                    </div>
                        
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-5 rounded-[2rem] border border-white/20 shadow-inner">
                        <a href="{{ route('pengusul-desa.opk-submissions.show', $submission) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#03045E] rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition-all shadow-lg shadow-blue-900/20 active:scale-95 gap-2 group/btn">
                            <svg class="w-4 h-4 group-hover/btn:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-20" 
         x-data="submissionForm()"
         @dragover.prevent="dragover = true"
         @dragleave.prevent="dragover = false"
         @drop.prevent="dragover = false; handleDrop($event)">

        <!-- Loading Overlay -->
        <div x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center z-[110]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white/20">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin shadow-lg"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-3 text-center tracking-tight">Menyimpan Perubahan</h3>
                <p class="text-slate-500 text-sm font-medium text-center leading-relaxed">Mohon tunggu sebentar, kami sedang memperbarui laporan OPK Anda.</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 relative">
            
            <!-- Form Section -->
            <div class="lg:col-span-8 space-y-12">
                <div class="bg-white rounded-[2.5rem] sm:rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden group/form transition-all duration-700">
                    <div class="p-8 sm:p-14">
                        <form action="{{ route('pengusul-desa.opk-submissions.update', $submission) }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              x-ref="editForm" 
                              @submit.prevent="openConfirm()">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category" value="{{ $submission->category }}">
                            <input type="hidden" name="address" value="{{ $submission->address }}">
                            
                            @include('pengusul-desa.submissions.partials.form', ['categoryFields' => $categoryFields, 'categoryName' => $submission->category, 'submission' => $submission, 'fileDestroyRoute' => 'pengusul-desa.opk-submissions.files.destroy', 'hideUnesco' => true])

                            <!-- Footer Actions -->
                            <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-8">
                                <div class="flex items-center gap-4 bg-slate-50 px-6 py-4 rounded-[1.5rem] border border-slate-100">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100/50 flex items-center justify-center text-[#0077B6] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="space-y-0.5">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Update Terakhir</span>
                                        <span class="text-xs font-bold text-slate-600">{{ $submission->updated_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full sm:w-auto px-12 py-5 bg-gradient-to-br from-[#03045E] via-[#023E8A] to-[#0077B6] text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-blue-900/40 hover:shadow-blue-900/60 hover:-translate-y-1 transition-all duration-300 active:scale-95 group/submit"
                                        :disabled="loading">
                                    <div class="flex items-center justify-center gap-4">
                                        <span>Simpan Perubahan</span>
                                        <svg class="w-5 h-5 group-hover/submit:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 relative mt-8 lg:mt-0">
                <div class="space-y-8 sticky top-8">
                <!-- Data Meter Card -->
                <div class="bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group/status transition-all duration-700 hover:shadow-blue-900/60">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover/status:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl flex items-center justify-center border border-white/20 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-black tracking-tight text-2xl">Data Meter</h3>
                                <p class="text-blue-100/50 text-[10px] font-black uppercase tracking-widest">Update Laporan</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-blue-100/70 text-[10px] font-black uppercase tracking-widest">
                                <span>Kelengkapan Berkas</span>
                                <span class="bg-white/10 px-2 py-0.5 rounded-lg border border-white/10" x-text="progress + '%'">0%</span>
                            </div>
                            <div class="h-3 bg-white/10 rounded-full overflow-hidden border border-white/5 p-0.5">
                                <div class="h-full bg-gradient-to-r from-[#00B4D8] to-[#90E0EF] rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(144,224,239,0.5)]" :style="'width: ' + progress + '%'"></div>
                            </div>
                            <p class="text-blue-100/40 text-[10px] font-black uppercase tracking-widest text-center" x-text="progress >= 100 ? '✓ Semua field telah terisi' : 'Lengkapi sisa kolom formulir'"></p>
                        </div>
                        
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-blue-100/60 text-xs leading-relaxed font-medium italic">
                                Pastikan lampiran dokumen dan deskripsi objek telah diperbarui sesuai kondisi terkini di lapangan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Petunjuk Card -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-50 shadow-xl shadow-slate-200/40 space-y-10 group/tips">
                    <div class="flex items-center gap-4">
                        <div class="w-1.5 h-8 bg-gradient-to-b from-[#03045E] to-[#0077B6] rounded-full"></div>
                        <h3 class="text-[#03045E] font-black text-xl tracking-tight">Petunjuk Ubah</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="flex gap-6 group/item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/item:bg-[#0077B6] group-hover/item:text-white transition-all duration-500 font-black text-xs shadow-inner">01</div>
                            <div class="space-y-1">
                                <h4 class="text-[11px] font-black text-[#03045E] uppercase tracking-widest">Manajemen Berkas</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Ganti berkas lama dengan bukti dokumentasi terbaru untuk akurasi data OPK.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group/item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/item:bg-[#0077B6] group-hover/item:text-white transition-all duration-500 font-black text-xs shadow-inner">02</div>
                            <div class="space-y-1">
                                <h4 class="text-[11px] font-black text-[#03045E] uppercase tracking-widest">Status Revisi</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Perhatikan catatan revisi dari validator jika ada kolom yang perlu diperbaiki.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4 group/alert">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-amber-500 shrink-0 shadow-sm transition-transform group-hover/alert:scale-110">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Seluruh perubahan akan terekam dalam riwayat log sistem.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <x-modal name="confirm-update-submission" :show="false" focusable>
            <div class="p-10 sm:p-16 text-center">
                <div class="w-28 h-28 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-[2.5rem] flex items-center justify-center text-[#0077B6] mx-auto mb-10 shadow-inner relative group/icon overflow-hidden">
                    <div class="absolute inset-0 bg-[#00B4D8]/10 opacity-0 group-hover/icon:opacity-100 transition-opacity duration-500 animate-pulse"></div>
                    <svg class="w-14 h-14 relative z-10 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-[#03045E] mb-4 tracking-tight leading-tight">Simpan Perubahan?</h2>
                <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-12">Data laporan OPK Anda akan diperbarui. Anda bisa melanjutkan pengisian kapan saja.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                    <button type="button" 
                            @click="$dispatch('close')" 
                            class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                        Kembali
                    </button>
                    <button type="button" 
                            @click="doSubmit()" 
                            class="px-8 py-5 rounded-2xl bg-gradient-to-r from-[#03045E] to-[#0077B6] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-[0_20px_40px_-10px_rgba(3,4,94,0.3)] hover:shadow-[0_20px_40px_-10px_rgba(3,4,94,0.5)] transition-all active:scale-[0.98]">
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </x-modal>

        <!-- Max File Warning Modal -->
        <x-modal name="max-file-warning" :show="false" focusable>
            <div class="p-10 sm:p-16 text-center">
                <div class="w-28 h-28 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner group/warn">
                    <svg class="w-14 h-14 transition-transform duration-500 group-hover/warn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Batas Maksimal</h2>
                <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-12">Mohon maaf, Anda hanya dapat mengunggah maksimal 5 berkas pendukung saja.</p>

                <button type="button" 
                        @click="$dispatch('close')" 
                        class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-[0_20px_40px_-10px_rgba(225,29,72,0.3)] hover:bg-rose-700 transition-all active:scale-[0.98]">
                    SAYA MENGERTI
                </button>
            </div>
        </x-modal>

        <!-- Delete Confirmation Modal -->
        <x-modal name="confirm-delete-file" :show="false" focusable>
            <div class="p-10 sm:p-14 text-center">
                <div class="w-24 h-24 bg-rose-50 rounded-[2rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner animate-pulse">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Hapus Lampiran?</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-10">Berkas akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                    <button type="button" 
                            @click="$dispatch('close')" 
                            class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                        Batal
                    </button>
                    <form id="deleteFileForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
    </style>

    {{-- Standalone Existing File Preview Modal (outside any form) --}}
    <div id="existingFilePreviewModal" style="display:none;" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/80" onclick="closeExistingPreview()"></div>
        <div class="relative z-10 w-full max-w-4xl max-h-[90vh] flex flex-col items-center gap-4">
            <div class="w-full flex items-center justify-end">
                <button type="button" onclick="closeExistingPreview()" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all backdrop-blur-sm border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="existingFilePreviewContent" class="w-full flex items-center justify-center rounded-3xl overflow-hidden bg-slate-900/50 backdrop-blur-sm" style="max-height: 75vh;">
                <!-- content injected by JS -->
            </div>
            <p id="existingFilePreviewName" class="text-white/80 text-sm font-bold tracking-wide text-center truncate max-w-full px-4"></p>
        </div>
    </div>

    <script>
        function openExistingPreview(url, type, name) {
            const modal = document.getElementById('existingFilePreviewModal');
            const content = document.getElementById('existingFilePreviewContent');
            const nameEl = document.getElementById('existingFilePreviewName');
            if (type === 'image') {
                content.innerHTML = `<img src="${url}" class="max-w-full max-h-[70vh] object-contain rounded-2xl shadow-2xl">`;
            } else if (type === 'video') {
                content.innerHTML = `<video src="${url}" controls autoplay class="max-w-full max-h-[70vh] rounded-2xl shadow-2xl" style="max-height:70vh;"></video>`;
            }
            nameEl.textContent = name;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeExistingPreview() {
            const modal = document.getElementById('existingFilePreviewModal');
            const content = document.getElementById('existingFilePreviewContent');
            const video = content.querySelector('video');
            if (video) { video.pause(); video.src = ''; }
            content.innerHTML = '';
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        function deleteExistingFile(url) {
            const form = document.getElementById('deleteFileForm');
            if (form) {
                form.action = url;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete-file' }));
            }
        }
    </script>

    <script>
        function submissionForm() {
            return {
                loading: false,
                files: [],
                dragover: false,
                progress: 0,
                activeSubCategory: '{{ $submission->category_data[$categoryFields['sub_field'] ?? ''] ?? '' }}',
                
                init() {
                    this.$nextTick(() => {
                        this.recalcProgress();
                    });

                    const form = this.$refs.editForm;
                    if (form) {
                        form.addEventListener('input', () => this.recalcProgress());
                        form.addEventListener('change', () => this.recalcProgress());
                    }

                    this.$watch('files', () => this.$nextTick(() => this.recalcProgress()));
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

                    const existingFilesCount = {{ $submission->files->count() }};
                    if (dt.items.length + existingFilesCount > 5) {
                        this.$dispatch('open-modal', 'max-file-warning');
                        const availableSlots = 5 - existingFilesCount;
                        const limitedDt = new DataTransfer();
                        for (let i = 0; i < Math.min(dt.items.length, availableSlots); i++) {
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

                recalcProgress() {
                    this.progress = this.calculateProgress();
                },

                calculateProgress() {
                    let totalRequired = 0;
                    let filledRequired = 0;

                    const form = this.$refs.editForm;
                    if (!form) return {{ $submission->progress ?? 0 }};

                    const requiredContainers = form.querySelectorAll('[data-required="true"]');
                    requiredContainers.forEach(container => {
                        if (!this.isVisible(container)) return;
                        
                        totalRequired++;
                        
                        const inputs = container.querySelectorAll('input, textarea, select');
                        let isFilled = false;
                        
                        inputs.forEach(input => {
                            if (input.type === 'radio' || input.type === 'checkbox') {
                                if (input.checked) isFilled = true;
                            } else if (input.value && input.value.trim() !== '') {
                                isFilled = true;
                            }
                        });

                        if (isFilled) filledRequired++;
                    });

                    totalRequired++;
                    if ({{ $submission->files->count() }} > 0 || this.files.length > 0) filledRequired++;

                    if (totalRequired === 0) return 0;
                    return Math.min(100, Math.round((filledRequired / totalRequired) * 100));
                },

                isVisible(el) {
                    if (!el) return false;
                    let current = el;
                    while (current && current !== document.body) {
                        const style = window.getComputedStyle(current);
                        if (style.display === 'none' || current.hasAttribute('x-cloak')) return false;
                        if (current.hasAttribute('x-show') && current.style.display === 'none') {
                             return false;
                        }
                        current = current.parentElement;
                    }
                    return true;
                },

                formatSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                openConfirm() {
                    this.$dispatch('open-modal', 'confirm-update-submission');
                },

                doSubmit() {
                    this.loading = true;
                    this.$dispatch('close');
                    this.$nextTick(() => {
                        this.$refs.editForm.submit();
                    });
                }
            }
        }
    </script>
</x-layouts.pengusul-desa>
