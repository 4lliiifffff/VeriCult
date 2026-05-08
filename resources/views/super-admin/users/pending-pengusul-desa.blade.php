<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Antrian Persetujuan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-amber-500 text-white shadow-lg shadow-amber-900/20 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            Antrian Validasi
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Pengusul Desa</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Persetujuan <span class="text-[#0077B6]">Tertunda</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Validasi akses bagi pendaftar Pengusul Desa sebelum masuk ekosistem VeriCult.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-[2rem] border border-slate-100 shadow-inner w-full md:w-auto self-start md:self-auto">
                    <a href="{{ route('super-admin.users.index') }}" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/5 transition-transform active:scale-95 group border border-slate-100">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-8 p-5 rounded-[2rem] bg-emerald-50 border border-emerald-100 flex items-start gap-5 shadow-sm animate-fade-in-up">
            <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="pt-1">
                <p class="text-xs font-black text-emerald-800 uppercase tracking-[0.2em] mb-1">Berhasil</p>
                <p class="text-sm text-emerald-600/80 font-bold leading-relaxed">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div x-data="{ 
            actionUrl: '',
            targetName: '',
            loading: false,
            
            fetchUsers(url = null) {
                this.loading = true;
                const form = this.$refs.filterForm;
                const formData = new FormData(form);
                const query = new URLSearchParams(formData).toString();
                const currentAction = url || form.action;
                const fetchUrl = currentAction + (currentAction.includes('?') ? '&' : '?') + query;

                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    this.$refs.tableContainer.innerHTML = html;
                    const cleanUrl = fetchUrl.replace(/([?&])_token=[^&]*(&|$)/, '$1').replace(/[?&]$/, '');
                    window.history.pushState({}, '', cleanUrl);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    this.loading = false;
                });
            },

            init() {
                this.$refs.tableContainer.addEventListener('click', (e) => {
                    const link = e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        this.fetchUsers(link.href);
                    }
                });
            },
            
            openActionModal(modalName, url, name) {
                this.actionUrl = url;
                this.targetName = name;
                $dispatch('open-modal', modalName);
            }
        }">
        
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group mb-20">
            <!-- Loading Overlay -->
            <div x-show="loading" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 z-40 bg-white/60 backdrop-blur-[2px] flex items-center justify-center" style="display: none;">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-12 h-12 border-4 border-slate-100 border-t-[#0077B6] rounded-full animate-spin"></div>
                    <span class="text-[10px] font-black text-[#03045E] uppercase tracking-widest animate-pulse">Memperbarui Data...</span>
                </div>
            </div>

            <!-- Search Area -->
            <div class="p-5 sm:p-8 border-b border-slate-50 bg-white">
                <form x-ref="filterForm" action="{{ route('super-admin.users.pengusul-desa') }}" method="GET" @submit.prevent="fetchUsers()" class="flex flex-col lg:flex-row gap-6">
                    <div class="flex-1">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                @input.debounce.300ms="$refs.filterForm.requestSubmit()"
                                placeholder="Cari pengusul berdasarkan nama atau email..." 
                                class="pl-12 block w-full rounded-2xl border-slate-100 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] placeholder:text-slate-300">
                        </div>
                    </div>
                </form>
            </div>

            <div x-ref="tableContainer">
                @include('super-admin.users._pending_table')
            </div>
        </div>

        {{-- Modals Section --}}
        {{-- Reject Modal --}}
        <x-modal name="confirm-reject" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white p-8 sm:p-12">
                    <div class="w-20 h-20 rounded-[2rem] bg-red-50 text-red-600 flex items-center justify-center mb-8 shadow-xl shadow-red-900/10 border border-red-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Tolak Pengajuan?</h3>
                    <p class="text-slate-500 font-bold text-sm leading-relaxed mb-8 uppercase tracking-tight">
                        Anda akan menolak akses untuk <span x-text="targetName" class="text-red-600 underline"></span>. Pengguna akan disuspend.
                    </p>
                    
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Alasan Penolakan</label>
                        <textarea name="rejection_reason" rows="4"
                            class="block w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-300 font-bold text-sm p-5 shadow-inner"
                            placeholder="Tuliskan alasan penolakan di sini..." required></textarea>
                    </div>
                </div>
                <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="flex-1 px-8 py-5 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-red-900/40 active:scale-95">
                        Konfirmasi Tolak
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-reject')" class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Verify Modal --}}
        <x-modal name="confirm-verify" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white p-8 sm:p-12">
                    <div class="w-20 h-20 rounded-[2rem] bg-blue-50 text-[#0077B6] flex items-center justify-center mb-8 shadow-xl shadow-blue-900/10 border border-blue-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Verifikasi Manual?</h3>
                    <p class="text-slate-500 font-bold text-sm leading-relaxed mb-0 uppercase tracking-tight">
                        Verifikasi email untuk <span x-text="targetName" class="text-[#0077B6] underline"></span> secara manual.
                    </p>
                </div>
                <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="flex-1 px-8 py-5 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-blue-900/40 active:scale-95">
                        Ya, Verifikasi
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-verify')" class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Approve Modal --}}
        <x-modal name="confirm-approve" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white p-8 sm:p-12">
                    <div class="w-20 h-20 rounded-[2rem] bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 shadow-xl shadow-emerald-900/10 border border-emerald-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Setujui Akses?</h3>
                    <p class="text-slate-500 font-bold text-sm leading-relaxed mb-0 uppercase tracking-tight">
                        Berikan akses penuh sebagai Pengusul Desa untuk <span x-text="targetName" class="text-emerald-600 underline"></span>.
                    </p>
                </div>
                <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="flex-1 px-8 py-5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-emerald-900/40 active:scale-95">
                        Konfirmasi Setuju
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-approve')" class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.super-admin>
