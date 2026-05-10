<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Verifikasi Pengajuan</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.review-form', $submission) }}" class="hover:text-[#0077B6] transition-colors">Review</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Data Lapangan</span>
        </nav>

        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-6 sm:p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-4">
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words max-w-4xl">
                        Lengkapi <span class="text-[#00B4D8]">Data Kebudayaan</span>
                    </h2>
                    <p class="text-blue-100/80 text-sm font-bold">Lengkapi atribut data OPK untuk pengajuan: <span class="text-white">{{ $submission->name }}</span></p>
                </div>
                
                <div class="flex items-center gap-4 mt-4 md:mt-0">
                    <a href="{{ route('validator.submissions.review-form', $submission) }}" class="w-full md:w-auto justify-center bg-white text-[#03045E] px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-all shadow-xl shadow-blue-900/20 active:scale-95">
                        Kembali ke Form Verifikasi
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="submissionForm()">
        <div x-show="loading"
             x-transition
             class="fixed inset-0 bg-slate-900/75 flex items-center justify-center z-[100]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center">Menyimpan Data</h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Mohon tunggu...</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto space-y-10">
            <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="p-6 sm:p-14">
                    <div class="mb-10 p-6 bg-blue-50/50 rounded-2xl border border-blue-100">
                        <h3 class="text-sm font-black text-[#03045E] uppercase tracking-widest mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Validator
                        </h3>
                        <p class="text-xs text-slate-500 font-bold leading-relaxed">Form ini disediakan bagi Validator untuk melengkapi field opsional (pertanyaan mendalam) yang dikosongkan oleh Pengusul Desa. Setelah data tersimpan, Anda dapat kembali ke halaman Verifikasi Lapangan untuk memberikan keputusan final.</p>
                    </div>

                    <form action="{{ route('validator.submissions.update', $submission) }}" 
                          method="POST" 
                          x-ref="editForm" 
                          @submit.prevent="openConfirm()">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category" value="{{ $submission->category ?? $categoryName ?? '' }}">
                        <input type="hidden" name="address" value="{{ $submission->address }}">
                        
                        @include('pengusul-desa.submissions.partials.form', ['categoryFields' => $categoryFields, 'categoryName' => $submission->category, 'submission' => $submission, 'hideFiles' => true])

                        <div class="mt-16 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-8">
                            <button type="submit" 
                                    class="w-full sm:w-auto px-12 py-5 bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black rounded-[1.5rem] shadow-2xl shadow-blue-900/30 hover:shadow-blue-900/40 hover:-translate-y-1 transition-all duration-300 active:scale-95 group"
                                    :disabled="loading">
                                <div class="flex items-center justify-center gap-4">
                                    <span class="tracking-[0.2em] uppercase text-xs">Simpan Data Kebudayaan</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <x-modal name="confirm-update-submission" :show="false" focusable>
            <div class="p-10 sm:p-14 text-center">
                <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center text-[#0077B6] mx-auto mb-8 shadow-inner animate-bounce-slow">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Simpan Data?</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-10">Data akan diperbarui pada pengajuan ini.</p>

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
                    this.$dispatch('open-modal', 'confirm-update-submission');
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
</x-layouts.validator>








