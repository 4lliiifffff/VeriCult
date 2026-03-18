<x-layouts.pengusul-desa>
    <x-slot name="header">
        
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Laporan Statistik</span>
        </nav>

        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Kelola Statistik
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Laporan <span class="text-[#00B4D8]">Statistik</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium break-words">Pantau dan kelola data statistik kebudayaan dari 11 kategori OPK di wilayah Anda.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-3 sm:p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto mt-4 md:mt-0">
                    <a href="{{ route('pengusul-desa.statistic-submissions.create') }}" class="w-full md:w-auto justify-center bg-white text-[#03045E] px-4 sm:px-6 py-3 rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-[#0077B6] rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Draft & Revisi</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->filter(fn($s) => $s->isEditable())->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telah Diverifikasi</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->where('status', \App\Models\CulturalSubmission::STATUS_VERIFIED)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions Central Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative group">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-xl text-[#03045E]">Riwayat Statistik</h3>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Update Real-time</span>
                </div>
            </div>

            <div class="overflow-x-auto px-4 pb-4 -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                                <th class="px-6 py-5">Nama Laporan</th>
                                <th class="px-6 py-5">Kategori</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-6 py-5 text-center">Tgl. Lapor</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/60">
                            @forelse($submissions as $submission)
                            <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-[#0077B6] group-hover/row:scale-110 transition-transform duration-300 font-bold text-sm">
                                            {{ substr($submission->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-[15px] text-[#03045E] group-hover/row:text-[#0077B6] transition-colors line-clamp-1">{{ $submission->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-0.5">STAT-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-[#0077B6] text-[11px] font-bold tracking-wide border border-blue-100/50">
                                        {{ $submission->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $colors = [
                                            'gray' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'amber' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'green' => 'bg-green-50 text-green-600 border-green-100',
                                            'red' => 'bg-red-50 text-red-600 border-red-100',
                                        ];
                                        $colorClass = $colors[$submission->status_color] ?? $colors['gray'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $colorClass }} border shadow-sm">
                                        {{ $submission->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center text-[13px] font-medium text-slate-500">
                                    {{ $submission->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('pengusul-desa.statistic-submissions.show', $submission) }}" 
                                           class="group/btn p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#0077B6] hover:text-white transition-all duration-300"
                                           title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        @if($submission->isEditable())
                                        <a href="{{ route('pengusul-desa.statistic-submissions.edit', $submission) }}" 
                                           class="group/btn p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-amber-500 hover:text-white transition-all duration-300"
                                           title="Edit Laporan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-32 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-32 h-32 bg-blue-50 rounded-[2.5rem] flex items-center justify-center mb-8 relative">
                                            <svg class="w-16 h-16 text-[#0077B6]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                            <div class="absolute inset-0 border-2 border-dashed border-[#0077B6]/20 rounded-[2.5rem] animate-pulse"></div>
                                        </div>
                                        <h4 class="text-2xl font-black text-[#03045E] mb-2 tracking-tight">Belum Ada Laporan</h4>
                                        <p class="text-slate-400 text-sm font-medium mb-10 leading-relaxed">
                                            Sepertinya Anda belum memiliki riwayat laporan statistik kebudayaan. Mari buat laporan pertama Anda sekarang!
                                        </p>
                                        <a href="{{ route('pengusul-desa.statistic-submissions.create') }}" 
                                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white text-sm font-black rounded-2xl shadow-xl shadow-blue-900/20 border-b-4 border-[#023A8A] hover:scale-105 active:scale-95 transition-all">
                                            <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            Buat Laporan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($submissions->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                <div class="flex flex-col items-center justify-center">
                    {{ $submissions->links() }}
                </div>
            </div>
            @endif
        </div>

    </x-slot>
</x-layouts.pengusul-desa>
