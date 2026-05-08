<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">{{ $user->name }}</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-5 sm:gap-8">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-[1.5rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div class="space-y-1.5 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            @foreach($user->roles as $role)
                                <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                                    {{ str_replace('-', ' ', $role->name) }}
                                </div>
                            @endforeach
                            <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">User Profile</span>
                        </div>
                        <h2 class="text-2xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            {{ $user->name }}
                        </h2>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.users.edit', $user) }}" class="px-6 py-4 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all flex items-center gap-3 shadow-lg shadow-blue-900/20 active:scale-95 group/btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profil
                    </a>
                    <a href="{{ route('super-admin.users.index') }}" class="px-6 py-4 bg-slate-50 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all border border-slate-100 active:scale-95">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ approveModalOpen: false, rejectModalOpen: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        {{-- Left: Main Profile Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Account Status Card --}}
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                    <span class="shrink-0">Status Akun</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Email Status --}}
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100 space-y-1 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Email</p>
                        @if($user->hasVerifiedEmail())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                Belum Diverifikasi
                            </span>
                        @endif
                    </div>
                    {{-- Admin Approval Status --}}
                    @if($user->hasRole('pengusul-desa'))
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100 space-y-1 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Persetujuan Admin</p>
                        @if($user->is_approved_by_admin)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-orange-50 text-orange-600 border border-orange-100">
                                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                                Menunggu
                            </span>
                        @endif
                    </div>
                    @endif
                    {{-- Account Status --}}
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100 space-y-1 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Status</p>
                        @if($user->is_suspended)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100">
                                Ditangguhkan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                Aktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Document Verification Card (New) --}}
            @if($user->hasRole('pengusul-desa') && $user->profile?->surat_pengajuan_path)
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                    <span class="shrink-0">Dokumen Verifikasi</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-5 text-left">
                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-red-500 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Surat Pengajuan/Tugas</p>
                            <p class="text-sm font-bold text-[#03045E]">Dokumen_Verifikasi_Desa.pdf</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($user->profile->surat_pengajuan_path) }}" target="_blank" class="px-6 py-3 bg-white border border-slate-200 text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#03045E] hover:text-white hover:border-[#03045E] transition-all flex items-center gap-2 shadow-sm group">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Dokumen
                    </a>
                </div>
            </div>
            @endif

            {{-- Profile Details Card --}}
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                    <span class="shrink-0">Informasi Pendaftar</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</p>
                        <p class="text-base font-black text-[#03045E]">{{ $user->name }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Email</p>
                        <p class="text-base font-bold text-slate-700 break-words">{{ $user->email }}</p>
                    </div>
                    @if($user->village)
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Nama Desa</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#0077B6]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <p class="text-base font-black text-[#03045E]">{{ $user->village->name }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Tanggal Daftar</p>
                        <p class="text-base font-bold text-slate-700">{{ $user->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    @if($user->is_approved_by_admin && $user->approved_by_admin_at)
                    <div class="space-y-1.5 sm:col-span-2">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Tanggal Disetujui</p>
                        <p class="text-base font-bold text-emerald-600">{{ $user->approved_by_admin_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Sidebar Actions --}}
        <div class="space-y-6">
            @if($user->hasRole('pengusul-desa') && !$user->is_approved_by_admin)
            {{-- Pending Approval Action Card --}}
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-orange-100 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-orange-50 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-[#03045E]">Menunggu Tindakan</h3>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">Pendaftar baru</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">
                        Pendaftar ini membutuhkan persetujuan admin untuk dapat mengakses fitur platform. Setujui jika data valid, atau tolak jika tidak memenuhi syarat.
                    </p>
                    <div class="space-y-3">
                        <button @click="approveModalOpen = true" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-emerald-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Setujui Akses
                        </button>
                        <button @click="rejectModalOpen = true" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all border border-red-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak Pengajuan
                        </button>
                    </div>
                </div>
            </div>
            @elseif($user->hasRole('pengusul-desa') && $user->is_approved_by_admin)
            {{-- Already Approved Card --}}
            <div class="bg-emerald-50 rounded-[2rem] sm:rounded-[2.5rem] border border-emerald-100 p-8 text-center">
                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-emerald-500 mx-auto mb-4 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-black text-emerald-700 text-sm uppercase tracking-wider mb-1">Sudah Disetujui</h3>
                <p class="text-xs text-emerald-600/70 font-medium">
                    {{ $user->approved_by_admin_at ? $user->approved_by_admin_at->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
            @endif

            {{-- Quick Links Card --}}
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Tindakan Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('super-admin.users.edit', $user) }}" class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-[#03045E] text-slate-600 hover:text-white transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span class="font-black text-xs uppercase tracking-widest">Edit Profil</span>
                    </a>
                    @if(!$user->hasVerifiedEmail())
                    <form action="{{ route('super-admin.users.verify-email', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-sky-500 text-slate-600 hover:text-white transition-all text-left">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-black text-xs uppercase tracking-widest">Verifikasi Email</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

    {{-- Approve Modal --}}
    <div x-show="approveModalOpen" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="approveModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                    <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-emerald-50 text-emerald-600 mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E]">Setujui Akses?</h3>
                    <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                        Anda akan menyetujui <strong class="text-emerald-600">{{ $user->name }}</strong> sebagai Pengusul Desa. Email dan akun akan diaktifkan bersamaan.
                    </p>
                </div>
                <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                    <form action="{{ route('super-admin.pengusul-desa.approve', $user) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-emerald-900/20">Ya, Setujui</button>
                    </form>
                    <button @click="approveModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all">Batal</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div x-show="rejectModalOpen" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="rejectModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ route('super-admin.pengusul-desa.reject', $user) }}" method="POST">
                    @csrf
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]">Tolak Pengajuan?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Anda akan menolak dan menangguhkan akun <strong class="text-red-600">{{ $user->name }}</strong>.
                        </p>
                        <div class="mt-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alasan Penolakan (Wajib)</label>
                            <textarea name="rejection_reason" rows="3" required
                                class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 sm:text-sm transition-all font-medium p-4"
                                placeholder="Jelaskan alasan penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                        <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-red-900/20">Tolak & Suspend</button>
                        <button type="button" @click="rejectModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-layouts.super-admin>
