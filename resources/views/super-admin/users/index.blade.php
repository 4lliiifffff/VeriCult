<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Kelola Pengguna</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="font-black text-3xl text-[#03045E] leading-tight tracking-tight">
                    Kelola <span class="text-[#0077B6]">Pengguna</span>
                </h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Administrasi seluruh entitas user, peran, dan status validasi sistem.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.users.create-validator') }}" class="inline-flex items-center px-6 py-3 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-blue-900/20 group">
                    <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Tambah Validator') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
            deleteModalOpen: false, 
            notifyModalOpen: false, 
            suspendModalOpen: false,
            unsuspendModalOpen: false,
            targetUser: null, 
            actionUrl: '',
            
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
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
        
        <!-- Filters Area -->
        <div class="p-8 border-b border-slate-50 bg-white">
            <form action="{{ route('super-admin.users.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau email..." 
                            class="pl-12 block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-medium">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-48">
                        <select name="role" onchange="this.form.submit()" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E]">
                            <option value="">Semua Peran</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="status" onchange="this.form.submit()" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E]">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5">Profil User</th>
                        <th class="px-8 py-5">Peran</th>
                        <th class="px-8 py-5 text-center">Status Akun</th>
                        <th class="px-8 py-5 text-center">Tanggal Gabung</th>
                        <th class="px-8 py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="h-11 w-11 rounded-[14px] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/10 group-hover/u:scale-110 transition-transform duration-300">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="ml-4 min-w-0">
                                    <div class="font-bold text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium truncate">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border
                                        {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                            ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                            'bg-sky-50 text-sky-700 border-sky-100') }}">
                                        {{ str_replace('-', ' ', $role->name) }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($user->is_suspended)
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100">
                                    Suspended
                                </span>
                            @elseif(is_null($user->email_verified_at))
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                    Unverified
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    Active
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-center font-bold text-xs text-slate-400 whitespace-nowrap uppercase tracking-tighter">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-8 py-5 text-right">
                           <div class="flex items-center justify-end gap-2">
                                @if($user->id !== 1)
                                    <div class="flex items-center gap-2">
                                        {{-- Actions for non-super-admins --}}
                                        @if(!$user->hasRole('super-admin'))
                                            
                                            {{-- Notify Button --}}
                                            <button @click="openNotifyModal({{ json_encode($user) }}, '{{ route('super-admin.users.notify', $user) }}')" 
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm border border-indigo-100" title="Kirim Notifikasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                            </button>
 
                                            {{-- Verify Button --}}
                                            @if(!$user->hasVerifiedEmail())
                                                <form action="{{ route('super-admin.users.verify-email', $user) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi email pengguna ini secara manual?');">
                                                    @csrf
                                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all duration-300 shadow-sm border border-sky-100" title="Verifikasi Email Manual">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
 
                                            @if($user->is_suspended)
                                                <button @click="openUnsuspendModal({{ json_encode($user) }}, '{{ route('super-admin.users.unsuspend', $user) }}')"
                                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Aktifkan User">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            @else
                                                <button @click="openSuspendModal({{ json_encode($user) }}, '{{ route('super-admin.users.suspend', $user) }}')"
                                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition-all duration-300 shadow-sm border border-amber-100" title="Tangguhkan User">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </button>
                                            @endif
                                        @endif
 
                                        <a href="{{ route('super-admin.users.edit', $user) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100" title="Edit Profil">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
 
                                        @if($user->id !== auth()->id())
                                            <button @click="openDeleteModal({{ json_encode($user) }}, '{{ route('super-admin.users.destroy', $user) }}')" 
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Hapus User Permenant">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest flex items-center gap-2 justify-end">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Locked Root
                                    </span>
                                @endif
                           </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Pengguna tidak ditemukan.</p>
                                    <p class="text-slate-300 text-[10px] mt-1 uppercase tracking-widest">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Area -->
        @if($users->hasPages())
        <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
            {{ $users->links() }}
        </div>
        @endif

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
                <div @click="notifyModalOpen = false" class="fixed inset-0 bg-[#03045E]/40 backdrop-blur-md transition-opacity" aria-hidden="true"></div>
 
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
                <div @click="deleteModalOpen = false" class="fixed inset-0 bg-red-900/20 backdrop-blur-md transition-opacity" aria-hidden="true"></div>
 
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
                <div @click="suspendModalOpen = false" class="fixed inset-0 bg-amber-900/20 backdrop-blur-md transition-opacity"></div>
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
                <div @click="unsuspendModalOpen = false" class="fixed inset-0 bg-emerald-900/20 backdrop-blur-md transition-opacity"></div>
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

    </div>
</x-layouts.super-admin>
