<section x-data="{ 
    submitForm() {
        this.$refs.profileForm.submit();
    }
}">
    <header class="flex items-center gap-4 mb-8">
        <div class="p-3 rounded-2xl bg-blue-50 text-[#0077B6]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#03045E]">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-7" x-ref="profileForm">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-7 pt-4">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold ml-1" />
                <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-semibold ml-1" />
                <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-100">
                        <p class="text-sm text-amber-800">
                            {{ __('Alamat email Anda belum diverifikasi.') }}

                            <button form="send-verification" class="ml-1 underline text-sm text-amber-600 hover:text-amber-700 font-medium focus:outline-none transition-colors">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-semibold text-sm text-green-600">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
            <button type="button" x-on:click="$dispatch('open-modal', 'confirm-profile-update')" class="inline-flex items-center px-6 py-3 bg-[#03045E] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-[#023E8A] focus:bg-[#023E8A] active:bg-[#03045E] focus:outline-none focus:ring-2 focus:ring-[#00B4D8] focus:ring-offset-2 transition-all duration-300 shadow-lg shadow-blue-900/10 active:scale-[0.98]">
                {{ __('Simpan Perubahan') }}
            </button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-profile-update" :show="false" focusable>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-blue-50 rounded-2xl text-[#0077B6]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#03045E]">
                        {{ __('Konfirmasi Perubahan') }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('Simpan perubahan profil?') }}
                    </p>
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                {{ __('Apakah Anda yakin ingin menyimpan perubahan pada profil Anda? Data akan diperbarui setelah Anda menekan tombol simpan.') }}
            </p>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm tracking-widest uppercase hover:bg-slate-50 transition-all duration-300">
                    {{ __('Batal') }}
                </button>

                <button type="button" x-on:click="submitForm" class="px-6 py-3 rounded-xl bg-[#03045E] text-white font-bold text-sm tracking-widest uppercase hover:bg-[#023E8A] transition-all duration-300 shadow-lg shadow-blue-900/20 active:scale-[0.98]">
                    {{ __('Simpan') }}
                </button>
            </div>
        </div>
    </x-modal>
</section>
