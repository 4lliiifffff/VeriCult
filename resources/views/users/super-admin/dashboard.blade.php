<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Selamat datang kembali, Super Admin.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#0077B6] border border-blue-100">
                    <span class="w-2 h-2 rounded-full bg-[#00B4D8] mr-2 animate-pulse"></span>
                    System Live
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-all duration-300 border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-[#0077B6]/10 to-transparent rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total User</p>
                            <h3 class="text-3xl font-extrabold text-[#03045E] mt-2 group-hover:translate-x-1 transition-transform">{{ $totalUsers }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 w-fit px-2 py-1 rounded-md">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span>Aktif</span>
                    </div>
                </div>

                <!-- Suspended Users -->
                <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-all duration-300 border border-slate-100 relative overflow-hidden">
                     <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-red-500/10 to-transparent rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Suspended</p>
                            <h3 class="text-3xl font-extrabold text-[#03045E] mt-2 group-hover:translate-x-1 transition-transform">{{ $suspendedUsersCount }}</h3>
                        </div>
                        <div class="p-3 bg-red-50 rounded-xl text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                     <div class="mt-4 flex items-center text-xs font-medium text-red-600 bg-red-50 w-fit px-2 py-1 rounded-md">
                        <span>Perlu Tindakan</span>
                    </div>
                </div>

                <!-- Role Stats (Dynamic) -->
                @php
                    $roleColors = [
                        'super-admin' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'hover' => 'group-hover:bg-purple-600'],
                        'validator' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'hover' => 'group-hover:bg-indigo-600'],
                        'penulis' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'hover' => 'group-hover:bg-emerald-600'],
                        'default' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'hover' => 'group-hover:bg-slate-600'],
                    ];
                @endphp

                @foreach($usersByRole as $role)
                    @php 
                        $colors = $roleColors[$role->name] ?? $roleColors['default'];
                    @endphp
                    <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-all duration-300 border border-slate-100 relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">{{ str_replace('-', ' ', $role->name) }}</p>
                                <h3 class="text-3xl font-extrabold text-[#03045E] mt-2">{{ $role->users_count }}</h3>
                            </div>
                            <div class="p-3 {{ $colors['bg'] }} {{ $colors['text'] }} rounded-xl {{ $colors['hover'] }} group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Users Table (Width: 2/3) -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
                        <div>
                            <h3 class="text-lg font-bold text-[#03045E]">Pengguna Terbaru</h3>
                            <p class="text-sm text-slate-400 mt-0.5">Daftar pengguna yang baru bergabung.</p>
                        </div>
                        <button class="text-sm font-medium text-[#0077B6] hover:text-[#0096C7] transition-colors bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg">
                            Lihat Semua
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-bold text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <th class="px-6 py-4 tracking-wider">User Info</th>
                                    <th class="px-6 py-4 tracking-wider">Role</th>
                                    <th class="px-6 py-4 tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($recentUsers as $user)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/20">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-[#03045E] group-hover:text-[#0077B6] transition-colors">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                         @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold capitalize border
                                                {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                                   ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                                   'bg-sky-50 text-sky-700 border-sky-100') }}">
                                                {{ str_replace('-', ' ', $role->name) }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-100 capitalize">
                                                {{ str_replace('-', ' ', $user->role ?? 'User') }}
                                            </span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->is_suspended)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-600">Suspended</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-600">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(!$user->hasRole('super-admin'))
                                            @if($user->is_suspended)
                                                <form action="{{ route('users.unsuspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">
                                                        Unsuspend
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.suspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                                        Suspend
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-300 italic">Protected</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada pengguna baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Audit Logs (Width: 1/3) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
                    <div class="p-6 border-b border-slate-50 bg-white">
                        <h3 class="text-lg font-bold text-[#03045E]">Audit Trail</h3>
                        <p class="text-sm text-slate-400 mt-0.5">Aktivitas sistem terkini.</p>
                    </div>
                    <div class="overflow-y-auto max-h-[500px] flex-1">
                        <div class="divide-y divide-slate-50">
                            @forelse($auditLogs as $log)
                            <div class="p-4 hover:bg-slate-50 transition-colors flex items-start space-x-3">
                                <div class="mt-1 flex-shrink-0">
                                    <div class="h-2 w-2 rounded-full ring-2 ring-white
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-blue-400') }}">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 mb-0.5">
                                        <span class="font-bold text-[#03045E]">{{ $log->user->name ?? 'System' }}</span>
                                    </p>
                                    <p class="text-sm font-medium text-slate-700">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1 font-mono bg-slate-50 inline-block px-1 rounded">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    <span class="text-[10px] font-medium text-slate-400 bg-slate-50 px-2 py-1 rounded-full">
                                        {{ $log->created_at->diffForHumans(null, true, true) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="p-8 text-center text-slate-400 text-sm">
                                Belum ada aktivitas tercatat.
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                        <a href="#" class="text-xs font-medium text-[#0077B6] hover:text-[#0096C7]">Lihat Log Lengkap &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
