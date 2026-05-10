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
            <h3 class="text-[#03045E] font-black text-xl mb-3 text-center tracking-tight">Memproses Laporan</h3>
            <p class="text-slate-500 text-sm font-medium text-center leading-relaxed">Mohon tunggu sebentar, kami sedang menyiapkan laporan potensi cagar budaya Anda.</p>
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
                <a href="{{ route('pengusul-desa.submissions.create') }}" class="hover:text-[#0077B6] transition-colors">Pilih Jenis</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">Cagar Budaya</span>
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
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Potensi Cagar Budaya</span>
                            </div>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                            Laporkan <span class="text-[#00B4D8]">Objek Potensi</span>
                        </h2>
                        <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">
                            {{ $categoryDescription }}
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
                    <form action="{{ route('pengusul-desa.cagar-budaya-submissions.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        x-ref="mainForm" 
                        @submit.prevent="openConfirm() {
                    let emptyRequired = [];
                    
                    // 1. Sync & Check Name from DOM
                    const nameEl = document.getElementById('name');
                    if (nameEl) {
                        this.submissionName = nameEl.value;
                        if (!this.submissionName || this.submissionName.trim() === '') {
                            emptyRequired.push('Identitas Umum (Nama Objek / Kebudayaan)');
                        }
                    }
                    
                    // 2. Check Description from DOM (only if it exists and is visible)
                    const descEl = document.getElementById('description');
                    if (descEl) {
                        let isVisible = true;
                        let parent = descEl.parentElement;
                        while (parent && parent !== document.body) {
                            const style = window.getComputedStyle(parent);
                            if (style.display === 'none' || style.visibility === 'hidden') {
                                isVisible = false;
                                break;
                            }
                            parent = parent.parentElement;
                        }
                        
                        if (isVisible && (!descEl.value || descEl.value.trim() === '')) {
                            emptyRequired.push('Deskripsi Kebudayaan');
                        }
                    }
                    
                    // 3. Check Files (ONLY if the file section is visible in DOM)
                    const filesInput = document.getElementById('files');
                    if (filesInput) {
                        const hasNewFiles = (filesInput.files && filesInput.files.length > 0) || (this.files && this.files.length > 0);
                        const hasExistingFiles = document.querySelectorAll('.group\\/file:not([x-show])').length > 0;
                        
                        if (!hasNewFiles && !hasExistingFiles) {
                            emptyRequired.push('Data Dukung (Minimal 1 Foto/Video/Dokumen)');
                        }
                    }

                    if (emptyRequired.length > 0) {
                        this.emptyFieldsList = emptyRequired;
                        this.$dispatch('open-modal', 'validation-warning-modal');
                        return;
                    }
                    
                    this.$dispatch('open-modal', 'confirm-submission');
                }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
    </style>

    
        <!-- Validation Warning Modal -->
        <x-modal name="validation-warning-modal" :show="false" focusable>
            <div class="p-10 sm:p-16 text-center">
                <div class="w-28 h-28 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner group/warn">
                    <svg class="w-14 h-14 transition-transform duration-500 group-hover/warn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Data Belum Lengkap!</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-6">Anda tidak dapat menyimpan karena terdapat data wajib yang belum diisi:</p>
                
                <div class="bg-rose-50/50 rounded-2xl p-6 text-left max-w-sm mx-auto mb-12 border border-rose-100">
                    <ul class="space-y-3">
                        <template x-for="field in emptyFieldsList" :key="field">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-rose-700 font-bold text-sm" x-text="field"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <button type="button" 
                        @click="$dispatch('close')" 
                        class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-[0_20px_40px_-10px_rgba(225,29,72,0.3)] hover:bg-rose-700 transition-all active:scale-[0.98]">
                    KEMBALI KE FORMULIR
                </button>
            </div>
        </x-modal>

    <script>
        function submissionForm() {
            return {
                loading: false,
                files: [],
                dragover: false,
                emptyFieldsList: [],
                submissionName: @js(old('name', $submission->name ?? '')),
                
                
                
                
                
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

                openConfirm()  {
                    let emptyRequired = [];
                    
                    const nameEl = document.getElementById('name');
                    if (nameEl) {
                        this.submissionName = nameEl.value;
                        if (!this.submissionName || this.submissionName.trim() === '') {
                            emptyRequired.push('Identitas Umum (Nama Objek / Kebudayaan)');
                        }
                    }
                    
                    const descEl = document.getElementById('description');
                    if (descEl) {
                        let isVisible = true;
                        let parent = descEl.parentElement;
                        while (parent && parent !== document.body) {
                            const style = window.getComputedStyle(parent);
                            if (style.display === 'none' || style.visibility === 'hidden') {
                                isVisible = false;
                                break;
                            }
                            parent = parent.parentElement;
                        }
                        if (isVisible && (!descEl.value || descEl.value.trim() === '')) {
                            emptyRequired.push('Deskripsi Kebudayaan');
                        }
                    }
                    
                    const filesInput = document.getElementById('files');
                    if (filesInput) {
                        const hasNewFiles = (filesInput.files && filesInput.files.length > 0) || (this.files && this.files.length > 0);
                        const hasExistingFiles = document.querySelectorAll('.group\\/file:not([x-show])').length > 0;
                        if (!hasNewFiles && !hasExistingFiles) {
                            emptyRequired.push('Data Dukung (Minimal 1 Foto/Video/Dokumen)');
                        }
                    }

                    if (emptyRequired.length > 0) {
                        this.emptyFieldsList = emptyRequired;
                        this.$dispatch('open-modal', 'validation-warning-modal');
                        return;
                    }
                    this.$dispatch('open-modal', 'confirm-submission');
                },

                

                doSubmit() {
                    this.loading = true;
                    this.$dispatch('close');
                    this.$nextTick(() => {
                        const form = (this.$refs.mainForm || this.$refs.editForm);
                        if (form) form.submit();
                    });
                }
            }
        }</script>
</x-layouts.pengusul-desa>








