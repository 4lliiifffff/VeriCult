<x-layouts.admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Antrian Persetujuan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group mb-8">
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
                    <a href="{{ route('admin.users.index') }}" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/5 transition-transform active:scale-95 group border border-slate-100">
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
            
            openActionModal(modalName, url, name) {
                this.actionUrl = url;
                this.targetName = name;
                $dispatch('open-modal', modalName);
            }
        }">
        
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group mb-20">
            <!-- Search Area -->
            <div class="p-5 sm:p-8 border-b border-slate-50 bg-white">
                <form action="{{ route('admin.user-approvals.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6">
                    <div class="flex-1">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari pengusul berdasarkan nama atau email..." 
                                class="pl-12 block w-full rounded-2xl border-slate-100 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] placeholder:text-slate-300">
                        </div>
                    </div>
                    <button type="submit" class="bg-[#03045E] text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                        Filter Data
                    </button>
                </form>
            </div>

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
                                            <button type="button" @click="openActionModal('confirm-verify', '{{ route('admin.users.verify-email', $user) }}', '{{ addslashes($user->name) }}')"
                                                class="w-11 h-11 flex items-center justify-center rounded-2xl bg-blue-50 text-[#0077B6] hover:bg-[#0077B6] hover:text-white transition-all duration-300 shadow-sm border border-blue-100 active:scale-95 group/btn" title="Verifikasi Email Manual">
                                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        @endif

                                        {{-- Approve Button --}}
                                        <button type="button" @click="openActionModal('confirm-approve', '{{ route('admin.user-approvals.approve', $user) }}', '{{ addslashes($user->name) }}')"
                                            class="w-11 h-11 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-sm border border-emerald-100 active:scale-95 group/btn" title="Setujui Akses">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </button>

                                        {{-- Reject Button --}}
                                        <button type="button" @click="openActionModal('confirm-reject', '{{ route('admin.user-approvals.reject', $user) }}', '{{ addslashes($user->name) }}')"
                                            class="w-11 h-11 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100 active:scale-95 group/btn" title="Tolak Akses">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>

                                        {{-- View User Link --}}
                                        <a href="{{ route('admin.users.show', $user) }}" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white transition-all duration-300 shadow-sm border border-slate-100 active:scale-95 group/btn" title="Lihat Profil">
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
</x-layouts.admin>
