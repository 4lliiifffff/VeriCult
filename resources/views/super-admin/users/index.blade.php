<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
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
                            Kelola Pengguna
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Kelola <span class="text-[#00B4D8]">Pengguna</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Pantau, verifikasi, dan perbarui seluruh data warisan budaya Nusantara.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto">
                    <a href="{{ route('super-admin.users.create-validator') }}" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10 transition-transform active:scale-95 group">
                        <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Validator
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
            deleteModalOpen: false, 
            notifyModalOpen: false, 
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
                    // Update URL without reloading
                    const cleanUrl = fetchUrl.replace(/([?&])_token=[^&]*(&|$)/, '$1').replace(/[?&]$/, '');
                    window.history.pushState({}, '', cleanUrl);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    this.loading = false;
                });
            },

            init() {
                // Intercept pagination clicks
                this.$refs.tableContainer.addEventListener('click', (e) => {
                    const link = e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        this.fetchUsers(link.href.split('?')[0] + '?' + link.href.split('?')[1]);
                    }
                });
            },
            
            openDeleteModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.deleteModalOpen = true;
            },
            openNotifyModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.notifyModalOpen = true;
            },
            openSuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.suspendModalOpen = true;
            },
            openUnsuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.unsuspendModalOpen = true;
            },
            openVerifyModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.verifyModalOpen = true;
            },
            openApproveModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.approveModalOpen = true;
            },
            openRejectModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.rejectModalOpen = true;
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white relative group">
        
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
        
        <!-- Filters Area -->
        <div class="p-5 sm:p-8 border-b border-slate-50 bg-white">
            <form x-ref="filterForm" action="{{ route('super-admin.users.index') }}" method="GET" @submit.prevent="fetchUsers()" class="flex flex-col lg:flex-row gap-6 auto-submit">
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            @input.debounce.300ms="$refs.filterForm.requestSubmit()"
                            placeholder="Cari berdasarkan nama atau email..." 
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
                            :options="['active' => 'Aktif', 'pending' => 'Menunggu Persetujuan', 'suspended' => 'Ditangguhkan']" 
                        />
                    </div>
                </div>
            </form>
        </div>

        <div x-ref="tableContainer">
            @include('super-admin.users._table')
        </div>


        <!-- ====== MODALS ====== -->
 
        <!-- Notification Modal -->
        <div x-show="notifyModalOpen" style="display: none;" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="notifyModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true"></div>
 
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
 
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <form :action="actionUrl" method="POST">
                        @csrf
                        <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 sm:mx-0 sm:h-12 sm:w-12">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left w-full">
                                    <h3 class="text-xl font-black text-[#03045E]" id="modal-title">
                                        Kirim Notifikasi
                                    </h3>
                                    <p class="text-xs text-slate-400 font-medium mt-1">Kepada <span x-text="targetUser?.name" class="font-black text-[#0077B6]"></span></p>
                                    
                                    <div class="mt-6 space-y-5">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Subjek Pesan</label>
                                            <input type="text" name="subject" required class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-12 font-medium" placeholder="Contoh: Pembaruan Akun">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Isi Notifikasi</label>
                                            <textarea name="message" rows="4" required class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 font-medium p-4" placeholder="Tulis pesan Anda di sini..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-blue-900/20">
                                Kirim Sekarang
                            </button>
                            <button type="button" @click="notifyModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 
        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="deleteModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true"></div>
 
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
 
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]" id="modal-title">Hapus Akun?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Apakah Anda yakin ingin menghapus <span x-text="targetUser?.name" class="font-black text-red-600"></span>? 
                            Seluruh data terkait akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-red-900/20">
                                Ya, Hapus Permanen
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- Suspend Modal -->
        <div x-show="suspendModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="suspendModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
 
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-amber-50 text-amber-600 mb-6 font-black text-2xl shadow-inner italic">!</div>
                        <h3 class="text-2xl font-black text-[#03045E]">Tangguhkan User?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Yakin ingin menangguhkan akses <span x-text="targetUser?.name" class="font-black text-amber-600"></span>? User tidak akan bisa login sampai akun diaktifkan kembali.
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 font-sans">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-amber-900/20">
                                Ya, Tangguhkan
                            </button>
                        </form>
                        <button type="button" @click="suspendModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
 
           <!-- Unsuspend Modal -->
        <div x-show="unsuspendModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="unsuspendModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
 
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-emerald-50 text-emerald-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]">Aktifkan User?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Apakah Anda yakin ingin mengaktifkan kembali akses untuk <span x-text="targetUser?.name" class="font-black text-emerald-600"></span>?
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-emerald-900/20">
                                Ya, Aktifkan
                            </button>
                        </form>
                        <button type="button" @click="unsuspendModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verify Modal -->
        <div x-show="verifyModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="verifyModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
 
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-sky-50 text-sky-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]">Verifikasi Manual?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Anda akan memverifikasi alamat email untuk <span x-text="targetUser?.name" class="font-black text-sky-600"></span> secara manual.
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-sky-900/20">
                                Verifikasi
                            </button>
                        </form>
                        <button type="button" @click="verifyModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Modal -->
        <div x-show="approveModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="approveModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-emerald-50 text-emerald-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]">Setujui Akses?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Anda akan menyetujui <span x-text="targetUser?.name" class="font-black text-emerald-600"></span> sebagai Pengusul Desa. Email dan akun akan diaktifkan secara bersamaan.
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-emerald-900/20">
                                Ya, Setujui
                            </button>
                        </form>
                        <button type="button" @click="approveModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div x-show="rejectModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="rejectModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <form :action="actionUrl" method="POST">
                        @csrf
                        <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                            <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-[#03045E]">Tolak Pengajuan?</h3>
                            <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                                Anda akan menolak dan menangguhkan akun <span x-text="targetUser?.name" class="font-black text-red-600"></span>.
                            </p>
                            <div class="mt-6">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alasan Penolakan (Wajib)</label>
                                <textarea name="rejection_reason" rows="3" required
                                    class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 sm:text-sm transition-all duration-300 font-medium p-4"
                                    placeholder="Jelaskan alasan penolakan..."></textarea>
                            </div>
                        </div>
                        <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-red-900/20">
                                Tolak & Suspend
                            </button>
                            <button type="button" @click="rejectModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.super-admin>
