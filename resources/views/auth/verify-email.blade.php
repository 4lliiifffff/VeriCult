<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Verifikasi Email</h2>
        <p class="text-slate-500 text-sm font-medium">Satu langkah lagi menuju portal VeriCult</p>
    </div>

    <div class="mb-8 p-6 rounded-2xl bg-[#90E0EF]/10 border border-[#90E0EF]/20">
        <p class="text-xs text-slate-600 font-medium leading-relaxed text-center">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerimanya, kami akan mengirimkan yang lain.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-5 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">
                {{ __('Tautan verifikasi baru telah dikirim!') }}
            </p>
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs font-bold">{{ __('Kirim Ulang Email Verifikasi') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full border border-slate-100 text-slate-400 hover:text-[#03045E] hover:bg-slate-50 font-bold py-4 px-6 rounded-2xl transition-all duration-300 text-xs uppercase tracking-widest">
                {{ __('Keluar Sistem') }}
            </button>
        </form>
    </div>
</x-guest-layout>
