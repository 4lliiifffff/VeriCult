<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#0077B6]"><span class="text-[#03045E]">Laporan Budaya</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden">
            <!-- Background Decorations Clipping Container -->
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            </div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Reporting
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Rekapitulasi Data Terpadu</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Rekapan <span class="text-[#0077B6]">Budaya</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Kelola, tinjau, dan ekspor hasil validasi data kebudayaan Nusantara secara akurat.</p>
                </div>
                    
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-[2rem] border border-slate-100 shadow-inner relative z-20">
                    <form action="{{ route('reports.index') }}" method="GET" class="auto-submit">
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
                    <div class="hidden sm:block h-12 w-px bg-slate-200 mx-2"></div>
                    <div>
                        <a href="{{ route('reports.print', ['category' => $activeCategory]) }}" target="_blank" class="w-full sm:w-auto bg-[#03045E] text-white px-8 py-4 sm:py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 group group/print">
                            <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-xl font-black text-[#03045E]">Daftar Budaya Tervalidasi</h3>
                <span class="w-fit px-4 py-1.5 bg-blue-50 text-[#0077B6] rounded-full text-[10px] sm:text-xs font-bold ring-1 ring-blue-100">{{ $submissions->count() }} Data Ditemukan</span>
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
                                <span class="font-bold text-xs sm:text-sm text-[#03045E] break-words">{{ $sub->name }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest text-[#0077B6] bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-100">{{ $sub->category }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <span class="text-[11px] sm:text-xs text-slate-600 truncate max-w-[150px] sm:max-w-[200px] block" title="{{ $sub->address }}">{{ $sub->address }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-[11px] sm:text-xs font-bold text-slate-700">{{ $sub->user->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-[11px] sm:text-xs font-bold text-slate-500 whitespace-nowrap">{{ $sub->published_at ? $sub->published_at->translatedFormat('d F Y') : '-' }}</span>
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
</x-layouts.super-admin>
