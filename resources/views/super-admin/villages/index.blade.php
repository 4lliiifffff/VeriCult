<x-layouts.super-admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Data Desa</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Wilayah Administrasi
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Kelola <span class="text-[#00B4D8]">Desa</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Manajemen daftar desa dan pemetaan wilayah kecamatan.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
        <div class="p-6 sm:p-10 border-b border-slate-50 bg-white">
            <form action="{{ route('super-admin.villages.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-[#0077B6]">
                        <svg class="h-5 w-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama desa..." 
                        class="block w-full pl-14 pr-6 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-bold text-[#03045E] focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300 shadow-inner">
                </div>
                <div class="w-full md:w-64">
                    <select name="kecamatan_id" class="block w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-bold text-[#03045E] focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all shadow-inner appearance-none cursor-pointer">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>{{ $kec->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-8 py-4 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-10 py-4 sm:py-6">Nama Desa</th>
                        <th class="px-6 sm:px-10 py-4 sm:py-6">Kecamatan</th>
                        <th class="px-6 sm:px-10 py-4 sm:py-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($villages as $village)
                    <tr class="hover:bg-slate-50/30 transition-colors group/u">
                        <td class="px-6 sm:px-10 py-4 sm:py-6">
                            <div class="font-bold text-sm sm:text-base text-[#03045E] group-hover/u:text-[#0077B6] transition-colors">{{ $village->name }}</div>
                        </td>
                        <td class="px-6 sm:px-10 py-4 sm:py-6">
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                {{ $village->kecamatan->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 sm:px-10 py-4 sm:py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.villages.edit', $village) }}" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#03045E] hover:text-white transition-all shadow-sm border border-slate-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('super-admin.villages.destroy', $village) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus desa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 rounded-xl bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm border border-rose-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($villages->hasPages())
        <div class="px-6 sm:px-10 py-6 border-t border-slate-50 bg-slate-50/30">
            {{ $villages->links() }}
        </div>
        @endif
    </div>
</x-layouts.super-admin>
