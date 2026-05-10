<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Verifikasi Pengajuan</a>
            <svg class="w-3 h-3 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.review-form', $submission) }}" class="hover:text-[#0077B6] transition-colors">Review</a>
            <svg class="w-3 h-3 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Data Lapangan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group mb-0">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-indigo-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-[#00B4D8]/5 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5 sm:gap-8">
                <div class="flex items-start sm:items-center gap-4 sm:gap-6">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 shrink-0 rounded-2xl sm:rounded-[1.5rem] bg-gradient-to-br from-indigo-500 to-[#0077B6] flex items-center justify-center text-white shadow-xl shadow-indigo-500/25">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="space-y-1">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black tracking-widest uppercase bg-indigo-50 text-indigo-600 border border-indigo-100">Verifikasi Lapangan</span>
                        <h2 class="text-xl sm:text-3xl font-black text-[#03045E] tracking-tight leading-tight">Lengkapi <span class="text-[#0077B6]">Data Kebudayaan</span></h2>
                        <p class="text-slate-400 text-xs font-bold truncate max-w-xs sm:max-w-none">{{ $submission->name }}</p>
                    </div>
                </div>
                <a href="{{ route('validator.submissions.review-form', $submission) }}" class="shrink-0 flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-4 bg-slate-50 hover:bg-[#03045E] text-slate-500 hover:text-white border border-slate-100 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Verifikasi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pb-16" x-data="submissionForm()">
        <div x-show="loading"
             x-transition
             data-loading-overlay
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

        <div class="space-y-6 lg:space-y-8">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50/50 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-7 border border-indigo-100/70 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-10 h-10 shrink-0 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm border border-indigo-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-[#03045E] uppercase tracking-widest mb-1">Informasi Validator</p>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">Form ini untuk melengkapi field opsional yang dikosongkan oleh Pengusul Desa. Setelah tersimpan, kembali ke halaman Verifikasi Lapangan untuk keputusan final.</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden">
                <div class="px-5 py-5 sm:px-14 sm:py-7 border-b border-slate-50 bg-gradient-to-r from-slate-50/80 to-white flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="font-black text-base sm:text-xl text-[#03045E] tracking-tight">Form Data Kebudayaan</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $submission->category }}</p>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 border border-indigo-100">Verifikasi Lapangan</span>
                </div>
                <div class="p-5 sm:p-14">
                    <form action="{{ route('validator.submissions.update', $submission) }}" method="POST" id="edit-form" x-ref="editForm" @submit.prevent="openConfirm()">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category" value="{{ $submission->category ?? $categoryName ?? '' }}">
                        <input type="hidden" name="address" value="{{ $submission->address }}">
                        
                        @include('pengusul-desa.submissions.partials.form', ['categoryFields' => $categoryFields, 'categoryName' => $submission->category, 'submission' => $submission, 'hideFiles' => true, 'forceRequired' => true])

                        <div class="mt-12 pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                            <a href="{{ route('validator.submissions.review-form', $submission) }}" class="flex items-center justify-center gap-2 px-6 py-4 bg-slate-50 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-100 transition-all active:scale-95 border border-slate-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Batal
                            </a>
                            <button type="submit"
                                    class="flex items-center justify-center gap-3 px-8 sm:px-12 py-4 sm:py-5 bg-gradient-to-br from-[#03045E] via-[#023E8A] to-[#0077B6] text-white font-black rounded-2xl shadow-2xl shadow-blue-900/30 hover:shadow-blue-900/50 hover:-translate-y-1 transition-all duration-300 active:scale-95 text-[10px] uppercase tracking-widest"
                                    :disabled="loading">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Data Kebudayaan
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
                            onclick="doEditSubmit()"
                            class="px-8 py-5 rounded-2xl bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] transition-all active:scale-[0.98]">
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </x-modal>

        {{-- Validation Warning Modal (INSIDE x-data scope) --}}
        <x-modal name="validation-warning-modal" :show="false" focusable>
            <div class="p-10 sm:p-16 text-center">
                <div class="w-24 h-24 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-rose-900 mb-4 tracking-tight leading-tight">Data Belum Lengkap!</h2>
                <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-6">Terdapat data wajib yang belum diisi:</p>
                <div class="bg-rose-50/50 rounded-2xl p-6 text-left max-w-sm mx-auto mb-10 border border-rose-100">
                    <ul class="space-y-3">
                        <template x-for="field in emptyFieldsList" :key="field">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-rose-700 font-bold text-sm" x-text="field"></span>
                            </li>
                        </template>
                    </ul>
                </div>
                <button type="button" @click="$dispatch('close')"
                        class="w-full px-8 py-4 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase hover:bg-rose-700 transition-all active:scale-[0.98]">
                    Kembali ke Formulir
                </button>
            </div>
        </x-modal>
    </div>{{-- end x-data --}}

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
        // Global submit function — needed because x-modal teleports to <body>,
        // breaking Alpine's component scope. This function is always accessible.
        function doEditSubmit() {
            // Show loading overlay
            const loadingEl = document.querySelector('[data-loading-overlay]');
            if (loadingEl) loadingEl.style.display = 'flex';

            // Close any open modal
            document.dispatchEvent(new CustomEvent('close'));
            window.dispatchEvent(new CustomEvent('close'));

            // Submit the form
            setTimeout(() => {
                const form = document.getElementById('edit-form');
                if (form) form.submit();
            }, 100);
        }

        function submissionForm() {
            return {
                loading: false,
                files: [],
                dragover: false,
                emptyFieldsList: [],
                submissionName: @js(old('name', $submission->name ?? '')),

                openConfirm() {
                    let emptyRequired = [];

                    // Scan all required field wrappers
                    document.querySelectorAll('[data-required="true"]').forEach(wrapper => {
                        // Check if this field wrapper is actually visible
                        let isHidden = false;
                        let el = wrapper;
                        while (el && el !== document.body) {
                            const s = window.getComputedStyle(el);
                            if (s.display === 'none' || s.visibility === 'hidden') {
                                isHidden = true; break;
                            }
                            el = el.parentElement;
                        }
                        if (isHidden) return;

                        // Get label text (strip asterisk)
                        const label = wrapper.querySelector('label');
                        const labelText = label
                            ? label.textContent.trim().replace(/\s*\*\s*$/, '').trim()
                            : 'Field wajib';

                        // Check all named inputs in this wrapper
                        let hasValue = false;
                        wrapper.querySelectorAll('input, textarea, select')
                            .forEach(input => {
                                if (input.disabled) return;
                                
                                if (input.type === 'radio' || input.type === 'checkbox') {
                                    if (input.checked) hasValue = true;
                                } else if (input.value && input.value.trim() !== '') {
                                    hasValue = true;
                                }
                            });

                        if (!hasValue && labelText) {
                            emptyRequired.push(labelText);
                        }
                    });

                    if (emptyRequired.length > 0) {
                        this.emptyFieldsList = emptyRequired;
                        this.$dispatch('open-modal', 'validation-warning-modal');
                        return;
                    }

                    this.$dispatch('open-modal', 'confirm-update-submission');
                },

                doSubmit() {
                    doEditSubmit(); // delegate to global function
                }
            }
        }
    </script>
</x-layouts.validator>








