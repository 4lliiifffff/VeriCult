<!-- Header -->
<x-layouts.pengusul-desa>
    <x-slot name="header">
        <div class="relative mb-6 sm:mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-8 sm:p-10 overflow-hidden shadow-2xl shadow-blue-900/20 text-white">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Dashboard Pengusul
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Dashboard <span class="text-[#00B4D8]">Pengusul</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium break-words">Selamat datang, {{ Auth::user()->name }}.</p>
                </div>

                <!-- Form Type Selector / Action Buttons -->
                <div class="flex flex-col gap-3 w-full md:w-auto mt-4 md:mt-0">
                    @if($isPenguslDesa && !$isApprovedByAdmin)
                        <!-- Approval Pending Status -->
                        <div class="flex items-center gap-3 bg-amber-400/20 backdrop-blur-xl p-3 sm:p-4 rounded-2xl border border-amber-400/40 shadow-inner w-full">
                            <svg class="w-5 h-5 text-amber-300 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-amber-100">Menunggu Persetujuan</p>
                                <p class="text-[10px] sm:text-xs text-amber-100/70">Akun Anda sedang dalam review oleh super admin.</p>
                            </div>
                        </div>
                    @else
                        <!-- Form Type Selector Buttons -->
                        <div class="flex items-center gap-3 flex-wrap md:flex-nowrap">
                            <!-- Kebudayaan Aktif Button -->
                            <a href="{{ route('pengusul-desa.submissions.create-form', 'laporan-kebudayaan-aktif') }}" class="flex-1 md:flex-none justify-center bg-white text-[#03045E] px-4 sm:px-5 py-3 rounded-xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-all hover:shadow-lg shadow-blue-900/10 border-2 border-white hover:border-blue-200">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="hidden sm:inline">Melaporkan Kebudayaan Aktif</span>
                                <span class="sm:hidden">Aktif</span>
                            </a>

                            <!-- Statistik Button (only for pengusul-desa approved) -->
                            @if($hasStatistikAccess)
                                <a href="{{ route('pengusul-desa.statistic-submissions.create') }}" class="flex-1 md:flex-none justify-center bg-gradient-to-r from-[#2D7A4A] to-[#48BB78] text-white px-4 sm:px-5 py-3 rounded-xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest flex items-center gap-2 hover:from-[#2D7A4A]/80 hover:to-[#48BB78]/80 transition-all hover:shadow-lg shadow-green-900/20 border-2 border-transparent hover:border-green-300">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Laporan Data Statistik</span>
                                    <span class="sm:hidden">Statistik</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Form Type Quick Links (if pengusul-desa and approved) -->
        @if($isPenguslDesa && $hasStatistikAccess)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Active Culture Card -->
            <a href="{{ route('pengusul-desa.submissions.index') }}" class="group bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 shadow-sm border border-blue-100 hover:shadow-lg hover:border-blue-200 transition-all hover:-translate-y-1 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div class="space-y-3 flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#0077B6] text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Melaporkan Kebudayaan Aktif</span>
                        </div>
                        <p class="text-3xl font-black text-[#03045E]">{{ $activeCultureCount }}</p>
                        <p class="text-sm text-slate-600 font-medium">Laporan kebudayaan yang sedang terjadi</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </a>

            <!-- Statistik Card -->
            <a href="{{ route('pengusul-desa.statistic-submissions.index') }}" class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 sm:p-8 shadow-sm border border-green-100 hover:shadow-lg hover:border-green-200 transition-all hover:-translate-y-1 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div class="space-y-3 flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#2D7A4A] text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-green-600 uppercase tracking-widest">Laporan Data Statistik</span>
                        </div>
                        <p class="text-3xl font-black text-[#0A4F23]">{{ $statistikCount }}</p>
                        <p class="text-sm text-slate-600 font-medium">Data statistik dari 11 kategori OPK</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
            </a>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total -->
            <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</p>
                        <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $totalSubmissions }}</h3>
                    </div>
                    <div class="p-2.5 bg-blue-50/50 rounded-xl text-[#0077B6]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Draft -->
            <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Draft</p>
                        <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $draftCount }}</h3>
                    </div>
                    <div class="p-2.5 bg-gray-50/50 rounded-xl text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- In Review -->
            <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dalam Review</p>
                        <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $inReviewCount }}</h3>
                    </div>
                    <div class="p-2.5 bg-indigo-50/50 rounded-xl text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Published -->
            <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dipublikasi</p>
                        <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $publishedCount }}</h3>
                    </div>
                    <div class="p-2.5 bg-green-50/50 rounded-xl text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Rejected -->
            <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ditolak</p>
                        <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $rejectedCount }}</h3>
                    </div>
                    <div class="p-2.5 bg-red-50/50 rounded-xl text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-[#03045E]">Pengajuan Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">5 pengajuan terakhir Anda.</p>
                </div>
                <a href="{{ route('pengusul-desa.submissions.index') }}" class="text-xs font-medium text-[#0077B6] hover:text-[#0096C7] transition-colors bg-blue-50/50 hover:bg-blue-100 px-3 py-1.5 rounded-lg">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/30 border-b border-slate-100">
                            <th class="px-5 py-3 tracking-wider">Nama</th>
                            <th class="px-5 py-3 tracking-wider">Kategori</th>
                            <th class="px-5 py-3 tracking-wider text-center">Status</th>
                            <th class="px-5 py-3 tracking-wider text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentSubmissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('pengusul-desa.submissions.show', $submission) }}" class="font-bold text-sm text-[#03045E] group-hover:text-[#0077B6] transition-colors">{{ $submission->name }}</a>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs text-slate-600">{{ $submission->category }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right text-xs text-slate-500">
                                {{ $submission->created_at->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-400 text-xs">
                                Belum ada pengajuan. <a href="{{ route('pengusul-desa.submissions.create') }}" class="text-[#0077B6] hover:underline">Buat pengajuan pertama Anda!</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
</x-layouts.pengusul-desa>
