<section x-data="{ 
    current_password: '',
    password: '',
    password_confirmation: '',
    show_current: false,
    show_new: false,
    show_confirm: false,
    submitPasswordForm() {
        this.$refs.passwordForm.submit();
    },
    validateAndConfirm() {
        if (this.current_password && this.password && this.password_confirmation) {
            this.$dispatch('open-modal', 'confirm-password-update');
        } else {
            this.$dispatch('open-modal', 'incomplete-password-modal');
        }
    }
}">
    <header class="flex items-center gap-6 mb-12">
        <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shrink-0 shadow-xl shadow-indigo-900/20">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-[#03045E] tracking-tight">
                {{ __('Keamanan Akun') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-bold">
                {{ __('Pastikan akun Anda menggunakan kata sandi yang kuat dan unik.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-10" x-ref="passwordForm">
        @csrf
        @method('put')

        <div class="space-y-8">
            <div class="space-y-3 group">
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-indigo-600" />
                <div class="relative">
                    <x-text-input id="update_password_current_password" name="current_password" ::type="show_current ? 'text' : 'password'" class="block w-full pr-12" autocomplete="current-password" x-model="current_password" />
                    <button type="button" @click="show_current = !show_current" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg x-show="!show_current" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show_current" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="space-y-3 group">
                <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-indigo-600" />
                <div class="relative">
                    <x-text-input id="update_password_password" name="password" ::type="show_new ? 'text' : 'password'" class="block w-full pr-12" autocomplete="new-password" x-model="password" />
                    <button type="button" @click="show_new = !show_new" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg x-show="!show_new" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show_new" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="space-y-3 group">
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-indigo-600" />
                <div class="relative">
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" ::type="show_confirm ? 'text' : 'password'" class="block w-full pr-12" autocomplete="new-password" x-model="password_confirmation" />
                    <button type="button" @click="show_confirm = !show_confirm" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg x-show="!show_confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show_confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end pt-10 border-t border-slate-50">
            <button type="button" 
                    @click="validateAndConfirm" 
                    class="px-10 py-5 bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase rounded-2xl shadow-2xl shadow-indigo-900/10 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300 active:scale-95 group">
                <div class="flex items-center gap-3">
                    <span>Simpan Kata Sandi</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-password-update" :show="false" focusable>
        <div class="p-10 sm:p-14 text-center">
            <div class="w-24 h-24 bg-indigo-50 rounded-[2.5rem] flex items-center justify-center text-indigo-600 mx-auto mb-8 shadow-inner animate-bounce-slow">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight uppercase">Ganti Kata Sandi?</h2>
            <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-12">Anda akan diminta untuk masuk kembali menggunakan kata sandi baru demi alasan keamanan.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-400 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <button type="button" 
                        @click="submitPasswordForm" 
                        class="px-8 py-5 rounded-2xl bg-indigo-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-indigo-900/20 hover:bg-indigo-700 transition-all active:scale-[0.98]">
                    Ya, Ganti
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Incomplete Data Modal -->
    <x-modal name="incomplete-password-modal" :show="false" focusable>
        <div class="p-10 sm:p-14 text-center">
            <div class="w-24 h-24 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-rose-900 mb-3 tracking-tight uppercase">Form Belum Lengkap</h2>
            <p class="text-slate-500 max-w-xs mx-auto font-bold text-sm leading-relaxed mb-10">Harap isi semua kolom kata sandi (lama, baru, dan konfirmasi) sebelum menyimpan.</p>

            <button type="button" 
                    @click="$dispatch('close')" 
                    class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                SAYA MENGERTI
            </button>
        </div>
    </x-modal>
</section>
