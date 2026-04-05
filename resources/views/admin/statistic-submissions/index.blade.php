<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Data Statistik</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Publikasi Data
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        Manajemen <span class="text-[#00B4D8]">Statistik</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Review dan publikasi laporan statistik kebudayaan dari desa.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white mb-8">
        <form action="{{ route('admin.statistic-submissions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                <select name="category" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 text-sm font-bold transition-all duration-300">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status</label>
                <select name="status" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 text-sm font-bold transition-all duration-300">
                    <option value="">Semua Status (Verifikasi/Publik)</option>
                    <option value="{{ \App\Models\CulturalSubmission::STATUS_VERIFIED }}" {{ request('status') == \App\Models\CulturalSubmission::STATUS_VERIFIED ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="{{ \App\Models\CulturalSubmission::STATUS_PUBLISHED }}" {{ request('status') == \App\Models\CulturalSubmission::STATUS_PUBLISHED ? 'selected' : '' }}>Dipublikasikan</option>
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 h-11 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#023E8A] transition-all shadow-lg shadow-blue-900/10">Filter</button>
                <a href="{{ route('admin.statistic-submissions.index') }}" class="flex-1 h-11 bg-slate-100 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-slate-200 transition-all">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5">Nama Objek</th>
                        <th class="px-8 py-5">Desa</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-slate-50/30 transition-all duration-200">
                            <td class="px-8 py-5">
                                <p class="font-bold text-sm text-[#03045E] leading-tight mb-1">{{ $submission->name }}</p>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $submission->category }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs font-bold text-slate-600">{{ $submission->village?->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $submission->user?->name }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span @class([
                                    'px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest',
                                    'bg-amber-50 text-amber-600 border border-amber-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                                    'bg-emerald-50 text-emerald-600 border border-emerald-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                                ])>
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('admin.statistic-submissions.show', $submission) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-slate-50 text-slate-600 hover:bg-[#03045E] hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group">
                                    Detail
                                    <svg class="ml-2 w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <p class="text-slate-400 font-bold uppercase text-xs">Kosong</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($submissions->hasPages())
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
