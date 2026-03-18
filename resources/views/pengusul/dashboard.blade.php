<!-- Header -->
<x-layouts.pengusul>
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

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3 w-full md:w-auto mt-4 md:mt-0">
                    <div class="flex items-center gap-3 flex-wrap md:flex-nowrap">
                        <!-- Kebudayaan Aktif Button -->
                        <a href="{{ route('pengusul.submissions.create-form', 'laporan-kebudayaan-aktif') }}" class="flex-1 md:flex-none justify-center bg-white text-[#03045E] px-4 sm:px-5 py-3 rounded-xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-all hover:shadow-lg shadow-blue-900/10 border-2 border-white hover:border-blue-200">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="hidden sm:inline">Melaporkan Kebudayaan Aktif</span>
                            <span class="sm:hidden">Aktif</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">


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
                <a href="{{ route('pengusul.submissions.index') }}" class="text-xs font-medium text-[#0077B6] hover:text-[#0096C7] transition-colors bg-blue-50/50 hover:bg-blue-100 px-3 py-1.5 rounded-lg">
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
                                <a href="{{ route('pengusul.submissions.show', $submission) }}" class="font-bold text-sm text-[#03045E] group-hover:text-[#0077B6] transition-colors">{{ $submission->name }}</a>
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
                                Belum ada pengajuan. <a href="{{ route('pengusul.submissions.create') }}" class="text-[#0077B6] hover:underline">Buat pengajuan pertama Anda!</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
</x-layouts.pengusul>
