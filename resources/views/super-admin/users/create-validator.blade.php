<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Create New Validator') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Register a new expert validator to the platform.</p>
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
            <form action="{{ route('super-admin.users.store-validator') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus placeholder="e.g. Dr. Budi Santoso" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required placeholder="email@institution.ac.id" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" :value="__('Password (Optional)')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Leave blank to auto-generate" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" placeholder="Confirm password" />
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                        <label for="email_verified" class="inline-flex items-center">
                            <input id="email_verified" type="checkbox" class="rounded border-slate-300 text-[#00B4D8] shadow-sm focus:ring-[#00B4D8]" name="email_verified" value="1" checked>
                            <span class="ml-2 text-sm text-slate-600">{{ __('Mark Email as Verified Immediately') }}</span>
                        </label>
                        <p class="text-xs text-slate-400 mt-1 ml-6">If checked, the user will surpass email verification step.</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#0077B6] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#023E8A] focus:bg-[#023E8A] active:bg-[#03045E] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-blue-500/30">
                            {{ __('Create Validator Account') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.super-admin>
