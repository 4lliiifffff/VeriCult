<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Laporan</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                            Laporan
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Rekapan <span class="text-[#00B4D8]">Kebudayaan Tervalidasi</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Lihat dan cetak hasil data kebudayaan yang sudah disetujui.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-white/10 backdrop-blur-xl p-4 sm:p-5 rounded-[1.5rem] sm:rounded-2xl border border-white/20 shadow-inner">
                    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col gap-1 items-start sm:items-end flex-1 sm:flex-none">
                        <label for="category" class="text-[10px] font-black text-[#00B4D8] uppercase tracking-[0.2em] px-1">Filter Kategori</label>
                        <select name="category" id="category" onchange="this.form.submit()" class="w-full sm:w-auto bg-white/20 text-white border border-white/30 rounded-xl px-4 py-2.5 text-sm font-bold focus:ring-[#00B4D8] focus:border-[#00B4D8] transition-all outline-none cursor-pointer">
                            <option value="" class="text-slate-900">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $activeCategory == $cat ? 'selected' : '' }} class="text-slate-900">
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <div class="hidden sm:block h-10 w-px bg-white/20 mx-2"></div>
                    <div class="w-full sm:w-auto mt-2 sm:mt-0">
                        <a href="{{ route('reports.print', ['category' => $activeCategory]) }}" target="_blank" class="w-full sm:w-auto bg-white text-[#03045E] px-6 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 pb-12">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-lg sm:text-xl font-black text-[#03045E]">Daftar Budaya Tervalidasi</h3>
                <span class="px-4 py-1.5 bg-blue-50 text-[#0077B6] rounded-full text-[10px] sm:text-xs font-bold">{{ $submissions->count() }} Data Ditemukan</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Nama Objek</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Kategori</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Lokasi</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Pengusul</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Tanggal Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($submissions as $sub)
                        <tr class="hover:bg-slate-50/50 transition-all duration-200">
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <span class="font-bold text-sm text-[#03045E]">{{ $sub->name }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest text-[#0077B6] bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-100">{{ $sub->category }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <span class="text-xs text-slate-600 truncate max-w-[200px] block" title="{{ $sub->address }}">{{ $sub->address }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-xs font-bold text-slate-700">{{ $sub->user->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-xs font-bold text-slate-500">{{ $sub->published_at ? $sub->published_at->translatedFormat('d F Y') : '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <p class="text-slate-400 font-bold italic">Belum ada data kebudayaan tervalidasi di kategori ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.validator>
