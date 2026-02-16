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

                <!-- New Users -->
                <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-cyan-50 text-[#00B4D8]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-500">Pengguna Baru (Bulan Ini)</div>
                                <div class="text-2xl font-bold text-[#03045E]">{{ $newUsersThisMonth }}</div>
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

            <!-- Recent Users Table -->
            <div class="bg-white overflow-hidden shadow-lg shadow-blue-900/5 rounded-2xl border border-blue-50">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#03045E]">Pengguna Terbaru</h3>
                    <button class="text-sm text-[#0077B6] hover:text-[#023E8A] font-medium transition-colors">Lihat Semua</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                                <th class="px-6 py-4">Status</th>
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
                                        <div class="ml-3 font-medium text-[#03045E]">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $role->name == 'super-admin' ? 'bg-purple-100 text-purple-800' : ($role->name == 'validator' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800') }}">
                                            {{ str_replace('-', ' ', $role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
