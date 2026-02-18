<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#00B4D8] to-[#0077B6] rounded-3xl mb-6 shadow-2xl shadow-blue-400/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Verifikasi <span class="text-[#00B4D8]">Email</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Satu Langkah Lagi Menuju Portal</p>
    </div>

    <div class="mb-10 p-6 rounded-2xl bg-blue-50 border border-blue-100/50">
        <p class="text-xs md:text-sm text-slate-600 font-bold leading-relaxed uppercase tracking-wider text-center">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerimanya, kami akan mengirimkan yang lain.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-5 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-4 animate-bounce">
            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-xs font-black text-emerald-600 uppercase tracking-wider">
                {{ __('Tautan verifikasi baru telah dikirim!') }}
            </p>
        </div>
    @endif

    <div class="flex flex-col space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-br from-[#00B4D8] to-[#0077B6] hover:shadow-2xl hover:shadow-blue-400/40 text-white font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-400/20 flex items-center justify-center group active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <span class="uppercase tracking-[0.2em] text-xs font-black">{{ __('Kirim Ulang Email Verifikasi') }}</span>
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full border-2 border-slate-100 text-[#03045E] hover:bg-slate-50 hover:border-slate-200 font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-sm group">
                <span class="uppercase tracking-[0.2em] text-xs">{{ __('Keluar Sistem') }}</span>
            </button>
        </form>
    </div>

    <!-- Security Badge -->
    <div class="mt-12 pt-8 border-t border-slate-50 text-center">
        <div class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
            <svg class="w-4 h-4 mr-3 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>Secured Verification Process</span>
        </div>
    </div>
</x-guest-layout>
