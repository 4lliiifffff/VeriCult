<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
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

    <div x-data="{ 
            actionUrl: '',
            targetName: '',
            
            openActionModal(modalName, url, name) {
                this.actionUrl = url;
                this.targetName = name;
                $dispatch('open-modal', modalName);
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Profil Pengusul</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status Email</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Terdaftar Sejak</th>
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
                                @if ($user->hasVerifiedEmail())
                                    <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full font-black uppercase tracking-widest text-[9px]">Terverifikasi</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-600 rounded-full font-black uppercase tracking-widest text-[9px]">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-bold text-xs text-slate-400 whitespace-nowrap">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Approve Button --}}
                                    <button type="button" @click="openActionModal('confirm-approve', '{{ route('admin.user-approvals.approve', $user) }}', '{{ addslashes($user->name) }}')"
                                        class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                                        Setujui
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
                {{ $pendingUsers->links() }}
            </div>
        @endif

        {{-- Approve Modal --}}
        <x-modal name="confirm-approve" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                    <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-emerald-50 text-emerald-600 mb-6 font-black text-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E]">Setujui Akses?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                        Anda akan menyetujui <strong x-text="targetName" class="text-emerald-600"></strong> sebagai Pengusul Desa terdaftar.
                    </p>
                </div>
                <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                        Ya, Setujui
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-approve')" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.admin>
