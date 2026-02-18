<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-3xl mb-6 shadow-2xl shadow-blue-900/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Atur Ulang <span class="text-[#0077B6]">Sandi</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Amankan Kembali Akses Akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-8">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email Terdaftar')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-14 pr-5 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="alamat@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }" class="group">
            <x-input-label for="password" :value="__('Sandi Baru')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-14 pr-14 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="Masukkan sandi baru" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ show: false }" class="group">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="block w-full pl-14 pr-14 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium"
                                ::type="show ? 'text' : 'password'"
                                name="password_confirmation" 
                                required autocomplete="new-password" 
                                placeholder="Ulangi sandi baru" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-gradient-to-br from-[#03045E] to-[#0077B6] hover:shadow-2xl hover:shadow-blue-900/40 text-white font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/20 flex items-center justify-center group active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <span class="uppercase tracking-[0.2em] text-xs">{{ __('Simpan Sandi Baru') }}</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </button>
        </div>
    </form>

    <!-- Security Badge -->
    <div class="mt-12 pt-8 border-t border-slate-50">
        <div class="flex items-center justify-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
            <svg class="w-4 h-4 mr-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>Verified Security Protocol</span>
        </div>
    </div>
</x-guest-layout>
