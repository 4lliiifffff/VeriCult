<section x-data="{ 
    current_password: '',
    password: '',
    password_confirmation: '',
    submitPasswordForm() {
        this.$refs.passwordForm.submit();
    },
    validateAndConfirm() {
        if (this.current_password && this.password && this.password_confirmation) {
            $dispatch('open-modal', 'confirm-password-update');
        } else {
            $dispatch('open-modal', 'incomplete-password-modal');
        }
    }
}">
    <header class="flex items-center gap-4 mb-8">
        <div class="p-3 rounded-2xl bg-indigo-50 text-[#03045E]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#03045E]">
                {{ __('Perbarui Kata Sandi') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-7" x-ref="passwordForm">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 gap-7 pt-4">
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-slate-700 font-semibold ml-1" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full" autocomplete="current-password" x-model="current_password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-slate-700 font-semibold ml-1" />
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full" autocomplete="new-password" x-model="password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-700 font-semibold ml-1" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full" autocomplete="new-password" x-model="password_confirmation" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
            <button type="button" x-on:click="validateAndConfirm" class="inline-flex items-center px-6 py-3 bg-[#03045E] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-[#023E8A] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 shadow-lg shadow-indigo-900/10 active:scale-[0.98]">
                {{ __('Simpan Kata Sandi') }}
            </button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-password-update" :show="false" focusable>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-indigo-50 rounded-2xl text-[#03045E]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#03045E]">
                        {{ __('Konfirmasi Kata Sandi') }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('Perbarui kata sandi akun?') }}
                    </p>
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                {{ __('Apakah Anda yakin ingin memperbarui kata sandi Anda? Anda mungkin perlu masuk kembali setelah perubahan ini untuk keamanan.') }}
            </p>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm tracking-widest uppercase hover:bg-slate-50 transition-all duration-300">
                    {{ __('Batal') }}
                </button>

                <button type="button" x-on:click="submitPasswordForm" class="px-6 py-3 rounded-xl bg-[#03045E] text-white font-bold text-sm tracking-widest uppercase hover:bg-[#023E8A] transition-all duration-300 shadow-lg shadow-indigo-900/20 active:scale-[0.98]">
                    {{ __('Simpan') }}
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Incomplete Data Modal -->
    <x-modal name="incomplete-password-modal" :show="false" focusable>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-amber-600">
                        {{ __('Data Belum Lengkap') }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('Harap isi semua kolom.') }}
                    </p>
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                {{ __('Silakan isi kata sandi saat ini, kata sandi baru, dan konfirmasi kata sandi baru sebelum menyimpan perubahan.') }}
            </p>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl bg-amber-600 text-white font-bold text-sm tracking-widest uppercase hover:bg-amber-700 transition-all duration-300 shadow-lg shadow-amber-900/20 active:scale-[0.98]">
                    {{ __('SAYA MENGERTI') }}
                </button>
            </div>
        </div>
    </x-modal>
</section>
