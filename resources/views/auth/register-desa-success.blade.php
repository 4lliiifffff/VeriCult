<x-guest-layout>
    <div class="text-center mb-10">
        <!-- Success Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-[2rem] mb-6 shadow-sm border border-emerald-100">
            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight leading-tight">
            Pendaftaran Berhasil!
        </h2>
        <p class="text-slate-500 text-sm font-medium">Akun Desa Anda sedang dalam proses verifikasi</p>
    </div>

    <div class="space-y-6">
        <div class="bg-[#90E0EF]/10 border border-[#90E0EF]/20 rounded-3xl p-6">
            <p class="text-xs text-slate-600 font-medium leading-relaxed text-center">
                Terima kasih telah mendaftar sebagai <strong>Pengusul Desa</strong>. Administrator kami akan memvalidasi data Anda dalam waktu 1-2 hari kerja.
            </p>
        </div>

        <div class="grid gap-4">
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm transition-all hover:border-[#0077B6]/30">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Notifikasi</h4>
                    <p class="text-[11px] text-slate-600 font-bold">Akan dikirim setelah akun disetujui</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm transition-all hover:border-[#0077B6]/30">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Akses</h4>
                    <p class="text-[11px] text-slate-600 font-bold">Login dibuka setelah validasi admin</p>
                </div>
            </div>
        </div>

        <div class="pt-6 space-y-4">
            <a href="{{ route('beranda') }}" class="w-full inline-flex justify-center items-center bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10">
                <span class="uppercase tracking-widest text-xs">Kembali ke Beranda</span>
            </a>
            
            <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center border border-slate-100 text-slate-400 hover:text-[#03045E] hover:bg-slate-50 font-bold py-4 px-6 rounded-2xl transition-all duration-300 text-xs uppercase tracking-widest">
                {{ __('Menu Login') }}
            </a>
        </div>
    </div>
</x-guest-layout>
