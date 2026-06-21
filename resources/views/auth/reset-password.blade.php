<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Atur Ulang Sandi</h2>
        <p class="text-slate-500 text-sm font-medium">Amankan kembali akses akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       :value="old('email', $request->email)" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="nama@email.com"
                       class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-6" x-data="{ showPass: false, showConfirm: false }">
            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Sandi Baru')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input id="password" 
                           :type="showPass ? 'text' : 'password'"
                           name="password"
                           required 
                           autocomplete="new-password" 
                           placeholder="Min. 8 char"
                           class="block w-full pl-12 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    <button type="button" @click="showPass = !showPass" :aria-label="showPass ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi'" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showPass" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <input id="password_confirmation" 
                           :type="showConfirm ? 'text' : 'password'"
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" 
                           placeholder="Ulangi sandi baru"
                           class="block w-full pl-12 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    <button type="button" @click="showConfirm = !showConfirm" :aria-label="showConfirm ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi'" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showConfirm" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Action Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs font-bold">{{ __('Simpan Sandi Baru') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
