<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-2xl mb-5 shadow-xl shadow-[#00B4D8]/30 transition-transform duration-300 hover:scale-105">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-[#03045E] mb-2">Buat Akun Baru</h2>
        <p class="text-[#64748B]">Bergabung dengan VeriCult untuk verifikasi budaya</p>
    </div>

    <!-- Email Verification Notice -->
    <div class="mb-6 bg-gradient-to-r from-[#E0F2FE] to-[#DBEAFE] border-l-4 border-[#0077B6] p-4 rounded-xl shadow-sm">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-[#0077B6] mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-sm text-[#03045E] font-bold">Verifikasi Email Diperlukan</p>
                <p class="text-xs text-[#475569] mt-1 leading-relaxed">Anda akan menerima email verifikasi setelah mendaftar.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[#023E8A] font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#0096C7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <x-text-input id="name" class="block w-full pl-12 pr-4 py-3 text-[#03045E] bg-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#023E8A] font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#0096C7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-12 pr-4 py-3 text-[#03045E] bg-white" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="mt-2 text-xs text-gray-500 flex items-center">
                <svg class="w-3.5 h-3.5 mr-1.5 text-[#0096C7]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                Gunakan email aktif untuk verifikasi
            </p>
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" class="text-[#023E8A] font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#0096C7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <!-- Input Helper -->
                <div class="absolute inset-y-0 right-12 pr-2 flex items-center pointer-events-none">
                     <span class="text-xs text-gray-400">Min. 8 char</span>
                </div>
                <x-text-input id="password" class="block w-full pl-12 pr-12 py-3 text-[#03045E] bg-white"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="Min. 8 karakter" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-[#0077B6] focus:outline-none transition-colors">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <p class="mt-1 text-xs text-[#475569] flex items-center">
                <svg class="w-3 h-3 mr-1 text-[#0096C7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Gunakan kombinasi huruf besar, kecil & angka
            </p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-[#023E8A] font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#0096C7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="block w-full pl-12 pr-12 py-3 text-[#03045E] bg-white"
                                ::type="show ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Konfirmasi password Anda" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-[#0077B6] focus:outline-none transition-colors">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Agreement -->
        <div class="bg-gradient-to-r from-[#F8FAFC] to-[#F1F5F9] p-4 rounded-xl border border-gray-200">
            <label class="flex items-start cursor-pointer group">
                <input type="checkbox" class="rounded border-gray-300 text-[#0077B6] shadow-sm focus:ring-[#00B4D8] mt-1" required>
                <span class="ms-3 text-sm text-[#475569] leading-relaxed">
                    Saya setuju dengan <a href="#" class="text-[#0077B6] hover:text-[#023E8A] font-semibold transition-colors">Syarat & Ketentuan</a> dan <a href="#" class="text-[#0077B6] hover:text-[#023E8A] font-semibold transition-colors">Kebijakan Privasi</a> VeriCult
                </span>
            </label>
        </div>

        <!-- Register Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-[#0077B6] to-[#00B4D8] hover:from-[#006BA3] hover:to-[#00A3C5] text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 ease-in-out shadow-md hover:shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-[#64748B] font-medium">Sudah punya akun?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full border-2 border-[#0077B6] text-[#023E8A] hover:bg-[#F0F9FF] hover:border-[#0096C7] font-bold py-3.5 px-4 rounded-xl transition-all duration-300 ease-in-out shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Masuk ke Akun') }}
            </a>
        </div>
    </form>

    <!-- Security Badge -->
    <div class="mt-8 pt-6 border-t border-gray-100">
        <div class="flex items-center justify-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-2 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">Data dilindungi dengan enkripsi tingkat tinggi</span>
        </div>
    </div>
</x-guest-layout>
