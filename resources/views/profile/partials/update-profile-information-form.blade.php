<section x-data="{ 
    submitForm() {
        this.$refs.profileForm.submit();
    }
}">
    <header class="flex items-center gap-6 mb-12">
        <div class="w-14 h-14 rounded-2xl bg-[#00B4D8]/10 flex items-center justify-center text-[#0077B6] shrink-0 border border-[#00B4D8]/20 shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-[#03045E] tracking-tight">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 font-bold">
                {{ __("Perbarui identitas publik dan alamat email akun Anda.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-10" x-ref="profileForm">
        @csrf
        @method('patch')

        <div class="space-y-8">
            <div class="space-y-3 group">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-[#0077B6]" />
                <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-3 group">
                <x-input-label for="email" :value="__('Alamat Email')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-[#0077B6]" />
                <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-6 p-6 rounded-2xl bg-amber-50 border border-amber-100 flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-amber-900 font-bold mb-2">
                                {{ __('Email belum diverifikasi.') }}
                            </p>
                            <button form="send-verification" class="text-xs font-black text-amber-600 hover:text-amber-800 uppercase tracking-widest transition-colors focus:outline-none">
                                {{ __('Kirim Ulang Email Verifikasi') }}
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs font-black text-emerald-700 uppercase tracking-widest">
                                {{ __('Tautan verifikasi telah dikirim.') }}
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end pt-10 border-t border-slate-50">
            <button type="button" 
                    @click="$dispatch('open-modal', 'confirm-profile-update')" 
                    class="px-10 py-5 bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase rounded-2xl shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] hover:-translate-y-1 transition-all duration-300 active:scale-95 group">
                <div class="flex items-center gap-3">
                    <span>Simpan Profil</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-profile-update" :show="false" focusable>
        <div class="p-10 sm:p-14 text-center">
            <div class="w-24 h-24 bg-blue-50 rounded-[2.5rem] flex items-center justify-center text-[#0077B6] mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Perbarui Profil?</h2>
            <p class="text-slate-500 max-w-sm mx-auto font-bold text-sm leading-relaxed mb-12">Kami akan memperbarui informasi profil Anda segera setelah Anda mengonfirmasi perubahan ini.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <button type="button" 
                        @click="submitForm" 
                        class="px-8 py-5 rounded-2xl bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] transition-all active:scale-[0.98]">
                    Ya, Perbarui
                </button>
            </div>
        </div>
    </x-modal>
</section>
