<x-guest-layout>
    <div class="mb-12 text-center">
        <!-- Success Icon -->
        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full mb-8 shadow-2xl shadow-emerald-500/30 animate-bounce">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-black text-[#03045E] mb-4 tracking-tight leading-tight">
            Pendaftaran <span class="text-emerald-500">Berhasil!</span>
        </h2>
        
        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 mb-8 text-left inline-block w-full">
            <p class="text-sm text-slate-600 font-medium leading-relaxed mb-4">
                Terima kasih telah mendaftar sebagai <strong class="text-[#03045E]">Pengusul Desa</strong> di VeriCult.
            </p>
            <p class="text-sm text-slate-600 font-medium leading-relaxed">
                Saat ini akun Anda sedang dalam status <strong>Menunggu Persetujuan</strong> dari Administrator kami. Proses validasi ini diperlukan untuk memastikan keamanan dan keaslian data desa yang terdaftar.
            </p>
        </div>

        <div class="space-y-4">
            <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 text-left">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#0077B6] shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-[#03045E] uppercase tracking-wider mb-1">Beritahu Saya</h4>
                    <p class="text-xs text-slate-500 font-medium">Kami akan mengirimkan pemberitahuan ke email Anda segera setelah akun Anda disetujui.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 text-left">
                 <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#0077B6] shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-[#03045E] uppercase tracking-wider mb-1">Akses Login</h4>
                    <p class="text-xs text-slate-500 font-medium">Anda baru dapat masuk (login) ke platform setelah Administrator menyetujui akun Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-4">
        <a href="{{ route('beranda') }}" class="w-full inline-flex justify-center items-center bg-gradient-to-br from-[#00B4D8] to-[#0077B6] hover:shadow-xl hover:shadow-blue-400/40 text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-blue-400/20 group">
            <span class="uppercase tracking-[0.2em] text-xs">Kembali ke Beranda</span>
        </a>
        
        <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center border-2 border-slate-100 text-[#03045E] hover:bg-slate-50 hover:border-slate-200 font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-sm group">
            <span class="uppercase tracking-[0.2em] text-xs">Menu Login</span>
        </a>
    </div>

</x-guest-layout>
