<section class="space-y-6">
    <header class="flex items-center gap-4 mb-8">
        <div class="p-3 rounded-2xl bg-red-50 text-red-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-red-600">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.') }}
            </p>
        </div>
    </header>

    <div class="pt-2">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300 shadow-lg shadow-red-900/10 active:scale-[0.98]"
        >
            {{ __('Hapus Akun Saya') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-red-50 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900">
                    {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                </h2>
            </div>

            <p class="text-sm text-slate-600 leading-relaxed">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-8 space-y-2">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="text-slate-700 font-semibold ml-1" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Masukkan Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
                <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl border-2 !px-6 !py-3 font-bold !bg-white hover:!bg-slate-50 transition-all duration-300 shadow-none">
                    {{ __('Batal') }}
                </x-secondary-button>

                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300 shadow-lg shadow-red-900/10 active:scale-[0.98]">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
