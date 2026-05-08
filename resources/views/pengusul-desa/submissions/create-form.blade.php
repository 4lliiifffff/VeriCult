<x-layouts.pengusul-desa>
    <div x-data="submissionForm()"
        class="pb-20"
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
            <h3 class="text-[#03045E] font-black text-xl mb-3 text-center tracking-tight">Memproses Draft</h3>
            <p class="text-slate-500 text-sm font-medium text-center leading-relaxed">Mohon tunggu sebentar, kami sedang menyiapkan pengajuan Anda.</p>
        </div>
    </div>

    <x-slot name="header">
        <div class="space-y-4">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
                <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.submissions.create') }}" class="hover:text-[#0077B6] transition-colors text-slate-400">Pilih Jenis</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">{{ $categoryName }}</span>
            </nav>

            <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 group">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] pointer-events-none">
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
                </div>
                
                <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Langkah 2 dari 2</span>
                            </div>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                            {{ $categorySlug === 'laporan-kebudayaan-aktif' ? 'Melaporkan Kebudayaan Aktif' : 'Daftarkan ' . $categoryName }}
                        </h2>
                        <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">
                            {{ $categorySlug === 'laporan-kebudayaan-aktif' ? 'Dokumentasikan kebudayaan yang sedang dilaksanakan secara aktif di masyarakat.' : $categoryDescription }}
                        </p>
                    </div>
                        
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-[2rem] border border-slate-100 shadow-inner relative z-20">
                        <a href="{{ route('pengusul-desa.submissions.create') }}" class="w-full sm:w-auto bg-[#03045E] text-white px-8 py-4 sm:py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 group/print">
                            <svg class="w-4 h-4 group-hover/btn:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Ganti Jenis Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 pb-20">
        
        <!-- Form Section -->
        <div class="lg:col-span-8 space-y-12">
            <div class="bg-white rounded-[2.5rem] sm:rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden group/form transition-all duration-700">
                <div class="p-8 sm:p-14">
                    <form action="{{ route('pengusul-desa.submissions.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        x-ref="mainForm" 
                        @submit.prevent="openConfirm()">
                        @csrf
                        <input type="hidden" name="category" value="{{ $categoryName }}">
                        <input type="hidden" name="address" value="-">
                        
                        @php $submission = new \stdClass; $submission->name = ''; $submission->address = ''; $submission->description = ''; $submission->category_data = old('category_data', []); $submission->category = $categoryName; @endphp
                        @include('pengusul-desa.submissions.partials.form', ['categoryFields' => $categoryFields, 'categoryName' => $categoryName, 'submission' => $submission])

                        <!-- Footer Actions -->
                        <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-8">
                            <div class="flex items-center gap-4 bg-slate-50 px-6 py-4 rounded-[1.5rem] border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-blue-100/50 flex items-center justify-center text-[#0077B6] shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Simpan sebagai draft untuk dikirim nanti.</span>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full sm:w-auto px-12 py-5 bg-gradient-to-br from-[#03045E] via-[#023E8A] to-[#0077B6] text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-blue-900/40 hover:shadow-blue-900/60 hover:-translate-y-1 transition-all duration-300 active:scale-95 group/submit"
                                    :disabled="loading">
                                <div class="flex items-center justify-center gap-3">
                                    <span>Simpan Draft Pengajuan</span>
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
                <!-- Status Card -->
                <div class="bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group/status transition-all duration-700 hover:shadow-blue-900/60">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover/status:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl flex items-center justify-center border border-white/20 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-black tracking-tight text-2xl">Status Draft</h3>
                                <p class="text-blue-100/50 text-[10px] font-black uppercase tracking-widest">{{ $categoryName }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-blue-100/70 text-[10px] font-black uppercase tracking-widest">
                                <span>Kelengkapan Data</span>
                                <span class="bg-white/10 px-2 py-0.5 rounded-lg border border-white/10" x-text="progress + '%'">0%</span>
                            </div>
                            <div class="h-3 bg-white/10 rounded-full overflow-hidden border border-white/5 p-0.5">
                                <div class="h-full bg-gradient-to-r from-[#00B4D8] to-[#90E0EF] rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(144,224,239,0.5)]" :style="'width: ' + progress + '%'"></div>
                            </div>
                            <p class="text-blue-100/40 text-[10px] font-black uppercase tracking-widest text-center" x-text="progress >= 100 ? '✓ Semua field telah terisi' : 'Lengkapi seluruh kolom formulir'"></p>
                        </div>
                        
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-blue-100/60 text-xs leading-relaxed font-medium italic">
                                Draft akan tersimpan otomatis setelah diproses. Anda dapat melanjutkan pengisian kapan saja dari dashboard.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-50 shadow-xl shadow-slate-200/40 space-y-10 group/tips">
                    <div class="flex items-center gap-4">
                        <div class="w-1.5 h-8 bg-gradient-to-b from-[#03045E] to-[#0077B6] rounded-full"></div>
                        <h3 class="text-[#03045E] font-black text-xl tracking-tight">Panduan Pengisian</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="flex gap-6 group/item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/item:bg-[#0077B6] group-hover/item:text-white transition-all duration-500 font-black text-xs shadow-inner">01</div>
                            <div class="space-y-1">
                                <h4 class="text-[11px] font-black text-[#03045E] uppercase tracking-widest">Informasi Dasar</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Isi nama, alamat, dan deskripsi lengkap objek kebudayaan.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group/item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/item:bg-[#0077B6] group-hover/item:text-white transition-all duration-500 font-black text-xs shadow-inner">02</div>
                            <div class="space-y-1">
                                <h4 class="text-[11px] font-black text-[#03045E] uppercase tracking-widest">Detail Kategori</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Lengkapi kolom khusus yang tersedia untuk kategori ini.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group/item">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/item:bg-[#0077B6] group-hover/item:text-white transition-all duration-500 font-black text-xs shadow-inner">03</div>
                            <div class="space-y-1">
                                <h4 class="text-[11px] font-black text-[#03045E] uppercase tracking-widest">Bukti Digital</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">Unggah foto atau dokumen otentik untuk memperkuat pengajuan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4 group/alert">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-amber-500 shrink-0 shadow-sm transition-transform group-hover/alert:scale-110">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Pastikan semua data benar sebelum mengirim.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-save-submission" :show="false" focusable>
        <div class="p-10 sm:p-16 text-center">
            <div class="w-28 h-28 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-[2.5rem] flex items-center justify-center text-[#0077B6] mx-auto mb-10 shadow-inner relative group/icon overflow-hidden">
                <div class="absolute inset-0 bg-[#00B4D8]/10 opacity-0 group-hover/icon:opacity-100 transition-opacity duration-500 animate-pulse"></div>
                <svg class="w-14 h-14 relative z-10 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-black text-[#03045E] mb-4 tracking-tight leading-tight">Simpan Draft?</h2>
            <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-12">Data Anda akan disimpan dengan aman. Anda bisa melanjutkan pengisian kapan saja.</p>

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
                progress: 0,
                
                init() {
                    this.$nextTick(() => {
                        this.recalcProgress();
                    });

                    const form = this.$refs.mainForm;
                    if (form) {
                        form.addEventListener('input', () => this.recalcProgress());
                        form.addEventListener('change', () => this.recalcProgress());
                    }

                    this.$watch('files', () => this.recalcProgress());
                },

                handleDrop(event) {
                    const dt = event.dataTransfer;
                    if (dt.files.length + this.files.length > 5) {
                        this.$dispatch('open-modal', 'max-file-warning');
                        const limitedDt = new DataTransfer();
                        for (let i = 0; i < Math.min(dt.items.length, 5); i++) {
                            limitedDt.items.add(dt.files[i]);
                        }
                        this.updateFiles(limitedDt);
                    } else {
                        this.updateFiles(dt);
                    }
                },

                handleFileSelect(event) {
                    const dt = new DataTransfer();
                    const newFiles = Array.from(event.target.files);
                    const existingFiles = this.files;
                    const combined = [...existingFiles, ...newFiles];

                    if (combined.length > 5) {
                        this.$dispatch('open-modal', 'max-file-warning');
                    }

                    combined.slice(0, 5).forEach(f => dt.items.add(f));
                    this.updateFiles(dt);
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

                recalcProgress() {
                    this.progress = this.calculateProgress();
                },

                calculateProgress() {
                    let totalQuestions = 0;
                    let filledQuestions = 0;

                    const desc = document.getElementById('description');
                    if (desc) {
                        totalQuestions++;
                        if (desc.value && desc.value.trim().length >= 10) filledQuestions++;
                    }

                    const form = this.$refs.mainForm;
                    if (!form) return 0;

                    const visibleInputs = form.querySelectorAll('input[type="text"][data-category-field], textarea[data-category-field]:not(#description)');
                    visibleInputs.forEach(el => {
                        if (!this.isVisible(el)) return;
                        totalQuestions++;
                        if (el.value && el.value.trim() !== '') filledQuestions++;
                    });

                    const hiddenInputs = form.querySelectorAll('input[type="hidden"][data-category-field]');
                    hiddenInputs.forEach(el => {
                        if (el.name === 'category' || el.name === 'address') return;
                        if (!this.isVisible(el.parentElement)) return;
                        totalQuestions++;
                        if (el.value && el.value.trim() !== '') filledQuestions++;
                    });

                    const radioNames = new Set();
                    form.querySelectorAll('input[type="radio"][data-category-field]').forEach(el => {
                        if (!this.isVisible(el)) return;
                        radioNames.add(el.name);
                    });
                    radioNames.forEach(name => {
                        totalQuestions++;
                        const checked = form.querySelector(`input[type="radio"][name="${name}"]:checked`);
                        if (checked) filledQuestions++;
                    });

                    const cbNames = new Set();
                    form.querySelectorAll('input[type="checkbox"][data-category-field]').forEach(el => {
                        if (!this.isVisible(el)) return;
                        cbNames.add(el.name.replace('[]', ''));
                    });
                    cbNames.forEach(name => {
                        totalQuestions++;
                        const checked = form.querySelector(`input[type="checkbox"][name^="${name}"]:checked`);
                        if (checked) filledQuestions++;
                    });

                    totalQuestions++;
                    if (this.files.length > 0) filledQuestions++;

                    if (totalQuestions === 0) return 0;
                    return Math.min(100, Math.round((filledQuestions / totalQuestions) * 100));
                },

                isVisible(el) {
                    if (!el) return false;
                    let current = el;
                    while (current && current !== document.body) {
                        const style = window.getComputedStyle(current);
                        if (style.display === 'none') return false;
                        current = current.parentElement;
                    }
                    return true;
                },

                openConfirm() {
                    this.$dispatch('open-modal', 'confirm-save-submission');
                },

                doSubmit() {
                    this.loading = true;
                    this.$dispatch('close');
                    this.$nextTick(() => {
                        this.$refs.mainForm.submit();
                    });
                }
            }
        }
    </script>
</x-layouts.pengusul-desa>
