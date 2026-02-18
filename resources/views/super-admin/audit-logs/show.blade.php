<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.audit-logs.index') }}" class="hover:text-[#0077B6] transition-colors">Log Audit</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Aktivitas</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="font-black text-3xl text-[#03045E] leading-tight tracking-tight">
                    Detail <span class="text-[#0077B6]">Aktivitas Sistem</span>
                </h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Record unik ID #{{ $auditLog->id }} — Pelacakan rekaman data secara mendalam.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.audit-logs.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm shadow-slate-200/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Log
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Top Summary Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Action Card -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                <div class="relative">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Tindakan</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center 
                            {{ $auditLog->action == 'created' ? 'bg-emerald-50 text-emerald-500 shadow-emerald-200/50' : 
                               ($auditLog->action == 'deleted' || $auditLog->action == 'suspended_user' ? 'bg-rose-50 text-rose-500 shadow-rose-200/50' : 
                               'bg-blue-50 text-blue-500 shadow-blue-200/50') }} shadow-lg border border-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($auditLog->action == 'created')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                @elseif($auditLog->action == 'deleted')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                @endif
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black text-[#03045E] block capitalize leading-none">{{ str_replace('_', ' ', $auditLog->action) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2 block">Status Operasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multi-Meta Card (Actor & Object) -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8 overflow-hidden relative group">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-50">
                    <!-- Actor -->
                    <div class="flex items-start gap-5">
                        <div class="h-14 w-14 rounded-2xl bg-[#03045E] flex items-center justify-center shadow-lg shadow-blue-900/20 order-last md:order-first">
                             <span class="text-xl font-black text-white uppercase">{{ substr($auditLog->user->name ?? 'S', 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pelaku Sistem</h3>
                            <p class="text-lg font-black text-[#03045E] line-clamp-1">{{ $auditLog->user->name ?? 'System Process' }}</p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter mt-1">{{ $auditLog->user->roles->first()->name ?? 'Core Service' }}</p>
                        </div>
                    </div>
                    <!-- Target -->
                    <div class="flex items-start gap-5 pt-8 md:pt-0 md:pl-8">
                        <div class="h-14 w-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[#00B4D8] order-last md:order-first">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Target Objek</h3>
                            <p class="text-lg font-black text-[#03045E]">{{ class_basename($auditLog->model_type) }}</p>
                            <p class="text-xs text-[#0077B6] font-bold mt-1">ID Terkait: #{{ $auditLog->model_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meta Details Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Waktu Kejadian</p>
                <p class="text-sm font-black text-[#03045E]">{{ $auditLog->created_at->format('d M Y, H:i:s') }}</p>
                <p class="text-[11px] text-slate-400 font-bold mt-1">{{ $auditLog->created_at->diffForHumans() }}</p>
            </div>
            <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat IP</p>
                <p class="text-sm font-black text-[#03045E] font-mono tracking-tight">{{ $auditLog->ip_address ?? '::1' }}</p>
                <p class="text-[11px] text-slate-400 font-bold mt-1">Network Source</p>
            </div>
            <div class="md:col-span-2 bg-slate-50 rounded-[2rem] p-6 border border-slate-100 overflow-hidden relative group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">User Agent (Browser & OS)</p>
                <p class="text-[11px] font-bold text-slate-600 line-clamp-2 leading-relaxed">{{ $auditLog->user_agent ?? 'Internal API / Console' }}</p>
                <div class="absolute top-4 right-4 text-slate-200">
                    <svg class="w-10 h-10 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Data Changes Comparison -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
            <!-- OLD DATA -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden flex flex-col">
                <div class="px-8 py-6 bg-rose-50/50 border-b border-rose-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-rose-600 uppercase tracking-[0.2em]">State Sebelumnya</h3>
                        <p class="text-[11px] text-rose-400 font-bold mt-0.5 uppercase tracking-tighter italic">Snapshot data sebelum perubahan</p>
                    </div>
                </div>
                <div class="flex-1 overflow-x-auto min-h-[300px]">
                    @if($auditLog->old_data)
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase bg-slate-50/30 border-b border-rose-50">
                                    <th class="px-8 py-4 w-1/3">Key Field</th>
                                    <th class="px-8 py-4">Original Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium font-mono text-xs">
                                @foreach($auditLog->old_data as $key => $value)
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-8 py-4 text-rose-500 font-bold">{{ $key }}</td>
                                        <td class="px-8 py-4 text-slate-600 break-all leading-relaxed bg-slate-50/20">
                                            @if(is_array($value))
                                                <pre class="bg-slate-900 text-slate-300 p-4 rounded-xl text-[10px]">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $value ?? 'NULL' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="h-full flex flex-col items-center justify-center p-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Tidak Ada Data</p>
                            <p class="text-[11px] text-slate-300 font-black mt-1 uppercase tracking-tighter">(Tindakan Pembuatan Baru)</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- NEW DATA -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden flex flex-col">
                <div class="px-8 py-6 bg-emerald-50/50 border-b border-emerald-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-emerald-600 uppercase tracking-[0.2em]">State Terbaru</h3>
                        <p class="text-[11px] text-emerald-400 font-bold mt-0.5 uppercase tracking-tighter italic">Snapshot data setelah diolah sistem</p>
                    </div>
                </div>
                <div class="flex-1 overflow-x-auto min-h-[300px]">
                    @if($auditLog->new_data)
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase bg-slate-50/30 border-b border-emerald-50">
                                    <th class="px-8 py-4 w-1/3">Key Field</th>
                                    <th class="px-8 py-4">Processed Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium font-mono text-xs">
                                @foreach($auditLog->new_data as $key => $value)
                                    <tr class="hover:bg-emerald-50/20 transition-colors group/new">
                                        <td class="px-8 py-4 text-emerald-600 font-bold group-hover/new:translate-x-1 transition-transform inline-block">{{ $key }}</td>
                                        <td class="px-8 py-4 text-slate-600 break-all leading-relaxed bg-slate-50/20">
                                            @if(is_array($value))
                                                <pre class="bg-slate-900 text-slate-300 p-4 rounded-xl text-[10px]">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $value ?? 'NULL' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="h-full flex flex-col items-center justify-center p-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Tidak Ada Data</p>
                            <p class="text-[11px] text-slate-300 font-black mt-1 uppercase tracking-tighter">(Tindakan Penghapusan Data)</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
