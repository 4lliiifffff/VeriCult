<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#FFB703] to-[#FB8500] rounded-3xl mb-6 shadow-2xl shadow-orange-400/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Menunggu <span class="text-[#FB8500]">Validasi</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Akun Anda Belum Disetujui</p>
    </div>

    <div class="mb-10 p-6 rounded-2xl bg-orange-50 border border-orange-100/50">
        <p class="text-xs md:text-sm text-slate-600 font-bold leading-relaxed uppercase tracking-wider text-center">
            {{ __('Akun Anda sebagai Pengusul Desa telah didaftarkan, namun saat ini sedang menunggu proses validasi atau persetujuan oleh Super Admin sistem VeriCult. Jika diperlukan, silakan hubungi admin Anda untuk mempercepat proses validasi.') }}
        </p>
    </div>

    <div class="flex flex-col space-y-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full border-2 border-slate-100 text-[#03045E] hover:bg-slate-50 hover:border-slate-200 font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-sm group">
                <span class="uppercase tracking-[0.2em] text-xs">{{ __('Kembali ke Beranda Utama') }}</span>
            </button>
        </form>
    </div>

    <!-- Security Badge -->
    <div class="mt-12 pt-8 border-t border-slate-50 text-center">
        <div class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
            <svg class="w-4 h-4 mr-3 text-[#FB8500]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>Secured Verification Process</span>
        </div>
    </div>
</x-guest-layout>
