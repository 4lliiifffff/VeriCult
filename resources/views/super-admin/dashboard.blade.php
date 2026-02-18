<x-layouts.super-admin>
    <x-slot name="header">
        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                            Super Admin
                        </span>
                        <span class="text-white/30 text-xs">|</span>
                        <span class="text-white/60 text-xs font-bold uppercase tracking-widest">VeriCult Core</span>
                    </div>
                    <h2 class="text-4xl font-black text-white tracking-tight leading-tight">
                        Dashboard <span class="text-[#00B4D8]">Overview</span>
                    </h2>
                    <p class="text-blue-100/70 text-lg font-medium">Selamat datang kembali di pusat kendali utama sistem.</p>
                </div>
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner">
                    <div class="w-12 h-12 rounded-xl bg-[#00B4D8] flex items-center justify-center text-[#03045E] shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#00B4D8] uppercase tracking-[0.2em] mb-0.5">System Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-white font-black text-sm">LIVE & OPERATIONAL</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-[#0077B6]/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Entitas</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">{{ $totalUsers }}</h3>
                        <div class="mt-4 flex items-center gap-2 text-emerald-500 font-bold text-xs bg-emerald-50 w-fit px-2 py-1 rounded-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            <span>{{ $newUsersThisMonth }} Baru</span>
                        </div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Suspended Users -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Ditangguhkan</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">{{ $suspendedUsersCount }}</h3>
                        <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Review dibutuhkan</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Unverified Users -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Menunggu Verifikasi</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">{{ $unverifiedUsersCount }}</h3>
                        <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Email pending</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Role Distribution Summary -->
            <div class="group bg-[#03045E] rounded-[2rem] p-8 shadow-xl shadow-[#03045E]/30 border border-white/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 text-white">
                    <p class="text-xs font-black text-white/40 uppercase tracking-[0.2em] mb-4">Distribusi Peran</p>
                    <div class="space-y-3">
                        @foreach($usersByRole as $role)
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/70 capitalize">{{ str_replace('-', ' ', $role->name) }}</span>
                            <span class="text-sm font-black text-[#00B4D8]">{{ $role->users_count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Monitoring Section -->
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
                    setInterval(() => {
                        this.fetchOnlineUsers();
                    }, 5000);
                }
            }" 
            class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
            
            <div class="p-8 sm:p-10 border-b border-slate-50 relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-black text-[#03045E] flex items-center gap-3">
                            <span class="w-2.5 h-8 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_15px_rgba(16,185,129,0.5)]"></span>
                            Live Monitoring
                        </h3>
                        <p class="text-slate-400 font-medium text-sm mt-1">Pantau aktivitas pengguna secara real-time di seluruh platform.</p>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 px-5 py-2.5 rounded-2xl border border-slate-100">
                        <svg class="w-4 h-4 text-[#0077B6] animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Auto-Refresh: <span class="text-[#03045E]">5s</span></span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                         <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5">Identitas User</th>
                            <th class="px-8 py-5">Peran</th>
                            <th class="px-8 py-5">Lokasi Halaman</th>
                            <th class="px-8 py-5 text-center">Aktivitas Terakhir</th>
                            <th class="px-8 py-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-if="onlineUsers.length > 0">
                            <template x-for="online in onlineUsers" :key="online.id">
                                <tr class="hover:bg-slate-50/50 transition-all duration-200 group/row">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-xs shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform" x-text="online.name.substring(0, 2).toUpperCase()"></div>
                                            <div class="font-bold text-sm text-[#03045E]" x-text="online.name"></div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100/50 px-3 py-1 rounded-full border border-slate-200" x-text="online.role.replace('-', ' ')"></span>
                                    </td>
                                    <td class="px-8 py-5 text-xs">
                                        <div class="flex flex-col gap-1 max-w-xs xl:max-w-md">
                                            <span class="font-mono text-slate-500 truncate group-hover/row:text-[#0077B6]" x-text="online.current_url" :title="online.current_url"></span>
                                            <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest" x-text="online.method"></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center text-xs font-bold text-slate-400">
                                        <span x-text="online.last_activity_human"></span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span x-show="online.status === 'Online'" class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Online
                                        </span>
                                        <span x-show="online.status !== 'Online'" class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                            Idle
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                        <template x-if="onlineUsers.length === 0">
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-bold tracking-wide">Sistem sedang tenang.</p>
                                            <p class="text-slate-300 text-xs mt-1">Tidak ada pengguna aktif dalam 5 menit terakhir.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Recent Users Table (Width: 2/3) -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <div class="p-8 sm:p-10 border-b border-slate-50 flex flex-wrap justify-between items-center gap-6 bg-white">
                    <div>
                        <h3 class="text-2xl font-black text-[#03045E]">Pengguna Terbaru</h3>
                        <p class="text-slate-400 font-medium text-sm mt-1">Entitas yang baru saja terdaftar di sistem.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group">
                        Daftar Lengkap
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5">Profil User</th>
                                <th class="px-8 py-5">Role</th>
                                <th class="px-8 py-5 text-center">Status Akun</th>
                                <th class="px-8 py-5 text-right">Opsi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentUsers as $user)
                            <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="h-11 w-11 rounded-[14px] bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-black text-sm shadow-md group-hover/u:scale-110 transition-transform">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-bold text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors line-clamp-1">{{ $user->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                     @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border
                                            {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                               ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                               'bg-sky-50 text-sky-700 border-sky-100') }}">
                                            {{ str_replace('-', ' ', $role->name) }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                                    @endforelse
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($user->is_suspended)
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100">Suspended</span>
                                    @elseif(is_null($user->email_verified_at))
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">Unverified</span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Active</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if(!$user->hasRole('super-admin'))
                                        <div class="flex items-center justify-end gap-2">
                                            @if($user->is_suspended)
                                                <form action="{{ route('super-admin.users.unsuspend', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('super-admin.users.suspend', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-300 font-bold uppercase tracking-widest flex items-center gap-1 justify-end">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Locked
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold italic">Belum ada pengguna baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail (Width: 1/3) -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden flex flex-col h-full group">
                <div class="p-8 border-b border-slate-50 bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-[#03045E]">Audit Trail</h3>
                        <p class="text-slate-400 font-medium text-xs mt-1">Jejak aktivitas sistem terenkripsi.</p>
                    </div>
                </div>
                <div class="overflow-y-auto max-h-[600px] flex-1 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                    <div class="p-4 space-y-4">
                        @forelse($auditLogs as $log)
                        <div class="group/log p-5 rounded-2xl bg-white border border-slate-100 hover:border-[#0077B6]/30 hover:shadow-lg hover:shadow-slate-200/50 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex-shrink-0 relative">
                                    <div class="h-3 w-3 rounded-full ring-4 ring-white shadow-sm
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-[#0077B6]') }}">
                                    </div>
                                    <div class="absolute inset-0 rounded-full animate-ping opacity-20
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-[#0077B6]') }}">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-[11px] font-black text-[#03045E] truncate pr-2">{{ $log->user->name ?? 'SYSTEM EVENT' }}</p>
                                        <span class="flex-shrink-0 text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $log->created_at->diffForHumans(null, true, true) }}</span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-600 leading-tight">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </p>
                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-[9px] font-black text-[#0077B6] bg-blue-50 px-2 py-0.5 rounded uppercase tracking-wider">
                                            {{ class_basename($log->model_type) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-300">#{{ $log->model_id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center space-y-4">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl mx-auto flex items-center justify-center text-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-slate-300 font-bold text-xs uppercase tracking-widest">Aktivitas Nihil</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100 text-center">
                    <a href="{{ route('super-admin.audit-logs.index') }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:text-[#03045E] transition-colors">
                        Jelajahi Log &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
