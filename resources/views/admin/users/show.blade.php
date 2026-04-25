<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[120px] sm:max-w-none">{{ $user->name }}</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    @php
                        $bgColor = 'bg-slate-100 text-slate-400';
                        if($user->hasRole('validator')) $bgColor = 'bg-white/10 text-white';
                        if($user->hasRole('pengusul')) $bgColor = 'bg-white/10 text-white';
                        if($user->hasRole('pengusul-desa')) $bgColor = 'bg-white/10 text-white';
                    @endphp
                    <div class="w-16 h-16 rounded-[1.2rem] {{ $bgColor }} border border-white/20 flex items-center justify-center font-black text-2xl shadow-inner">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                        <p class="text-blue-200/70 text-sm font-medium">{{ $user->email }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($user->roles as $role)
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-white/10 text-white border border-white/20">
                                    {{ str_replace('-', ' ', $role->name) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-3 bg-transparent border border-white/30 text-white/70 rounded-xl font-black text-[10px] uppercase tracking-widest hover:text-white hover:border-white/50 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        {{-- Left: Profile Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Account Status Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                    <span class="shrink-0">Status Akun</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100 space-y-2 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Verifikasi Email</p>
                        @if($user->hasVerifiedEmail())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100 space-y-2 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Status Akses</p>
                        @if($user->is_suspended)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100">
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

            {{-- Profile Details Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                    <span class="shrink-0">Informasi Profil</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</p>
                        <p class="text-base font-black text-[#03045E]">{{ $user->name }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Alamat Email</p>
                        <p class="text-base font-bold text-slate-700">{{ $user->email }}</p>
                    </div>

                    {{-- Specialized Fields based on Role --}}
                    @if($user->hasRole('pengusul-desa'))
                        <div class="space-y-1.5">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Desa Representatif</p>
                            <p class="text-base font-black text-[#03045E]">{{ $user->profile?->village?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-1.5">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Jabatan Desa</p>
                            <p class="text-base font-bold text-slate-700">{{ $user->profile?->jabatan_desa ?? '-' }}</p>
                        </div>
                        <div class="space-y-1.5">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">NIP / Identitas Pegawai</p>
                            <p class="text-base font-bold text-slate-700">{{ $user->profile?->nip ?? '-' }}</p>
                        </div>
                    @endif

                    @if($user->hasRole(['validator', 'pengusul']))
                        <div class="space-y-1.5">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Instansi / Lembaga</p>
                            <p class="text-base font-black text-[#03045E]">{{ $user->profile?->instansi ?? '-' }}</p>
                        </div>
                    @endif

                    @if($user->profile?->no_hp)
                        <div class="space-y-1.5">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Nomor Handphone</p>
                            <p class="text-base font-bold text-slate-700">{{ $user->profile->no_hp }}</p>
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Terdaftar Pada</p>
                        <p class="text-base font-bold text-slate-700">{{ $user->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Document Card for Pengusul Desa --}}
            @if($user->hasRole('pengusul-desa') && $user->profile?->surat_pengajuan_path)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="shrink-0">Dokumen Pendukung</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h2>
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-rose-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">Surat Pengajuan Desa</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Dokumen Verifikasi Identitas</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $user->profile->surat_pengajuan_path) }}" target="_blank" class="px-5 py-3 bg-[#03045E] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/10">
                            Lihat Dokumen
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Quick Stats/Info --}}
        <div class="space-y-6">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Informasi Login</h3>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Terakhir Aktif</p>
                            <p class="text-xs font-bold text-[#03045E]">{{ $user->last_seen_at ? $user->last_seen_at->diffForHumans() : 'Belum pernah' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Verifikasi Admin</p>
                            <p class="text-xs font-bold {{ $user->profile?->is_approved_by_admin ? 'text-emerald-600' : 'text-amber-500' }}">
                                {{ $user->profile?->is_approved_by_admin ? 'Sudah Disetujui' : 'Belum/Tidak Memerlukan' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Governance Shortcut --}}
            <div class="bg-[#03045E] rounded-[2.5rem] shadow-2xl shadow-blue-900/40 p-1">
                <div class="bg-[#03045E] p-8 rounded-[2.3rem] border border-white/10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Moderasi Akun</h3>
                    <div class="space-y-3">
                        @if($user->is_suspended)
                            <button type="button" @click="$dispatch('open-modal', 'unsuspend-modal')" class="w-full py-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">
                                Cabut Penangguhan
                            </button>
                        @else
                            <button type="button" @click="$dispatch('open-modal', 'suspend-modal')" class="w-full py-4 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                                Tangguhkan Akses
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Governance Modals (Reusable from index logic if needed, but here simple to add) --}}
    <x-modal name="suspend-modal" :show="false" focusable>
        <div class="p-8 sm:p-12">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-rose-50 rounded-3xl flex items-center justify-center text-rose-600 mb-6 shadow-inner italic font-black text-2xl">!</div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Tangguhkan Pengguna?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm">Tangguhkan akses untuk <strong>{{ $user->name }}</strong>.</p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="$dispatch('close')" class="px-6 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest">Batal</button>
                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-rose-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest">Ya, Tangguhkan</button>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    <x-modal name="unsuspend-modal" :show="false" focusable>
        <div class="p-8 sm:p-12">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mb-6 shadow-inner italic font-black text-2xl">✓</div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Aktifkan Pengguna?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm">Dapatkan kembali akses untuk <strong>{{ $user->name }}</strong>.</p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="$dispatch('close')" class="px-6 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest">Batal</button>
                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-emerald-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest">Ya, Aktifkan</button>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>
</x-layouts.admin>
