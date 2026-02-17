<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Audit Logs') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Track all system activities and user actions.</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
        <!-- Filters -->
        <div class="p-5 border-b border-slate-50 bg-[#F8FAFC]/50">
            <form action="{{ route('super-admin.audit-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user, action, or details..." 
                            class="pl-10 block w-full rounded-xl border-slate-200 bg-white focus:border-[#00B4D8] focus:ring focus:ring-[#00B4D8]/20 sm:text-sm shadow-sm transition-all duration-200">
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 tracking-wider">User</th>
                        <th class="px-6 py-4 tracking-wider">Action</th>
                        <th class="px-6 py-4 tracking-wider">Target</th>
                        <th class="px-6 py-4 tracking-wider">Timestamp</th>
                        <th class="px-6 py-4 tracking-wider text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs">
                                    {{ substr($log->user->name ?? 'System', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="font-bold text-sm text-[#03045E]">{{ $log->user->name ?? 'System' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $log->ip_address }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                             <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-[#0077B6] border border-blue-100 capitalize">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-500">
                            {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                        </td>
                         <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $log->created_at->format('d M Y H:i:s') }}
                            <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                           <button class="text-xs font-bold text-slate-400 hover:text-[#0077B6] transition-colors" title="View Details">
                               Show Data
                           </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">
                            No audit logs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="p-5 border-t border-slate-50 bg-slate-50/30">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</x-layouts.super-admin>
