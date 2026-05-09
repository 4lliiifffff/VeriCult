<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Selamat Datang</h2>
        <p class="text-slate-500 text-sm font-medium">Akses Portal VeriCult Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

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
                       :value="old('email')" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="nama@email.com"
                       class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <div class="flex items-center justify-between ml-1">
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs font-bold text-slate-500 uppercase tracking-widest" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-[#0077B6] hover:text-[#03045E] uppercase tracking-widest transition-colors" href="{{ route('password.request') }}">
                        {{ __('Lupa?') }}
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password" 
                       :type="show ? 'text' : 'password'"
                       name="password"
                       required 
                       autocomplete="current-password" 
                       placeholder="••••••••"
                       class="block w-full pl-12 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 transition-all cursor-pointer">
                <span class="ms-3 text-xs font-bold text-slate-400 uppercase tracking-widest group-hover:text-[#0077B6] transition-colors">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <!-- Action Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs">{{ __('Masuk Portal') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-6">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#0077B6] hover:underline ml-1">Daftar</a>
            </p>
        </div>
    </form>
</x-guest-layout>
