<x-layouts.pengusul>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors">Detail</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Ubah Data</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="font-black text-4xl text-[#03045E] leading-tight tracking-tight">
                    Edit <span class="text-[#0077B6]">Pengajuan</span>
                </h2>
                <p class="text-slate-500 font-bold text-sm">Update informasi objek kebudayaan: <span class="text-[#03045E]">{{ $submission->name }}</span></p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('pengusul.submissions.show', $submission) }}" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm">
                    Batal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10" 
         x-data="submissionForm()"
         @dragover.prevent="dragover = true"
         @dragleave.prevent="dragover = false"
         @drop.prevent="dragover = false; handleDrop($event)">

        <!-- Loading Overlay -->
        <div x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-[#03045E]/10 backdrop-blur-md flex items-center justify-center z-[100]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center">Menyimpan Perubahan</h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Mohon tunggu sebentar...</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Form Section -->
            <div class="lg:col-span-8 space-y-10">
                <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                    <div class="p-10 sm:p-14">
                        <form action="{{ route('pengusul.submissions.update', $submission) }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              x-ref="editForm" 
                              @submit.prevent="openConfirm()">
                            @csrf
                            @method('PUT')
                            
                            @include('pengusul.submissions.partials.form')

                            <!-- Footer Actions -->
                            <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-8">
                                <div class="flex items-center gap-4 text-slate-400">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="text-xs font-black uppercase tracking-widest italic">Pembaruan Draft Terakhir: {{ $submission->updated_at->diffForHumans() }}</span>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full sm:w-auto px-12 py-5 bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black rounded-[1.5rem] shadow-2xl shadow-blue-900/30 hover:shadow-blue-900/40 hover:-translate-y-1 transition-all duration-300 active:scale-95 group"
                                        :disabled="loading">
                                    <div class="flex items-center justify-center gap-4">
                                        <span class="tracking-[0.2em] uppercase text-xs">Simpan Perubahan</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 space-y-10">
                <!-- Progress Card -->
                <div class="bg-[#03045E] rounded-[2.5rem] p-10 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="font-black tracking-tight text-2xl">Data Meter</span>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between text-white/70 text-[10px] font-black uppercase tracking-widest">
                                <span>Kelengkapan Berkas</span>
                                <span class="text-[#00B4D8]" x-text="calculateProgress() + '%'">0%</span>
                            </div>
                            <div class="h-3 bg-white/10 rounded-full overflow-hidden border border-white/5 p-0.5">
                                <div class="h-full bg-gradient-to-r from-[#00B4D8] to-[#0077B6] rounded-full transition-all duration-1000" :style="'width: ' + calculateProgress() + '%'"></div>
                            </div>
                        </div>
                        <p class="mt-8 text-blue-200/60 text-[10px] font-black uppercase tracking-widest leading-relaxed italic">
                            Pastikan lampiran dokumen harian lengkap sebelum diajukan.
                        </p>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/50 space-y-8">
                    <h3 class="text-[#03045E] font-black text-xl tracking-tight flex items-center gap-4">
                        <span class="w-1.5 h-6 bg-[#00B4D8] rounded-full"></span>
                        Petunjuk Edit
                    </h3>
                    <div class="space-y-6">
                        <div class="flex gap-5 group">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] group-hover:scale-110 transition-transform border border-slate-100 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-700 uppercase tracking-widest mb-1">Manajemen File</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed font-bold">
                                    Unggah file baru jika perlu mengganti atau menambah dokumen pendukung.
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-5 group">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] group-hover:scale-110 transition-transform border border-slate-100 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-700 uppercase tracking-widest mb-1">Status Draft</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed font-bold">
                                    Hanya status <span class="text-[#03045E]">Draft</span> yang dapat diubah kontennya secara langsung.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <x-modal name="confirm-update-submission" :show="false" focusable>
            <div class="p-10 sm:p-14 text-center">
                <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center text-[#0077B6] mx-auto mb-8 shadow-inner animate-bounce-slow">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Simpan Draft?</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-10">Data yang Anda ubah akan diperbarui sebagai draft terbaru dalam sistem kami.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                    <button type="button" 
                            @click="$dispatch('close')" 
                            class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                        Batal
                    </button>
                    <button type="button" 
                            @click="doSubmit()" 
                            class="px-8 py-5 rounded-2xl bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] transition-all active:scale-[0.98]">
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </x-modal>

        <!-- Max File Warning Modal -->
        <x-modal name="max-file-warning" :show="false" focusable>
            <div class="p-10 sm:p-14 text-center">
                <div class="w-24 h-24 bg-rose-50 rounded-[2rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-rose-900 mb-3 tracking-tight">Batas File Tercapai</h2>
                <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-10">Total file (lama + baru) tidak boleh melebihi 5 file sebagai bukti pendukung.</p>

                <button type="button" 
                        @click="$dispatch('close')" 
                        class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                    SAYA MENGERTI
                </button>
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

    <script>
        function submissionForm() {
            return {
                loading: false,
                files: [],
                dragover: false,
                
                init() {
                    // Initialize component
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

                    // Calculate total files including existing ones from DB
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

                formatSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + ['Bytes', 'KB', 'MB', 'GB'][i];
                },

                calculateProgress() {
                    const fields = ['name', 'category', 'address', 'description'];
                    let filledCount = 0;
                    fields.forEach(id => {
                        const el = document.getElementById(id);
                        if (el && el.value.trim() !== '') filledCount++;
                    });
                    // Check files (either existing or new)
                    if ({{ $submission->files->count() }} > 0 || this.files.length > 0) filledCount++;
                    return Math.round((filledCount / (fields.length + 1)) * 100);
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
</x-layouts.pengusul>
