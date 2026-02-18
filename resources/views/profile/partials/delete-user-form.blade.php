<section class="space-y-6">
    <header class="flex items-center gap-6 mb-12">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shrink-0 border border-rose-100 shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-rose-900 tracking-tight">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-bold">
                {{ __('Semua data Anda akan dihapus secara permanen dan tidak dapat dipulihkan.') }}
            </p>
        </div>
    </header>

    <div class="pt-2">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-10 py-5 bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase rounded-2xl shadow-2xl shadow-rose-900/20 hover:bg-rose-700 hover:-translate-y-1 transition-all duration-300 active:scale-95 group"
        >
            <div class="flex items-center gap-3">
                <span>Hapus Akun Saya</span>
                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 sm:p-14 text-center">
            @csrf
            @method('delete')

            <div class="w-24 h-24 bg-rose-50 rounded-[2.5rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h2 class="text-3xl font-black text-rose-900 mb-3 tracking-tight">
                {{ __('Hapus Akun?') }}
            </h2>
            <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-10">
                {{ __('Tindakan ini permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan seluruh data akun Anda.') }}
            </p>

            <div class="max-w-xs mx-auto space-y-3 group text-left mb-12">
                <x-input-label for="password" value="{{ __('Kata Sandi Konfirmasi') }}" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-rose-600" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Masukkan Kata Sandi') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <button type="submit" 
                        class="px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
