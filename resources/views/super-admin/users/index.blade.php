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

    <div x-data="{ 
            deleteModalOpen: false, 
            notifyModalOpen: false, 
            suspendModalOpen: false,
            unsuspendModalOpen: false,
            targetUser: null, 
            actionUrl: '',
            
            openDeleteModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.deleteModalOpen = true;
            },
            openNotifyModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.notifyModalOpen = true;
            },
            openSuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.suspendModalOpen = true;
            },
            openUnsuspendModal(user, url) {
                this.targetUser = user;
                this.actionUrl = url;
                this.unsuspendModalOpen = true;
            }
        }" 
        class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
        
        <!-- Filters (Unchanged) -->
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
                            @elseif(is_null($user->email_verified_at))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-50 text-amber-600 border border-amber-100">
                                    Unverified
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
                                        {{-- Actions for non-super-admins --}}
                                        @if(!$user->hasRole('super-admin'))
                                            
                                            {{-- Notify Button --}}
                                            <button @click="openNotifyModal({{ json_encode($user) }}, '{{ route('super-admin.users.notify', $user) }}')" 
                                                class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors border border-indigo-100" title="Send Notification">
                                                Notify
                                            </button>

                                            {{-- Verify Button --}}
                                            @if(!$user->hasVerifiedEmail())
                                                <form action="{{ route('super-admin.users.verify-email', $user) }}" method="POST" class="inline" onsubmit="return confirm('Manually verify this user\'s email?');">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-sky-600 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg transition-colors border border-sky-100" title="Manually Verify Email">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endif

                                            @if($user->is_suspended)
                                                <button @click="openUnsuspendModal({{ json_encode($user) }}, '{{ route('super-admin.users.unsuspend', $user) }}')"
                                                    class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors border border-emerald-100">
                                                    Unsuspend
                                                </button>
                                            @else
                                                <button @click="openSuspendModal({{ json_encode($user) }}, '{{ route('super-admin.users.suspend', $user) }}')"
                                                    class="text-xs font-bold text-orange-500 hover:text-orange-700 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-orange-100">
                                                    Suspend
                                                </button>
                                            @endif
                                        @endif

                                        <a href="{{ route('super-admin.users.edit', $user) }}" class="text-xs font-bold text-slate-500 hover:text-[#0077B6] bg-slate-50 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-colors border border-slate-100">
                                            Edit
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <button @click="openDeleteModal({{ json_encode($user) }}, '{{ route('super-admin.users.destroy', $user) }}')" 
                                                class="text-xs font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Delete User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
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

        <!-- ====== MODALS ====== -->

        <!-- Notification Modal -->
        <div x-show="notifyModalOpen" style="display: none;" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="notifyModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="actionUrl" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                        Send Notification to <span x-text="targetUser?.name" class="font-bold text-indigo-600"></span>
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="subject" class="block text-sm font-medium text-slate-700">Subject</label>
                                            <input type="text" name="subject" required class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Notification Subject">
                                        </div>
                                        <div>
                                            <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                                            <textarea name="message" rows="4" required class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Write your message here..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Send Notification
                            </button>
                            <button type="button" @click="notifyModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="deleteModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                    Delete User Account?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">
                                        Are you sure you want to delete <span x-text="targetUser?.name" class="font-bold text-slate-700"></span>? 
                                        All of their data will be permanently removed. This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="actionUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Yes, Delete Account
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suspend Modal -->
        <div x-show="suspendModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="suspendModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-slate-900">Suspend User?</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">
                                        Are you sure you want to suspend <span x-text="targetUser?.name" class="font-bold"></span>? They will not be able to login until unsuspended.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="actionUrl" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Yes, Suspend
                            </button>
                        </form>
                        <button type="button" @click="suspendModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

           <!-- Unsuspend Modal -->
        <div x-show="unsuspendModalOpen" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="unsuspendModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-slate-900">Unsuspend User?</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">
                                        Are you sure you want to activate <span x-text="targetUser?.name" class="font-bold"></span> again?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="actionUrl" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Yes, Activate
                            </button>
                        </form>
                        <button type="button" @click="unsuspendModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.super-admin>
