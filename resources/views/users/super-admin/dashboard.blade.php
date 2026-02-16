<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#03045E] leading-tight">
            {{ __('Dashboard Super Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-blue-50 text-[#0077B6]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-500">Total Pengguna</div>
                                <div class="text-2xl font-bold text-[#03045E]">{{ $totalUsers }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suspended Users -->
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-red-50 text-red-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-500">User Ditangguhkan</div>
                                <div class="text-2xl font-bold text-red-600">{{ $suspendedUsersCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Distribution -->
                @foreach($usersByRole as $role)
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-600' : ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-600' : 'bg-green-50 text-green-600') }}">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-500 capitalize">{{ str_replace('-', ' ', $role->name) }}</div>
                                <div class="text-2xl font-bold text-[#03045E]">{{ $role->users_count }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users Table -->
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-[#03045E]">Pengguna Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Role</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($recentUsers as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-bold text-xs">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-medium text-[#03045E]">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $role->name == 'super-admin' ? 'bg-purple-100 text-purple-800' : ($role->name == 'validator' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800') }}">
                                                {{ str_replace('-', ' ', $role->name) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(!$user->hasRole('super-admin'))
                                            @if($user->is_suspended)
                                                <form action="{{ route('users.unsuspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">Aktifkan</button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.suspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800">Suspend</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Audit Logs Table -->
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                     <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-[#03045E]">Aktivitas Terkini (Audit Log)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Aksi</th>
                                    <th class="px-6 py-4">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($auditLogs as $log)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-700">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono text-slate-600">
                                        {{ $log->action }}
                                        <span class="block text-[10px] text-slate-400">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
