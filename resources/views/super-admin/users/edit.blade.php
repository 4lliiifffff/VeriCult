<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Edit User') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Update user details and permissions.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('super-admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="mt-1 block w-full border-slate-200 focus:border-[#0077B6] focus:ring-4 focus:ring-[#00B4D8]/10 rounded-xl shadow-sm text-slate-700">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <h3 class="text-sm font-medium text-slate-900 mb-4">Change Password (Optional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Leave blank to keep current" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" placeholder="Confirm new password" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4 pt-4 border-t border-slate-100">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#0077B6] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#023E8A] focus:bg-[#023E8A] active:bg-[#03045E] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-blue-500/30">
                            {{ __('Update User') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.super-admin>
