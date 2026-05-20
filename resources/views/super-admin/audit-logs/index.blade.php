<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Audit Trail</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Log Audit
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Sistem Log Monitoring</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Audit <span class="text-[#0077B6]">Trail Sistem</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Pantau setiap perubahan data, aktivitas pengguna, dan integritas sistem secara real-time.</p>
                </div>
                    
                <div class="flex items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-[2rem] border border-slate-100 shadow-inner w-fit self-start md:self-auto">
                    <div class="h-10 sm:h-12 px-5 sm:px-6 bg-white rounded-2xl flex items-center gap-3 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                        <span class="text-[9px] sm:text-[11px] font-black text-[#03045E] uppercase tracking-widest whitespace-nowrap">Live Monitoring</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group/trail mb-12">
        <!-- Search Area -->
        <div class="p-6 sm:p-8 border-b border-slate-50 bg-white">
            <form action="{{ route('super-admin.audit-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan user, aksi, atau detail log..." 
                            class="pl-12 block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-medium">
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max responsive-table">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Pelaku</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Aksi Sistem</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Target Objek</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Waktu & IP</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/30 transition-all duration-200 group/row">
                        <td class="px-6 sm:px-8 py-4 sm:py-5">
                            <div class="flex items-center">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center font-black text-[10px] sm:text-xs group-hover/row:bg-[#03045E] group-hover/row:text-white transition-all duration-300 shadow-sm border border-slate-100/50">
                                    {{ substr($log->user?->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/row:text-[#0077B6] transition-colors line-clamp-1 break-words max-w-[120px] sm:max-w-none">{{ $log->user?->name ?? 'System Process' }}</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-widest font-black">{{ $log->user?->roles?->first()?->name ?? 'CORE' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5">
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-50 text-[#0077B6] border border-blue-100">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5">
                            <div class="text-[11px] sm:text-xs font-bold text-slate-500 whitespace-nowrap">
                                <span class="text-slate-400 font-medium">{{ class_basename($log->model_type) }}</span> <span class="text-[#00B4D8] ml-1">#{{ $log->model_id }}</span>
                            </div>
                        </td>
                         <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                            <div class="text-[11px] sm:text-xs font-black text-[#03045E] whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $log->ip_address }} • {{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                           <a href="{{ route('super-admin.audit-logs.show', $log) }}" class="inline-flex items-center px-4 py-2 bg-slate-50 hover:bg-[#03045E] text-slate-400 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border border-slate-100 group/btn shadow-sm">
                               Details
                               <svg class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                           </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-slate-200">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Belum ada rekaman audit terdeteksi.</p>
                                    <p class="text-slate-300 text-[10px] uppercase tracking-[0.1em]">Aktivitas sistem akan muncul di sini.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Area -->
        @if($logs->hasPages())
        <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</x-layouts.super-admin>
