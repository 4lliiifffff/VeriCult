<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Manajemen Data</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                            Super Admin
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Manajemen <span class="text-[#00B4D8]">Data Kebudayaan</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Pantau, verifikasi, dan perbarui seluruh data warisan budaya Nusantara.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Filters & Search -->
        <div class="bg-white p-5 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white">
            <form action="{{ route('super-admin.cultural-submissions.index') }}" method="GET" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Cari Nama Objek</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Wayang Kulit..." class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-0 transition-all font-bold text-slate-600">
                            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kategori</label>
                        <select name="category" class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-0 transition-all font-bold text-slate-600 appearance-none">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Status</label>
                        <select name="status" class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-0 transition-all font-bold text-slate-600 appearance-none">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                    @if(request()->anyFilled(['search', 'category', 'status']))
                        <a href="{{ route('super-admin.cultural-submissions.index') }}" class="w-full sm:w-auto px-8 py-4 sm:py-3 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center">Reset Filter</a>
                    @endif
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 sm:py-3 bg-[#03045E] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 sm:px-8 py-4 sm:py-6">Objek Kebudayaan</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-6">Kategori</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-6">Pengusul</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-6 text-center">Status</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="hover:bg-slate-50/50 transition-all duration-200 group">
                            <td class="px-6 sm:px-8 py-4 sm:py-6">
                                <div class="font-black text-sm sm:text-base text-[#03045E] group-hover:text-[#0077B6] transition-colors break-words">{{ $submission->name }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">ID: #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-6">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-50 text-[#0077B6] border border-blue-100">
                                    {{ $submission->category }}
                                </span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500">
                                        {{ substr($submission->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-xs font-bold text-slate-600 truncate max-w-[120px]">{{ $submission->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $submission->status_color }}">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-[#03045E] hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('super-admin.cultural-submissions.edit', $submission) }}" class="p-2.5 bg-blue-50 text-[#0077B6] rounded-xl hover:bg-[#0077B6] hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <div class="text-slate-400 font-bold uppercase tracking-widest text-xs">Tidak ada data ditemukan</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($submissions->hasPages())
                <div class="px-8 py-6 border-t border-slate-50">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.super-admin>
