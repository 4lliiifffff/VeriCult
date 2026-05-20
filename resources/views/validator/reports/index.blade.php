<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Laporan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 group mb-8">
            <!-- Background Decorations Clipping Container -->
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/5 rounded-full blur-2xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                                Laporan
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Portal Validator</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Rekapan <span class="text-[#00B4D8]">Tervalidasi</span>
                        </h2>
                        <p class="text-slate-500 text-xs sm:text-sm font-medium">Lihat dan cetak hasil data kebudayaan yang sudah disetujui.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-[1.5rem] sm:rounded-2xl border border-slate-100 shadow-inner relative z-20">
                    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col gap-1 items-start sm:items-end flex-1 sm:flex-none auto-submit">
                        <x-dropdown-select 
                            name="category" 
                            id="category" 
                            label="Filter Kategori" 
                            placeholder="Semua Kategori"
                            all-label="Semua Kategori"
                            variant="light"
                            :selected="$activeCategory" 
                            :options="collect($categories)->mapWithKeys(fn($c) => [$c => $c])->toArray()" 
                        />
                    </form>
                    <div class="hidden sm:block h-10 w-px bg-slate-200 mx-2"></div>
                    <div class="w-full sm:w-auto mt-2 sm:mt-0 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('reports.print', ['category' => $activeCategory]) }}" target="_blank" class="w-full sm:w-auto bg-slate-100 text-[#03045E] border-2 border-slate-200 px-6 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-slate-200 hover:-translate-y-1 transition-all active:scale-95 group/btn2">
                            <svg class="w-4 h-4 group-hover/btn2:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Ringkasan
                        </a>
                        <a href="{{ route('reports.print-comprehensive', ['year' => 'all']) }}" target="_blank" class="w-full sm:w-auto bg-[#03045E] text-white px-6 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-[#0077B6] hover:-translate-y-1 transition-all shadow-xl shadow-blue-900/20 active:scale-95 group/btn">
                            <svg class="w-4 h-4 group-hover/btn:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Cetak Laporan Lengkap
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
                <table class="w-full text-left border-collapse min-w-max responsive-table no-actions">
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
                            <td class="px-6 sm:px-8 py-4 sm:py-5" data-label="Nama Objek">
                                <div class="flex flex-col text-left">
                                    <span class="font-bold text-sm text-[#03045E]">{{ $sub->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5" data-label="Kategori">
                                <div class="cell-wrapper-row">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-[#0077B6] bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-100">{{ $sub->category }}</span>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5" data-label="Lokasi">
                                <div class="cell-wrapper">
                                    <span class="text-xs text-slate-600 truncate max-w-[200px] block" title="{{ $sub->address }}">{{ $sub->address }}</span>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 lg:text-center text-right" data-label="Pengusul">
                                <div class="cell-wrapper">
                                    <span class="text-xs font-bold text-slate-700">{{ $sub->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 lg:text-center text-right" data-label="Tanggal Validasi">
                                <div class="cell-wrapper">
                                    <span class="text-xs font-bold text-slate-500">{{ $sub->published_at ? $sub->published_at->translatedFormat('d F Y') : '-' }}</span>
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
                                    <h4 class="text-2xl font-black text-[#03045E] mb-2 tracking-tight">Data Kosong</h4>
                                    <p class="text-slate-400 text-sm font-medium mb-4 leading-relaxed">Belum ada data kebudayaan tervalidasi di kategori ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.validator>
