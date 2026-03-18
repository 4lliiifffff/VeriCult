<!-- Table Area -->
<div class="overflow-x-auto overflow-y-visible rounded-b-[2.5rem]">
    <table class="w-full text-left border-collapse min-w-max">
        <thead>
            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 sm:px-8 py-4 sm:py-5">Profil User</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5">Peran</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status Akun</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Tanggal Gabung</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($users as $user)
            <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                <td class="px-6 sm:px-8 py-4 sm:py-5">
                    <div class="flex items-center">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-[12px] sm:rounded-[14px] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-[10px] sm:text-sm shadow-lg shadow-blue-900/10 group-hover/u:scale-110 transition-transform duration-300">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                        <div class="ml-3 sm:ml-4 min-w-0">
                            <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $user->name }}</div>
                            <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 sm:px-8 py-4 sm:py-5">
                    <div class="flex flex-wrap gap-1.5 min-w-[120px]">
                        @forelse($user->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border shadow-sm
                                {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                'bg-sky-50 text-sky-700 border-sky-100') }}">
                                {{ str_replace('-', ' ', $role->name) }}
                            </span>
                        @empty
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                        @endforelse
                    </div>
                </td>
                <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                    @if($user->is_suspended)
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100 shadow-sm">Ditangguhkan</span>
                    @elseif(is_null($user->email_verified_at))
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">Blm. Terverifikasi</span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">Aktif</span>
                    @endif
                </td>
                <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 tabular-nums">{{ $user->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        @if($user->id !== 1 && $user->id !== auth()->id())
                            @if($user->hasRole('pengusul-desa') && !$user->is_approved_by_admin)
                                <button @click="openApproveModal({{ json_encode($user) }}, '/super-admin/pengusul-desa/{{ $user->id }}/approve')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Setujui Akses">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button @click="openRejectModal({{ json_encode($user) }}, '/super-admin/pengusul-desa/{{ $user->id }}/reject')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Tolak & Suspend">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            @endif

                            {{-- Notify Button --}}
                            <button @click="openNotifyModal({{ json_encode($user) }}, '{{ route('super-admin.users.notify', $user) }}')" 
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm border border-indigo-100" title="Kirim Notifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </button>
 
                            {{-- Verify Button --}}
                            @if(!$user->hasVerifiedEmail())
                                <button @click="openVerifyModal({{ json_encode($user) }}, '{{ route('super-admin.users.verify-email', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all duration-300 shadow-sm border border-sky-100" title="Verifikasi Email Manual">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
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

                        <a href="{{ route('super-admin.users.show', $user) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500 hover:bg-[#0077B6] hover:text-white transition-all duration-300 shadow-sm border border-blue-100" title="Lihat Profil">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>

                        <a href="{{ route('super-admin.users.edit', $user) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100" title="Edit Profil">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>

                        @if($user->id !== auth()->id() && $user->id !== 1)
                            <button @click="openDeleteModal({{ json_encode($user) }}, '{{ route('super-admin.users.destroy', $user) }}')" 
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Hapus User Permenant">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
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
    <div class="pagination-container">
        {{ $users->links() }}
    </div>
</div>
@endif
