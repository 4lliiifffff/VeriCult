<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Persetujuan Tertunda</span>
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
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Persetujuan <span class="text-[#00B4D8]">Tertunda</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Validasi akses bagi pendaftar Pengusul Desa sebelum masuk ekosistem.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto">
                    <a href="{{ route('super-admin.users.index') }}" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10 transition-transform active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-start gap-4 shadow-sm animate-fade-in-up">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-sm font-black text-emerald-800 uppercase tracking-wider mb-0.5">Berhasil</p>
                <p class="text-xs text-emerald-600 font-bold leading-relaxed">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-100 flex items-start gap-4 shadow-sm animate-fade-in-up">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-black text-blue-800 uppercase tracking-wider mb-0.5">Informasi</p>
                <p class="text-xs text-blue-600 font-bold leading-relaxed">{{ session('info') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-start gap-4 shadow-sm animate-fade-in-up">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-red-500 shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div>
                <p class="text-sm font-black text-red-800 uppercase tracking-wider mb-0.5">Terjadi Kesalahan</p>
                <ul class="text-xs text-red-600 font-bold leading-relaxed list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

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
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pendingUsers as $user)
                        <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-[12px] sm:rounded-[14px] bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center font-black text-[10px] sm:text-sm shadow-lg shadow-amber-900/10 group-hover/u:scale-110 transition-transform duration-300">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="ml-3 sm:ml-4 min-w-0">
                                        <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $user->name }}</div>
                                        <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                @if ($user->hasVerifiedEmail())
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-bold text-xs text-slate-400 whitespace-nowrap uppercase tracking-tighter">
                                {{ $user->created_at->format('d M Y') }}
                                <div class="text-[9px] mt-0.5 opacity-70">{{ $user->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Verify Email Button --}}
                                    @if (!$user->hasVerifiedEmail())
                                        <button type="button" @click="openActionModal('confirm-verify', '{{ route('super-admin.users.verify-email', $user) }}', '{{ addslashes($user->name) }}')"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-teal-50 text-teal-600 hover:bg-teal-600 hover:text-white transition-all duration-300 shadow-sm border border-teal-100" title="Verifikasi Email Manual">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    @endif

                                    {{-- Approve Button --}}
                                    <button type="button" @click="openActionModal('confirm-approve', '{{ route('super-admin.pengusul-desa.approve', $user) }}', '{{ addslashes($user->name) }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100" title="Setujui Akses">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </button>

                                    {{-- Reject Button --}}
                                    <button type="button" @click="openActionModal('confirm-reject', '/super-admin/pengusul-desa/{{ $user->id }}/reject', '{{ addslashes($user->name) }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100" title="Tolak Akses">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>

                                    {{-- View User Link --}}
                                    <a href="{{ route('super-admin.users.show', $user) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100" title="Lihat Profil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
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
                                    <div>
                                        <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Kosong</p>
                                        <p class="text-slate-300 text-[10px] mt-1 uppercase tracking-widest">Semua pengajuan telah diproses.</p>
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
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
                {{ $pendingUsers->links() }}
            </div>
        @endif

        {{-- Reject Modal --}}
        <x-modal name="confirm-reject" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                    <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6 font-black text-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E]">Tolak Pengajuan?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                        Anda akan menolak akses untuk <strong x-text="targetName" class="text-red-600"></strong>.
                    </p>
                    
                    <div class="mt-6">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alasan Penolakan (Wajib)</label>
                        <textarea name="rejection_reason" rows="4"
                            class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 sm:text-sm transition-all duration-300 font-medium p-4"
                            placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-red-900/20">
                        Tolak Permanen
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-reject')" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Verify Modal --}}
        <x-modal name="confirm-verify" focusable maxWidth="md">
            <form :action="actionUrl" method="POST">
                @csrf
                <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                    <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-teal-50 text-teal-600 mb-6 font-black text-2xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E]">Verifikasi Manual?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                        Anda akan memverifikasi alamat email untuk <strong x-text="targetName" class="text-teal-600"></strong> secara manual tanpa melibatkan tautan di email pengguna.
                    </p>
                </div>
                <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-teal-500 hover:bg-teal-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-teal-900/20">
                        Verifikasi
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-verify')" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>

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
                        Anda akan menyetujui <strong x-text="targetName" class="text-emerald-600"></strong> sebagai Pengusul Desa terdaftar. Mereka akan diberi akses penuh ke kapabilitas platform.
                    </p>
                </div>
                <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-emerald-900/20">
                        Setujui Akses
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'confirm-approve')" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.super-admin>
