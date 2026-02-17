<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Audit Log Detail') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail aktivitas sistem #{{ $auditLog->id }}
                </p>
            </div>
            <div>
                <a href="{{ route('super-admin.audit-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    &larr; {{ __('Back to Logs') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Summary Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
            <div class="p-6 border-b border-slate-50 bg-[#F8FAFC]/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#03045E]">Ringkasan Aktivitas</h3>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                    {{ $auditLog->action == 'created' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 
                       ($auditLog->action == 'deleted' || $auditLog->action == 'suspended_user' ? 'bg-red-50 text-red-600 border border-red-100' : 
                       'bg-blue-50 text-blue-600 border border-blue-100') }}">
                    {{ ucfirst(str_replace('_', ' ', $auditLog->action)) }}
                </span>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Actor Info -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Dilakukan Oleh</p>
                        <p class="text-base font-bold text-[#03045E]">{{ $auditLog->user->name ?? 'System' }}</p>
                        <p class="text-xs text-slate-400">{{ $auditLog->user->email ?? '-' }}</p>
                        <p class="text-xs text-slate-400 mt-1">Role: {{ $auditLog->user ? implode(', ', $auditLog->user->getRoleNames()->toArray()) : '-' }}</p>
                    </div>
                </div>

                <!-- Target Info -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Target Objek</p>
                        <p class="text-base font-bold text-[#03045E]">{{ class_basename($auditLog->model_type) }}</p>
                        <p class="text-xs text-slate-400 font-mono">ID: {{ $auditLog->model_id }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-mono">{{ $auditLog->model_type }}</p>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="flex items-start space-x-4 md:col-span-2 border-t border-slate-50 pt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 w-full gap-4">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Waktu Kejadian</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $auditLog->created_at->format('d M Y, H:i:s') }}</p>
                            <p class="text-xs text-slate-400">{{ $auditLog->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500">IP Address</p>
                            <p class="text-sm font-semibold text-slate-700 font-mono">{{ $auditLog->ip_address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500">User Agent</p>
                            <p class="text-xs text-slate-600 break-all">{{ $auditLog->user_agent ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Changes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <!-- Old Data -->
             <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
                <div class="p-4 border-b border-slate-50 bg-red-50/30">
                    <h3 class="text-sm font-bold text-red-600">Data Sebelumnya (Old)</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    @if($auditLog->old_data)
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-slate-50">
                                @foreach($auditLog->old_data as $key => $value)
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-4 py-3 font-medium text-slate-500 w-1/3 font-mono text-xs">{{ $key }}</td>
                                        <td class="px-4 py-3 text-slate-700 break-all font-mono text-xs">
                                            @if(is_array($value))
                                                <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6 text-center text-slate-400 italic text-sm">
                            Tidak ada data lama (Create Action atau tidak tercatat)
                        </div>
                    @endif
                </div>
            </div>

            <!-- New Data -->
             <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
                <div class="p-4 border-b border-slate-50 bg-emerald-50/30">
                    <h3 class="text-sm font-bold text-emerald-600">Data Baru (New)</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    @if($auditLog->new_data)
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-slate-50">
                                @foreach($auditLog->new_data as $key => $value)
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-4 py-3 font-medium text-slate-500 w-1/3 font-mono text-xs">{{ $key }}</td>
                                        <td class="px-4 py-3 text-slate-700 break-all font-mono text-xs">
                                            @if(is_array($value))
                                                <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                     @else
                        <div class="p-6 text-center text-slate-400 italic text-sm">
                             Tidak ada data baru (Delete Action atau tidak tercatat)
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
