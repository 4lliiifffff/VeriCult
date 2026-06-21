<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pengajuan Saya</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <!-- Decorative Bubbles -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                                Inventarisasi Budaya
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Portal Pengusul Desa</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Kelola <span class="text-[#00B4D8]">Pengajuan</span>
                        </h2>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <a href="{{ route('pengusul-desa.submissions.create') }}" class="inline-flex items-center justify-center px-8 py-4 sm:py-5 bg-[#03045E] text-white rounded-2xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.2em] hover:bg-[#0077B6] hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-blue-900/20 active:scale-95 gap-3 group/btn">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover/btn:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Pengajuan</span>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 sm:space-y-10 pb-12">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-blue-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0077B6] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pengajuan</p>
                    <h3 class="text-3xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($submissions->total()) }}</h3>
                </div>
            </div>

            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-amber-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Draft & Revisi</p>
                    <h3 class="text-3xl font-black text-[#03045E] tabular-nums tracking-tight">
                        {{ number_format($submissions->whereIn('status', [\App\Models\CulturalSubmission::STATUS_DRAFT, \App\Models\CulturalSubmission::STATUS_REVISION])->count()) }}
                    </h3>
                </div>
            </div>

            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Terverifikasi</p>
                    <h3 class="text-3xl font-black text-[#03045E] tabular-nums tracking-tight">
                        {{ number_format($submissions->where('status', \App\Models\CulturalSubmission::STATUS_VERIFIED)->count()) }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white">
            <form action="{{ route('pengusul-desa.submissions.index') }}" method="GET" class="space-y-4">
                <!-- Baris 1: Cari -->
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama pengajuan, alamat, atau kategori..." 
                           class="w-full pl-14 pr-4 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-blue-500/5 transition-all outline-none">
                </div>

                <!-- Baris 2: Filter -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-full sm:w-2/5">
                        <x-dropdown-select
                            name="type"
                            id="type"
                            placeholder="Semua Jenis Kebudayaan"
                            variant="light"
                            :selected="request('type', 'all')"
                            :options="[
                                'all' => 'Semua Jenis Kebudayaan',
                                'aktif' => 'Laporan Aktif',
                                'opk' => 'OPK',
                                'cagar-budaya' => 'Cagar Budaya',
                                'potensi-kebudayaan' => 'Potensi Budaya'
                            ]"
                        />
                    </div>
                    
                    <div class="w-full sm:w-2/5">
                        <x-dropdown-select
                            name="status"
                            id="status"
                            placeholder="Semua Status Pengajuan"
                            variant="light"
                            :selected="request('status', 'all')"
                            :options="[
                                'all' => 'Semua Status Pengajuan',
                                'draf' => 'Draf',
                                'diajukan' => 'Diajukan',
                                'tinjauan_administratif' => 'Review Administratif',
                                'verifikasi_lapangan' => 'Verifikasi Lapangan',
                                'diverifikasi' => 'Diverifikasi',
                                'diterbitkan' => 'Dipublikasikan',
                                'revisi' => 'Butuh Revisi',
                                'ditolak' => 'Ditolak'
                            ]"
                        />
                    </div>

                    <div class="w-full sm:w-1/5 flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-4 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#0077B6] transition-colors shadow-lg shadow-blue-900/20 text-center">
                            Terapkan
                        </button>
                        @if(request()->hasAny(['search', 'type', 'status']) && (request('type') != 'all' || request('status') != 'all' || request('search') != ''))
                        <a href="{{ route('pengusul-desa.submissions.index') }}" class="flex-none px-4 py-4 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-red-100 transition-colors shadow-inner flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Submissions Table Card -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
            <div class="p-8 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Riwayat Pengajuan</h3>
                    <p class="text-slate-400 font-medium text-xs sm:text-sm mt-1 uppercase tracking-widest">
                        @if(request('type') && request('type') !== 'all')
                            Kategori: {{ match(request('type')) {
                                'aktif' => 'Laporan Aktif',
                                'opk' => 'OPK',
                                'cagar-budaya' => 'Cagar Budaya',
                                'potensi-kebudayaan' => 'Potensi Budaya',
                                default => 'Semua'
                            } }}
                        @else
                            Seluruh Jenis Inventarisasi
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100 self-start sm:self-auto">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Sinkronisasi Aktif</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max responsive-table">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Informasi Pengajuan</th>
                            <th class="px-10 py-6">Jenis</th>
                            <th class="px-10 py-6 text-center">Status</th>
                            <th class="px-10 py-6 text-center">Tgl. Pengajuan</th>
                            <th class="px-10 py-6 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($submissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group/row">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-[#03045E] font-black text-sm group-hover/row:bg-[#03045E] group-hover/row:text-white transition-all duration-500 shadow-inner">
                                        {{ substr($submission->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[15px] text-[#03045E] group-hover/row:text-[#0077B6] transition-colors">{{ $submission->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            <span class="line-clamp-1 max-w-[200px]">{{ $submission->address }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="space-y-1">
                                    @php
                                        $typeInfo = match($submission->submission_type) {
                                            'aktif' => ['label' => 'KEBUDAYAAN AKTIF', 'color' => 'text-blue-500 bg-blue-50 border-blue-100'],
                                            'opk' => ['label' => 'DATA OPK', 'color' => 'text-indigo-500 bg-indigo-50 border-indigo-100'],
                                            'cagar-budaya' => ['label' => 'CAGAR BUDAYA', 'color' => 'text-amber-500 bg-amber-50 border-amber-100'],
                                            'potensi-kebudayaan' => ['label' => 'POTENSI BUDAYA', 'color' => 'text-emerald-500 bg-emerald-50 border-emerald-100'],
                                            default => ['label' => 'UMUM', 'color' => 'text-slate-500 bg-slate-50 border-slate-100'],
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-lg border {{ $typeInfo['color'] }} text-[9px] font-black tracking-widest shadow-sm">
                                        {{ $typeInfo['label'] }}
                                    </span>
                                    <div class="text-[11px] font-bold text-slate-400 px-1">{{ $submission->category }}</div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                @php
                                    $colorClass = match($submission->status_color) {
                                        'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'amber' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'emerald', 'green' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'red' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $colorClass }} border shadow-sm">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <div class="text-xs font-bold text-[#03045E]">{{ $submission->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('pengusul-desa.submissions.show', $submission) }}" 
                                       class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#03045E] hover:text-white transition-all shadow-sm"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if($submission->isEditable())
                                    <a href="{{ route('pengusul-desa.submissions.edit', $submission) }}" 
                                       class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                       title="Edit Pengajuan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-8 relative group-hover:scale-110 transition-transform duration-500 shadow-inner">
                                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h4 class="text-2xl font-black text-[#03045E] mb-2 tracking-tight">Belum Ada Pengajuan</h4>
                                    <p class="text-slate-400 text-sm font-medium mb-10 leading-relaxed">Sepertinya Anda belum memiliki riwayat pengajuan data kebudayaan. Mari buat pengajuan pertama Anda sekarang!</p>
                                    <a href="{{ route('pengusul-desa.submissions.create') }}" 
                                       class="inline-flex items-center px-10 py-4 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-[#0077B6] active:scale-95 transition-all">
                                        Mulai Pengajuan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($submissions->hasPages())
            <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.pengusul-desa>
