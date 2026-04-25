<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse min-w-max">
        <thead>
            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 sm:px-8 py-4 sm:py-5">Profil Pengguna</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Peran</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status Akses</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Tanggal Gabung</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Terakhir Aktif</th>
                <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi Tata Kelola</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse ($users as $user)
                <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                    <td class="px-6 sm:px-8 py-4 sm:py-5">
                        <div class="flex items-center">
                            @php
                                $bgColor = 'bg-slate-100 text-slate-400';
                                if($user->hasRole('validator')) $bgColor = 'bg-indigo-100 text-indigo-600';
                                if($user->hasRole('pengusul')) $bgColor = 'bg-sky-100 text-sky-600';
                                if($user->hasRole('pengusul-desa')) $bgColor = 'bg-amber-100 text-amber-600';
                            @endphp
                            <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-[12px] sm:rounded-[14px] {{ $bgColor }} flex items-center justify-center font-black text-[10px] sm:text-sm shadow-sm group-hover/u:scale-110 transition-transform duration-300">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $user->name }}</div>
                                <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                        <div class="flex flex-wrap justify-center gap-1.5 min-w-[120px]">
                            @forelse($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border shadow-sm
                                    {{ $role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                    ($role->name == 'pengusul' ? 'bg-sky-50 text-sky-700 border-sky-100' : 
                                    'bg-amber-50 text-amber-700 border-amber-100') }}">
                                    {{ str_replace('-', ' ', $role->name) }}
                                </span>
                            @empty
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-black">
                        <div class="flex flex-col items-center gap-1.5">
                            @if ($user->is_suspended)
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100 shadow-sm">
                                    Ditangguhkan
                                </span>
                            @elseif(!$user->hasVerifiedEmail())
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">
                                    Email Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                    Aktif
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 tabular-nums">{{ $user->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-bold text-xs text-slate-400 uppercase tracking-tighter whitespace-nowrap">
                        @if($user->last_seen_at)
                            {{ $user->last_seen_at->diffForHumans() }}
                        @else
                            <span class="opacity-50 italic text-[10px]">Belum Pernah</span>
                        @endif
                    </td>
                    <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Approve/Reject for Pending Village Users --}}
                            @if($user->hasRole('pengusul-desa') && !$user->is_approved_by_admin)
                                <button type="button" @click="openApproveModal({{ json_encode($user) }}, '{{ route('admin.user-approvals.approve', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Setujui Akses">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button type="button" @click="openRejectModal({{ json_encode($user) }}, '{{ route('admin.user-approvals.reject', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Tolak Pengajuan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            @endif

                            {{-- Show Detail Button --}}
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-[#03045E] hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100" title="Lihat Detail Profil">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>

                            {{-- Verify Email Button --}}
                            @if (!$user->hasVerifiedEmail())
                                <button type="button" @click="openVerifyModal({{ json_encode($user) }}, '{{ route('admin.users.verify-email', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all duration-300 shadow-sm border border-sky-100" title="Verifikasi Email Manual">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            @endif

                            {{-- Suspend/Unsuspend Buttons --}}
                            @if ($user->is_suspended)
                                <button type="button" @click="openUnsuspendModal({{ json_encode($user) }}, '{{ route('admin.users.unsuspend', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Aktifkan User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            @else
                                <button type="button" @click="openSuspendModal({{ json_encode($user) }}, '{{ route('admin.users.suspend', $user) }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm border border-rose-100" title="Tangguhkan User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-8 py-24 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Pengguna Tidak Ditemukan</p>
                                <p class="text-slate-300 text-[10px] mt-1 uppercase tracking-widest">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($users->hasPages())
    <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30 pagination-container">
        {{ $users->links() }}
    </div>
@endif
