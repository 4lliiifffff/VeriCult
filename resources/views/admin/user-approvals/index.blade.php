<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Persetujuan Akun</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            Antrian Validasi
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Persetujuan <span class="text-[#00B4D8]">Akun</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Validasi akses bagi pendaftar Pengusul Desa sebelum masuk ekosistem.</p>
                </div>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-start gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-sm font-black text-emerald-800 uppercase tracking-wider mb-0.5">Berhasil</p>
                <p class="text-xs text-emerald-600 font-bold leading-relaxed">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div x-data="{ 
            actionUrl: '',
            targetName: '',
            
            openApproveModal(user, url) {
                this.targetName = user.name;
                this.actionUrl = url;
                $dispatch('open-modal', 'approve-modal');
            },
            openRejectModal(user, url) {
                this.targetName = user.name;
                this.actionUrl = url;
                $dispatch('open-modal', 'reject-modal');
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-max">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Profil Pengusul</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Peran</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status Akses</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Berkas</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Terdaftar</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pendingUsers as $user)
                        <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-[12px] sm:rounded-[14px] bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-black text-[10px] sm:text-sm shadow-lg shadow-blue-900/10 group-hover/u:scale-110 transition-transform duration-300">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="ml-3 sm:ml-4 min-w-0">
                                        <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $user->name }}</div>
                                        <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center text-xs">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-700 border border-amber-100 shadow-sm">
                                    Pengusul Desa
                                </span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-black">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">
                                    Pending Approval
                                </span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                @if ($user->pengusulDesaProfile?->surat_pengajuan_path)
                                    <a href="{{ Storage::url($user->pengusulDesaProfile->surat_pengajuan_path) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-[#0077B6] hover:bg-[#0077B6] hover:text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all duration-300 border border-blue-100 hover:border-transparent group/btn">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h.01M12 12h.01M15 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        Surat
                                    </a>
                                @else
                                    <span class="text-[9px] font-black text-slate-300 uppercase italic">Kosong</span>
                                @endif
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 tabular-nums">{{ $user->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Approve Button --}}
                                    <button type="button" @click="openApproveModal({{ json_encode($user) }}, '{{ route('admin.user-approvals.approve', $user) }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Setujui Akses">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    
                                    {{-- Reject Button --}}
                                    <button type="button" @click="openRejectModal({{ json_encode($user) }}, '{{ route('admin.user-approvals.reject', $user) }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Tolak Pengajuan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>

                                    {{-- Detail Profil --}}
                                    <a href="{{ route('admin.users.show', $user) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-[#03045E] hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100" title="Lihat Profil Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
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
                                    <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Tidak ada antrean persetujuan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendingUsers->hasPages())
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30 pagination-container">
                {{ $pendingUsers->links() }}
            </div>
        @endif

        {{-- Approve Modal --}}
        <x-modal name="approve-modal" focusable maxWidth="md">
            <div class="p-8 sm:p-12 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-3xl bg-emerald-50 text-emerald-600 mb-6 shadow-sm border border-emerald-100">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-[#03045E]">Setujui Akses?</h3>
                <p class="mt-3 text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Anda akan menyetujui <span x-text="targetName" class="font-black text-emerald-600"></span> sebagai Pengusul Desa.
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="$dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-emerald-900/20 transition-all duration-300">Ya, Setujui</button>
                    </form>
                </div>
            </div>
        </x-modal>

        {{-- Reject Modal --}}
        <x-modal name="reject-modal" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="p-8 sm:p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-3xl bg-red-50 text-red-600 mb-6 shadow-sm border border-red-100 font-black text-3xl italic">X</div>
                    <h3 class="text-2xl font-black text-[#03045E]">Tolak Pengajuan?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                        Tolak pengajuan dan <strong class="text-red-600">hapus akun</strong> <span x-text="targetName" class="font-black text-red-600"></span> secara permanen.
                    </p>
                    
                    <div class="mt-8 text-left">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alasan Penolakan (Wajib)</label>
                        <textarea name="rejection_reason" rows="4" required
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 sm:text-sm transition-all duration-300 font-medium p-5"
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 w-full mt-10">
                        <button type="button" @click="$dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                        <button type="submit" class="w-full px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all duration-300">Tolak & Hapus</button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.admin>
