<x-layouts.pengusul>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.cagar-budaya-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Laporan Cagar Budaya</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.cagar-budaya-submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors">{{ $submission->name }}</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Ubah Data</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <!-- Decorative Bubbles -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <span class="px-2.5 py-1 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.15em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100 shadow-sm">
                                Mode Edit
                            </span>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-[0.2em]">ID: #{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight break-words max-w-2xl">
                            Ubah <span class="text-[#00B4D8]">Cagar Budaya</span>
                        </h2>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center gap-2 text-slate-500 font-bold text-[10px] sm:text-xs bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 uppercase tracking-widest italic">
                                <span>"{{ $submission->name }}"</span>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="flex items-center gap-4">
                    <a href="{{ route('pengusul.cagar-budaya-submissions.show', $submission) }}" class="inline-flex items-center justify-center px-8 py-4 sm:py-5 bg-slate-50 text-slate-400 rounded-2xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.2em] hover:bg-[#03045E] hover:text-white hover:-translate-x-1 transition-all duration-300 shadow-sm active:scale-95 gap-3">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Batal</span>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

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
            <h3 class="text-[#03045E] font-black text-xl mb-3 text-center tracking-tight">Memperbarui Laporan</h3>
            <p class="text-slate-500 text-sm font-medium text-center leading-relaxed">Mohon tunggu sebentar, kami sedang memperbarui data potensi cagar budaya Anda.</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 pb-20">
        
        <!-- Form Section -->
        <div class="lg:col-span-8 space-y-12">
            <div class="bg-white rounded-[2.5rem] sm:rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden group/form transition-all duration-700">
                <div class="p-8 sm:p-14">
                    <form action="{{ route('pengusul.cagar-budaya-submissions.update', $submission) }}" 
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


    {{-- Premium Alpine.js File Preview Modal (x-teleport to body, matches create form style) --}}
    <template x-teleport="body">
        <div class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6"
             x-show="showPreviewModal"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
            <div class="relative w-full max-w-6xl max-h-full bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 flex flex-col">
                <!-- Modal Header -->
                <div class="p-6 sm:p-8 flex items-center justify-between border-b border-white/5 bg-slate-900/50 backdrop-blur-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#00B4D8]">
                            <template x-if="previewFile?.isImage">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </template>
                            <template x-if="previewFile?.isVideo">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </template>
                        </div>
                        <div>
                            <h3 class="text-white font-black text-lg tracking-tight" x-text="previewFile?.name"></h3>
                            <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.2em]" x-text="formatSize(previewFile?.size || 0)"></p>
                        </div>
                    </div>
                    <button type="button" @click="closePreview()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/50 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all group">
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content Container -->
                <div class="w-full bg-black/20 flex items-center justify-center relative group/inner min-h-[300px] max-h-[75vh] overflow-hidden">
                    <template x-if="previewFile?.isImage">
                        <img :src="previewFile?.previewUrl" class="max-w-full max-h-[70vh] object-contain select-none">
                    </template>
                    <template x-if="previewFile?.isVideo">
                        <video :src="previewFile?.previewUrl" controls autoplay class="max-w-full max-h-[70vh]"></video>
                    </template>

                    <!-- Download Button (only for non-existing files) -->
                    <template x-if="previewFile && !previewFile.isExisting">
                        <a :href="previewFile?.previewUrl" x-bind:download="previewFile?.name" class="absolute bottom-8 right-8 px-6 py-3 bg-white text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all opacity-0 group-hover/inner:opacity-100 translate-y-4 group-hover/inner:translate-y-0 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Berkas
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </template>

    <script>
        function deleteExistingFile(url) {
            const form = document.getElementById('deleteFileForm');
            if (form) {
                form.action = url;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete-file' }));
            }
        }
    </script>


    
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
                showPreviewModal: false,
                previewFile: null,

                openPreview(item) {
                    this.previewFile = item;
                    this.showPreviewModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closePreview() {
                    this.showPreviewModal = false;
                    document.querySelectorAll('video').forEach(v => v.pause());
                    document.body.style.overflow = '';
                    setTimeout(() => { this.previewFile = null; }, 300);
                },

                formatSize(bytes) {
                    if (!bytes || bytes === 0) return '—';
                    const k = 1024;
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + ['Bytes', 'KB', 'MB', 'GB'][i];
                },

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

                    if (dt.items.length + {{ $submission->files->count() }} > 5) {
                        this.$dispatch('open-modal', 'max-file-warning');
                        return;
                    }

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
                    if (this.files.length > 0 || {{ $submission->files->count() }} > 0) filledRequired++;

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
</x-layouts.pengusul>








