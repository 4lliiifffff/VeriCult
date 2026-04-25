<x-layouts.admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Kelola Pengguna</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Tata Kelola Sistem
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Kelola <span class="text-[#00B4D8]">Pengguna</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Pantau status akses dan validasi pengguna dalam ekosistem VeriCult.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto">
                    <a href="{{ route('admin.user-approvals.index') }}" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10 transition-transform active:scale-95 group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Antrian Persetujuan
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
            suspendModalOpen: false,
            unsuspendModalOpen: false,
            verifyModalOpen: false,
            approveModalOpen: false,
            rejectModalOpen: false,
            targetUser: null, 
            actionUrl: '',
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
            
            openSuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.suspendModalOpen = true;
                this.$dispatch('open-modal', 'suspend-modal');
            },
            openUnsuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.unsuspendModalOpen = true;
                this.$dispatch('open-modal', 'unsuspend-modal');
            },
            openVerifyModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.verifyModalOpen = true;
                this.$dispatch('open-modal', 'verify-modal');
            },
            openApproveModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.approveModalOpen = true;
                this.$dispatch('open-modal', 'approve-modal');
            },
            openRejectModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.rejectModalOpen = true;
                this.$dispatch('open-modal', 'reject-modal');
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white relative group min-h-[500px]">
        
        <!-- Loading Overlay -->
        <div x-show="loading" class="absolute inset-0 z-40 bg-white/60 backdrop-blur-[2px] flex items-center justify-center rounded-[2.5rem]" style="display: none;">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-slate-100 border-t-[#0077B6] rounded-full animate-spin"></div>
                <span class="text-[10px] font-black text-[#03045E] uppercase tracking-widest animate-pulse">Memperbarui Data...</span>
            </div>
        </div>
        
        <!-- Filters Area -->
        <div class="p-5 sm:p-8 border-b border-slate-50 bg-white rounded-t-[2.5rem]">
            <form x-ref="filterForm" action="{{ route('admin.users.index') }}" method="GET" @submit.prevent="fetchUsers()" class="flex flex-col lg:flex-row gap-6 auto-submit">
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6]">
                            <svg class="h-5 w-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            @input.debounce.500ms="fetchUsers()"
                            placeholder="Cari pengguna berdasarkan nama atau email..." 
                            class="pl-12 block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-medium">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-48">
                        <x-dropdown-select 
                            name="role" 
                            id="role" 
                            placeholder="Semua Peran"
                            all-label="Semua Peran"
                            variant="light"
                            :selected="request('role')" 
                            :options="collect($roles)->mapWithKeys(fn($r) => [$r->name => ucfirst(str_replace('-', ' ', $r->name))])->toArray()" 
                        />
                    </div>
                    <div class="w-full sm:w-48">
                        <x-dropdown-select 
                            name="status" 
                            id="status" 
                            placeholder="Semua Status"
                            all-label="Semua Status"
                            variant="light"
                            :selected="request('status')" 
                            :options="['active' => 'Aktif', 'suspended' => 'Ditangguhkan']" 
                        />
                    </div>
                </div>
            </form>
        </div>

        <div x-ref="tableContainer">
            @include('admin.users._table')
        </div>

        <!-- ====== MODALS ====== -->

        <!-- Suspend Modal -->
        <x-modal name="suspend-modal" :show="false" focusable>
            <div x-show="suspendModalOpen" class="p-8 sm:p-12 text-center">
                <div class="mx-auto border-4 border-amber-400 bg-amber-50 h-20 w-20 rounded-3xl flex items-center justify-center text-amber-500 mb-6 font-black text-3xl shadow-inner italic">!</div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Tangguhkan User?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Akun <span x-text="targetUser?.name" class="font-black text-amber-600"></span> tidak akan bisa mengakses sistem sementara waktu.
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="suspendModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-amber-900/20 transition-all duration-300">Ya, Tangguhkan</button>
                    </form>
                </div>
            </div>
        </x-modal>

        <!-- Unsuspend Modal -->
        <x-modal name="unsuspend-modal" :show="false" focusable>
            <div x-show="unsuspendModalOpen" class="p-8 sm:p-12 text-center">
                <div class="mx-auto w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mb-6 shadow-inner italic font-black text-2xl">✓</div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Aktifkan Pengguna?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Anda akan memulihkan akses penuh untuk <span x-text="targetUser?.name" class="font-black text-emerald-600"></span>.
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="unsuspendModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-emerald-900/20 transition-all duration-300">Ya, Aktifkan</button>
                    </form>
                </div>
            </div>
        </x-modal>

        <!-- Verify Modal -->
        <x-modal name="verify-modal" :show="false" focusable>
            <div x-show="verifyModalOpen" class="p-8 sm:p-12 text-center">
                <div class="mx-auto w-20 h-20 bg-sky-50 rounded-3xl flex items-center justify-center text-sky-600 mb-6 shadow-inner">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Verifikasi Manual?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Tandai alamat email <span x-text="targetUser?.name" class="font-black text-sky-600"></span> sebagai terverifikasi sekarang.
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="verifyModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-sky-900/20 transition-all duration-300">Verifikasi</button>
                    </form>
                </div>
            </div>
        </x-modal>

        <!-- Approve Modal -->
        <x-modal name="approve-modal" :show="false" focusable>
            <div x-show="approveModalOpen" class="p-8 sm:p-12 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-3xl bg-emerald-50 text-emerald-600 mb-6 shadow-sm border border-emerald-100">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-[#03045E]">Setujui Akses?</h3>
                <p class="mt-3 text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Anda akan menyetujui <span x-text="targetUser?.name" class="font-black text-emerald-600"></span> sebagai Pengusul Desa. Akun ini akan langsung aktif.
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="approveModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-emerald-900/20 transition-all duration-300">Ya, Setujui</button>
                    </form>
                </div>
            </div>
        </x-modal>

        <!-- Reject Modal -->
        <x-modal name="reject-modal" :show="false" focusable>
            <form :action="actionUrl" method="POST" x-show="rejectModalOpen">
                @csrf
                <div class="p-8 sm:p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-3xl bg-red-50 text-red-600 mb-6 shadow-sm border border-red-100 italic font-black text-3xl">X</div>
                    <h3 class="text-2xl font-black text-[#03045E]">Tolak Pengajuan?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                        Tolak pengajuan dan hapus akun <span x-text="targetUser?.name" class="font-black text-red-600"></span> secara permanen.
                    </p>
                    <div class="mt-8 text-left">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alasan Penolakan (Wajib)</label>
                        <textarea name="rejection_reason" rows="3" required
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 sm:text-sm transition-all duration-300 font-medium p-5"
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 w-full mt-10">
                        <button type="button" @click="rejectModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                        <button type="submit" class="w-full px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all duration-300">Tolak & Hapus</button>
                    </div>
                </div>
            </form>
        </x-modal>

    </div>
</x-layouts.admin>
