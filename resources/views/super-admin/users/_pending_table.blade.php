<div class="overflow-x-auto overflow-y-hidden">
    <table class="w-full text-left border-collapse min-w-max responsive-table">
        <thead>
            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] bg-slate-50/50 border-b border-slate-100">
                <th class="px-8 py-6">Profil Pengusul</th>
                <th class="px-8 py-6 text-center">Status Email</th>
                <th class="px-8 py-6 text-center">Surat Pengajuan</th>
                <th class="px-8 py-6 text-center whitespace-nowrap">Terdaftar Sejak</th>
                <th class="px-8 py-6 text-right">Opsi Validasi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse ($pendingUsers as $user)
                <tr class="hover:bg-slate-50/30 transition-all duration-300 group/u">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-[#03045E] text-white flex items-center justify-center font-black text-sm shadow-xl shadow-blue-900/10 group-hover/u:scale-110 transition-transform duration-500 uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-black text-base text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate mb-0.5 tracking-tight leading-tight">{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-bold tracking-tight truncate uppercase">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if ($user->hasVerifiedEmail())
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-900/5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm shadow-amber-900/5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if ($user->pengusulDesaProfile?->surat_pengajuan_path)
                            <a href="{{ Storage::url($user->pengusulDesaProfile->surat_pengajuan_path) }}" target="_blank"
                                class="inline-flex items-center gap-2.5 px-4 py-2.5 bg-white text-[#0077B6] hover:bg-[#03045E] hover:text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all duration-300 border border-slate-100 shadow-sm hover:shadow-blue-900/20 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Buka PDF
                            </a>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-400 border border-slate-100">
                                Tidak Ada
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="font-black text-[11px] text-[#03045E] uppercase tracking-tighter">{{ $user->created_at->format('d M Y') }}</div>
                        <div class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $user->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-3">
                            {{-- Verify Email Button --}}
                            @if (!$user->hasVerifiedEmail())
                                <button type="button" @click="openActionModal('confirm-verify', '{{ route('super-admin.users.verify-email', $user) }}', '{{ addslashes($user->name) }}')"
                                    class="w-11 h-11 flex items-center justify-center rounded-2xl bg-blue-50 text-[#0077B6] hover:bg-[#0077B6] hover:text-white transition-all duration-300 shadow-sm border border-blue-100 active:scale-95 group/btn" title="Verifikasi Email Manual">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            @endif

                            {{-- Approve Button --}}
                            <button type="button" @click="openActionModal('confirm-approve', '{{ route('super-admin.pengusul-desa.approve', $user) }}', '{{ addslashes($user->name) }}')"
                                class="w-11 h-11 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100 active:scale-95 group/btn" title="Setujui Akses">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>

                            {{-- Reject Button --}}
                            <button type="button" @click="openActionModal('confirm-reject', '/super-admin/pengusul-desa/{{ $user->id }}/reject', '{{ addslashes($user->name) }}')"
                                class="w-11 h-11 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100 active:scale-95 group/btn" title="Tolak Akses">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            {{-- View User Link --}}
                            <a href="{{ route('super-admin.users.show', $user) }}" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100 active:scale-95 group/btn" title="Lihat Profil">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-32 text-center">
                        <div class="flex flex-col items-center justify-center space-y-6">
                            <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 border border-slate-100">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 tracking-[0.3em] uppercase mb-1">Antrian Bersih</p>
                                <p class="text-slate-300 text-xs font-bold uppercase tracking-widest leading-relaxed">Semua pengajuan telah diproses.<br>Kerja bagus!</p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if ($pendingUsers->hasPages())
    <div class="px-8 py-10 border-t border-slate-50 bg-slate-50/20">
        <div class="pagination-container">
            {{ $pendingUsers->links() }}
        </div>
    </div>
@endif
