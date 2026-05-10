<x-layouts.pengusul>
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
                <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul.submissions.create') }}" class="hover:text-[#0077B6] transition-colors">Pilih Jenis</a>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">Cagar Budaya</span>
            </nav>

            <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 group">
                <div class="absolute inset-0 overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] pointer-events-none">
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
                </div>
                
                <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                                Potensi Cagar Budaya
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
                        <a href="{{ route('pengusul.submissions.create') }}" class="w-full sm:w-auto bg-[#03045E] text-white px-8 py-4 sm:py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 group/print">
                            <svg class="w-4 h-4 group-hover/btn:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Ganti Jenis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 pb-20">
        <div class="lg:col-span-8 space-y-12">
            <div class="bg-white rounded-[2.5rem] sm:rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden group/form transition-all duration-700">
                <div class="p-8 sm:p-14">
                    <form action="{{ route('pengusul.cagar-budaya-submissions.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        x-ref="mainForm" 
                        @submit.prevent="openConfirm()">
                        @csrf
                        <input type="hidden" name="category" value="Cagar Budaya">
                        <input type="hidden" name="address" value="-">
                        
                        @php $submission = new \stdClass; $submission->name = ''; $submission->address = ''; $submission->description = ''; $submission->category_data = old('category_data', []); $submission->category = 'Cagar Budaya'; @endphp
                        @include('pengusul.submissions.partials.form', ['categoryFields' => $categoryFields, 'categoryName' => 'Cagar Budaya', 'submission' => $submission])

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
                                    <span>Simpan Draft Laporan</span>
                                    <svg class="w-5 h-5 group-hover/submit:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 relative mt-8 lg:mt-0">
            <div class="space-y-8 sticky top-8">
                <div class="bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group/status transition-all duration-700 hover:shadow-blue-900/60">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover/status:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl flex items-center justify-center border border-white/20 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-black tracking-tight text-2xl">Status Draft</h3>
                                <p class="text-blue-100/50 text-[10px] font-black uppercase tracking-widest">Cagar Budaya</p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-submission" :show="false" focusable>
        <div class="p-10 sm:p-16 text-center">
            <div class="w-28 h-28 bg-blue-50 rounded-[2.5rem] flex items-center justify-center text-[#0077B6] mx-auto mb-10 shadow-inner group/icon relative overflow-hidden">
                <svg class="w-14 h-14 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-black text-[#03045E] mb-4 tracking-tight leading-tight">Simpan Draft?</h2>
            <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-12">Data pengajuan Cagar Budaya Anda akan disimpan sebagai draft.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" @click="$dispatch('close')" class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">Kembali</button>
                <button type="button" @click="doSubmit()" class="px-8 py-5 rounded-2xl bg-gradient-to-r from-[#03045E] to-[#0077B6] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-xl hover:shadow-2xl transition-all active:scale-[0.98]">Ya, Simpan</button>
            </div>
        </div>
    </x-modal>

    <!-- Validation Warning Modal -->
    <x-modal name="validation-warning-modal" :show="false" focusable>
        <div class="p-10 sm:p-16 text-center">
            <div class="w-28 h-28 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner group/warn">
                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Data Belum Lengkap!</h2>
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
            <button type="button" @click="$dispatch('close')" class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-xl hover:bg-rose-700 transition-all active:scale-[0.98]">KEMBALI KE FORMULIR</button>
        </div>
    </x-modal>

    <!-- Max File Warning Modal -->
    <x-modal name="max-file-warning" :show="false" focusable>
        <div class="p-10 sm:p-16 text-center">
            <div class="w-28 h-28 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-10 shadow-inner">
                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="text-4xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Batas Maksimal</h2>
            <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-12">Maksimal 5 berkas pendukung saja.</p>
            <button type="button" @click="$dispatch('close')" class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-xl hover:bg-rose-700 transition-all active:scale-[0.98]">SAYA MENGERTI</button>
        </div>
    </x-modal>

    <script>
        function submissionForm() {
            return {
                loading: false,
                files: [],
                dragover: false,
                emptyFieldsList: [],
                progress: 0,
                
                init() {
                    this.$nextTick(() => { this.recalcProgress(); });
                    const form = this.$refs.mainForm;
                    if (form) {
                        form.addEventListener('input', () => this.recalcProgress());
                        form.addEventListener('change', () => this.recalcProgress());
                    }
                    this.$watch('files', () => this.$nextTick(() => this.recalcProgress()));
                },

                handleFileSelect(e) { this.addFiles(Array.from(e.target.files)); },
                handleDrop(e) { this.addFiles(Array.from(e.dataTransfer.files)); },

                addFiles(newFiles) {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f));
                    newFiles.forEach(f => {
                        if (!this.files.some(existing => existing.name === f.name && existing.size === f.size)) dt.items.add(f);
                    });
                    if (dt.items.length > 5) {
                        this.$dispatch('open-modal', 'max-file-warning');
                        const limitedDt = new DataTransfer();
                        for (let i = 0; i < 5; i++) limitedDt.items.add(dt.files[i]);
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

                recalcProgress() { this.progress = this.calculateProgress(); },

                calculateProgress() {
                    let total = 0, filled = 0;
                    const form = (this.$refs.mainForm || this.$refs.editForm);
                    if (!form) return 0;
                    form.querySelectorAll('[data-category-field]').forEach(el => {
                        if (!this.isVisible(el)) return;
                        if (el.type === 'hidden' && (el.name === 'category' || el.name === 'address')) return;
                        if (el.type === 'radio' || el.type === 'checkbox') {
                            if (el.dataset.counted) return;
                            total++;
                            const checked = form.querySelector(`input[name="${el.name}"]:checked`);
                            if (checked) filled++;
                            el.dataset.counted = "true";
                        } else {
                            total++;
                            if (el.value && el.value.trim() !== '') filled++;
                        }
                    });
                    form.querySelectorAll('[data-counted]').forEach(el => delete el.dataset.counted);
                    total++;
                    if (this.files.length > 0) filled++;
                    return total === 0 ? 0 : Math.min(100, Math.round((filled / total) * 100));
                },

                isVisible(el) {
                    if (!el) return false;
                    let current = el;
                    while (current && current !== document.body) {
                        const style = window.getComputedStyle(current);
                        if (style.display === 'none' || current.hasAttribute('x-cloak')) return false;
                        current = current.parentElement;
                    }
                    return true;
                },

                openConfirm() {
                    let emptyRequired = [];
                    const nameEl = document.getElementById('name');
                    if (nameEl && (!nameEl.value || nameEl.value.trim() === '')) emptyRequired.push('Identitas Umum (Nama Objek / Kebudayaan)');
                    const filesInput = document.getElementById('files');
                    if (filesInput) {
                        const hasFiles = (filesInput.files && filesInput.files.length > 0) || (this.files && this.files.length > 0);
                        if (!hasFiles) emptyRequired.push('Data Dukung (Minimal 1 Foto/Video/Dokumen)');
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
                    this.$nextTick(() => { this.$refs.mainForm.submit(); });
                }
            }
        }
    </script>
</div>
</x-layouts.pengusul>
