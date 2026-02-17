<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('User Management') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Manage all users, roles, and validation status.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.users.create-validator') }}" class="inline-flex items-center px-4 py-2 bg-[#0077B6] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#023E8A] focus:bg-[#023E8A] active:bg-[#03045E] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-blue-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Create Validator') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
        <!-- Filters -->
        <div class="p-5 border-b border-slate-50 bg-[#F8FAFC]/50">
            <form action="{{ route('super-admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." 
                            class="pl-10 block w-full rounded-xl border-slate-200 bg-white focus:border-[#00B4D8] focus:ring focus:ring-[#00B4D8]/20 sm:text-sm shadow-sm transition-all duration-200">
                    </div>
                </div>
                <div class="w-full md:w-48">
                    <select name="role" onchange="this.form.submit()" class="block w-full rounded-xl border-slate-200 bg-white focus:border-[#00B4D8] focus:ring focus:ring-[#00B4D8]/20 sm:text-sm shadow-sm transition-all duration-200">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-48">
                    <select name="status" onchange="this.form.submit()" class="block w-full rounded-xl border-slate-200 bg-white focus:border-[#00B4D8] focus:ring focus:ring-[#00B4D8]/20 sm:text-sm shadow-sm transition-all duration-200">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 tracking-wider">User Info</th>
                        <th class="px-6 py-4 tracking-wider">Role</th>
                        <th class="px-6 py-4 tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 tracking-wider text-center">Bergabung</th>
                        <th class="px-6 py-4 tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/20">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-bold text-[#03045E] group-hover:text-[#0077B6] transition-colors">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                             @forelse($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold capitalize border
                                    {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                       ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                       'bg-sky-50 text-sky-700 border-sky-100') }}">
                                    {{ str_replace('-', ' ', $role->name) }}
                                </span>
                            @empty
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-gray-50 text-gray-600 border border-gray-100 capitalize">
                                    User
                                </span>
                            @endforelse
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_suspended)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-red-50 text-red-600 border border-red-100">
                                    Suspended
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    Active
                                </span>
                            @endif
                        </td>
                         <td class="px-6 py-4 text-center text-xs text-slate-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                           <div class="flex items-center justify-end gap-2">
                                @if($user->id !== 1)
                                    <div class="flex items-center gap-2">
                                        {{-- Only show verification/suspension for non-super-admins --}}
                                        @if(!$user->hasRole('super-admin'))
                                            @if(!$user->hasVerifiedEmail())
                                                <form action="{{ route('super-admin.users.verify-email', $user) }}" method="POST" class="inline" onsubmit="return confirm('Manually verify this user\'s email?');">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-sky-600 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg transition-colors border border-sky-100" title="Manually Verify Email">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endif

                                            @if($user->is_suspended)
                                                <form action="{{ route('super-admin.users.unsuspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors border border-emerald-100">
                                                        Unsuspend
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('super-admin.users.suspend', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to suspend this user?');">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-orange-500 hover:text-orange-700 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-orange-100">
                                                        Suspend
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                        <a href="{{ route('super-admin.users.edit', $user) }}" class="text-xs font-bold text-slate-500 hover:text-[#0077B6] bg-slate-50 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-colors border border-slate-100">
                                            Edit
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('WARNING: Are you sure you want to PERMANENTLY delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Delete User">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-300 italic flex items-center gap-1 justify-end">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Protected Master
                                    </span>
                                @endif
                           </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <p class="text-slate-500 font-medium">No users found.</p>
                                <p class="text-slate-400 text-sm mt-1">Try adjusting your search or filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="p-5 border-t border-slate-50 bg-slate-50/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-layouts.super-admin>
