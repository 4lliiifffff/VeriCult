<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-slate-500  mt-1">Selamat datang kembali, Super Admin.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#0077B6] border border-blue-100">
                    <span class="w-2 h-2 rounded-full bg-[#00B4D8] mr-2 animate-pulse"></span>
                    System Live
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-[#F8FAFC] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Users -->
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-[#0077B6]/5 to-transparent rounded-full blur-2xl"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total User</p>
                            <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <div class="p-2.5 bg-blue-50/50 rounded-xl text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Suspended Users -->
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                     <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-red-500/5 to-transparent rounded-full blur-2xl"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Suspended</p>
                            <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $suspendedUsersCount }}</h3>
                        </div>
                        <div class="p-2.5 bg-red-50/50 rounded-xl text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Unverified Users -->
                <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                     <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-amber-500/5 to-transparent rounded-full blur-2xl"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unverified</p>
                            <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $unverifiedUsersCount }}</h3>
                        </div>
                        <div class="p-2.5 bg-amber-50/50 rounded-xl text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Role Stats (Dynamic) -->
                @php
                    $roleColors = [
                        'super-admin' => ['bg' => 'bg-purple-50/50', 'text' => 'text-purple-600', 'hover' => 'group-hover:bg-purple-600'],
                        'validator' => ['bg' => 'bg-indigo-50/50', 'text' => 'text-indigo-600', 'hover' => 'group-hover:bg-indigo-600'],
                        'penulis' => ['bg' => 'bg-emerald-50/50', 'text' => 'text-emerald-600', 'hover' => 'group-hover:bg-emerald-600'],
                        'pengusul' => ['bg' => 'bg-sky-50/50', 'text' => 'text-sky-600', 'hover' => 'group-hover:bg-sky-600'],
                        'default' => ['bg' => 'bg-slate-50/50', 'text' => 'text-slate-600', 'hover' => 'group-hover:bg-slate-600'],
                    ];
                @endphp

                @foreach($usersByRole as $role)
                    @php 
                        $colors = $roleColors[$role->name] ?? $roleColors['default'];
                    @endphp
                    <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ str_replace('-', ' ', $role->name) }}</p>
                                <h3 class="text-2xl font-black text-[#0077B6] mt-1">{{ $role->users_count }}</h3>
                            </div>
                            <div class="p-2.5 {{ $colors['bg'] }} {{ $colors['text'] }} rounded-xl {{ $colors['hover'] }} group-hover:text-white transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Live User Monitoring -->
            <div x-data="{
                    onlineUsers: {{ json_encode($onlineUsers) }},
                    loading: false,
                    
                    async fetchOnlineUsers() {
                        try {
                            const response = await fetch('{{ route('super-admin.api.online-users') }}');
                            this.onlineUsers = await response.json();
                        } catch (error) {
                            console.error('Failed to fetch online users:', error);
                        }
                    },
                    
                    init() {
                        // Auto-refresh every 5 seconds
                        setInterval(() => {
                            this.fetchOnlineUsers();
                        }, 5000);
                    }
                }" 
                class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 overflow-hidden relative">
                 <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-base font-bold text-[#03045E] flex items-center gap-2">
                             <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            Live User Monitoring
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Real-time user activity tracking (Auto-refresh every 5 seconds).</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                             <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/30 border-b border-slate-100">
                                <th class="px-5 py-3 tracking-wider">User</th>
                                <th class="px-5 py-3 tracking-wider">Role</th>
                                <th class="px-5 py-3 tracking-wider">Current Page</th>
                                <th class="px-5 py-3 tracking-wider text-center">Last Activity</th>
                                <th class="px-5 py-3 tracking-wider text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <template x-if="onlineUsers.length > 0">
                                <template x-for="online in onlineUsers" :key="online.id">
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-sm text-[#03045E]" x-text="online.name"></div>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span class="text-[10px] font-semibold uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded" x-text="online.role.replace('-', ' ')"></span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-mono text-slate-600 truncate max-w-[300px]" x-text="online.current_url" :title="online.current_url"></span>
                                                <span class="text-[10px] text-slate-400 font-bold" x-text="online.method"></span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-center text-xs text-slate-500">
                                            <span x-text="online.last_activity_human"></span>
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            <span x-show="online.status === 'Online'" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                Online
                                            </span>
                                            <span x-show="online.status !== 'Online'" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-600 border border-amber-100">
                                                Idle
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="onlineUsers.length === 0">
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-xs text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            No active users found at the moment.
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Users Table (Width: 2/3) -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
                    <div class="p-5 border-b border-slate-50 flex justify-between items-center bg-white">
                        <div>
                            <h3 class="text-base font-bold text-[#03045E]">Pengguna Terbaru</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Daftar pengguna yang baru bergabung.</p>
                        </div>
                        <a href="{{ route('super-admin.users.index') }}" class="text-xs font-medium text-[#0077B6] hover:text-[#0096C7] transition-colors bg-blue-50/50 hover:bg-blue-100 px-3 py-1.5 rounded-lg">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/30 border-b border-slate-100">
                                    <th class="px-5 py-3 tracking-wider">User Info</th>
                                    <th class="px-5 py-3 tracking-wider">Role</th>
                                    <th class="px-5 py-3 tracking-wider text-center">Status</th>
                                    <th class="px-5 py-3 tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($recentUsers as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-bold text-xs shadow-sm shadow-blue-500/10">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-bold text-sm text-[#03045E] group-hover:text-[#0077B6] transition-colors">{{ $user->name }}</div>
                                                <div class="text-[11px] text-slate-400">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                         @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold capitalize border
                                                {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                                   ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                                   'bg-sky-50 text-sky-700 border-sky-100') }}">
                                                {{ str_replace('-', ' ', $role->name) }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-50 text-gray-600 border border-gray-100 capitalize">
                                                {{ str_replace('-', ' ', $user->role ?? 'User') }}
                                            </span>
                                        @endforelse
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        @if($user->is_suspended)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-600">Suspended</span>
                                        @elseif(is_null($user->email_verified_at))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-600">Unverified</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-600">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        @if(!$user->hasRole('super-admin'))
                                            @if($user->is_suspended)
                                                <form action="{{ route('users.unsuspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded-md transition-colors">
                                                        Unsuspend
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.suspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-[10px] font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-2.5 py-1 rounded-md transition-colors">
                                                        Suspend
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-[10px] text-slate-300 italic flex items-center gap-1 justify-end">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Protected
                                    </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-400 text-xs">Belum ada pengguna baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Audit Logs (Width: 1/3) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden flex flex-col h-full">
                    <div class="p-5 border-b border-slate-50 bg-white">
                        <h3 class="text-base font-bold text-[#03045E]">Audit Trail</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Aktivitas sistem terkini.</p>
                    </div>
                    <div class="overflow-y-auto max-h-[500px] flex-1">
                        <div class="divide-y divide-slate-50">
                            @forelse($auditLogs as $log)
                            <div class="p-3.5 hover:bg-slate-50 transition-colors flex items-start space-x-3">
                                <div class="mt-1 flex-shrink-0">
                                    <div class="h-1.5 w-1.5 rounded-full ring-2 ring-white
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-blue-400') }}">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[11px] text-slate-500 mb-0.5">
                                        <span class="font-bold text-[#03045E]">{{ $log->user->name ?? 'System' }}</span>
                                    </p>
                                    <p class="text-xs font-medium text-slate-700">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-mono bg-slate-50 inline-block px-1 rounded">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    <span class="text-[10px] font-medium text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded-full">
                                        {{ $log->created_at->diffForHumans(null, true, true) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="p-6 text-center text-slate-400 text-xs">
                                Belum ada aktivitas tercatat.
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                        <a href="{{ route('super-admin.audit-logs.index') }}" class="text-[10px] font-medium text-[#0077B6] hover:text-[#0096C7]">Lihat Log Lengkap &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
