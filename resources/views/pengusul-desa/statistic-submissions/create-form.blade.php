<x-layouts.pengusul-desa>
    <div x-data="submissionForm()"
        class="pb-10"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @drop.prevent="dragover = false; handleDrop($event)">

    <!-- Loading Overlay -->
    <div x-show="loading"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-slate-900/75 flex items-center justify-center z-[100]"
        style="display: none;">
        <div class="bg-white p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white/20">
            <div class="relative w-20 h-20 mb-6">
                <div class="absolute inset-0 border-4 border-[#0077B6]/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
            </div>
            <h3 class="text-[#03045E] font-bold text-xl mb-2 text-center">Memproses Laporan</h3>
            <p class="text-slate-500 text-sm text-center">Mohon tunggu sebentar, kami sedang menyiapkan laporan statistik Anda.</p>
        </div>
    </div>

        <x-slot name="header">
            <!-- Breadcrumbs & Navigation -->
            <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
                <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.statistic-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Laporan Statistik</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.statistic-submissions.create') }}" class="hover:text-[#0077B6] transition-colors">Pilih Kategori</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">{{ $categoryName }}</span>
            </nav>

            <!-- Page Header -->
            <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-6 sm:p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                                <span class="relative inline-flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0077B6] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0077B6]"></span>
                                </span>
                                <span class="px-1 py-1 text-[10px] font-bold uppercase tracking-wider text-white">Langkah 2 dari 2 &bull; <span class="truncate max-w-[100px] sm:max-w-[200px] inline-block align-bottom">{{ $categoryName }}</span></span>
                            </div>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                            Laporkan <span class="text-[#00B4D8]">{{ $categoryName }}</span>
                        </h2>
                        <p class="text-blue-100/70 text-base sm:text-lg font-medium break-words">{{ $categoryDescription }}</p>
                    </div>

                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-3 sm:p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto mt-4 md:mt-0">
                        <a href="{{ route('pengusul-desa.statistic-submissions.create') }}" class="w-full md:w-auto justify-center bg-white text-[#03045E] px-4 sm:px-6 py-3 rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10">
                            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Ganti Kategori
                        </a>
                    </div>
                </div>
            </div>
        </x-slot>

        <!-- Main Content -->
        <div class="max-w-5xl mx-auto space-y-8">

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 relative pb-20">

            <!-- Form Section -->
            <div class="lg:col-span-8 space-y-10 px-4 sm:px-0">
                <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white">
                    <div class="p-6 sm:p-10">
                        <form action="{{ route('pengusul-desa.statistic-submissions.store') }}"
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
                            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-3 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm font-medium italic">Simpan sebagai draft untuk dikirim nanti.</span>
                                </div>

                                <button type="submit" 
                                        class="w-full sm:w-auto px-10 py-4 bg-gradient-to-br from-[#03045E] via-[#023E8A] to-[#0077B6] text-white font-bold rounded-2xl shadow-xl shadow-[#03045E]/20 hover:shadow-2xl hover:shadow-[#03045E]/30 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 group">
                                    <div class="flex items-center justify-center gap-3">
                                        <span class="tracking-wider uppercase text-sm">Simpan Draft Laporan</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 relative px-4 sm:px-0 mt-8 lg:mt-0">
                <div class="space-y-10 sticky top-8">
                    <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-2xl sm:rounded-[2rem] p-5 sm:p-8 text-white shadow-2xl shadow-[#03045E]/40 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <span class="font-bold tracking-tight text-xl">Status Laporan</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-white/70 text-sm">
                                <span>Progress Pengisian</span>
                                <span x-text="progress + '%'">0%</span>
                            </div>
                            <div class="h-2 bg-white/10 rounded-full overflow-hidden border border-white/5">
                                <div class="h-full bg-gradient-to-r from-[#00B4D8] to-[#0077B6] rounded-full transition-all duration-700 ease-out" :style="'width: ' + progress + '%'"></div>
                            </div>
                            <p class="text-white/50 text-[10px] font-semibold" x-text="progress >= 100 ? '✓ Semua field telah terisi' : 'Isi semua field untuk melengkapi formulir'"></p>
                        </div>
                        <div class="mt-6 px-4 py-2 rounded-xl bg-white/10 border border-white/10">
                            <p class="text-white/80 text-xs font-bold">Kategori: {{ $categoryName }}</p>
                        </div>
                        <p class="mt-4 text-white/60 text-xs leading-relaxed italic">
                            Laporan Anda akan tersimpan secara otomatis di sistem kami setelah diproses.
                        </p>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-white rounded-2xl sm:rounded-[2rem] p-5 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                    <h3 class="text-[#03045E] font-black text-lg flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-[#0077B6] rounded-full"></span>
                        Panduan Pengisian
                    </h3>
                    <div class="space-y-5">
                        <div class="flex gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                                <span class="text-xs font-bold">01</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 mb-1">Data Akurat</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Pastikan data statistik yang dimasukkan sesuai dengan kondisi terbaru di desa.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                                <span class="text-xs font-bold">02</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 mb-1">Detail {{ $categoryName }}</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Lengkapi kolom khusus statistik yang tersedia untuk kategori ini.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                                <span class="text-xs font-bold">03</span>
                            </div>
                            <div>
                                    <h4 class="text-sm font-bold text-slate-700 mb-1">Bukti Dukung</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">Unggah file pendukung jika diperlukan untuk memverifikasi data statistik.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Confirmation Modal -->
        <x-modal name="confirm-submission" :show="false" focusable>
            <div class="p-10 sm:p-14 text-center">
                <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center text-[#0077B6] mx-auto mb-8 shadow-inner animate-bounce-slow">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Simpan Draft?</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-10">Data statistik Anda akan disimpan sebagai draft dalam sistem kami.</p>

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
                <h2 class="text-3xl font-black text-rose-900 mb-3 tracking-tight">Batas Berkas Tercapai</h2>
                <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-10">Total berkas tidak boleh melebihi 5 berkas sebagai bukti pendukung.</p>

                <button type="button" 
                        @click="$dispatch('close')" 
                        class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                    SAYA MENGERTI
                </button>
            </div>
        </x-modal>

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
                        this.progress = this.calculateProgress();
                    });

                    const form = this.$refs.mainForm;
                    if (form) {
                        form.addEventListener('input', () => this.progress = this.calculateProgress());
                        form.addEventListener('change', () => this.progress = this.calculateProgress());
                    }

                    this.$watch('files', () => this.$nextTick(() => this.progress = this.calculateProgress()));
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
                        this.$dispatch('open-modal', 'max-file-warning');
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

                calculateProgress() {
                    let totalRequired = 0;
                    let filledRequired = 0;

                    const form = this.$refs.mainForm;
                    if (!form) return 0;

                    // 1. Inputs with data-required
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

                    // 2. Files (as one unit of progress)
                    totalRequired++;
                    if (this.files.length > 0) filledRequired++;

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
                    this.$dispatch('open-modal', 'confirm-submission');
                },

                doSubmit() {
                    this.loading = true;
                    this.$refs.mainForm.submit();
                }
            }
        }
    </script>
</x-layouts.pengusul-desa>
