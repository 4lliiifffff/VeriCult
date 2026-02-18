<x-layouts.validator>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8">
            <a href="{{ route('validator_dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Overview</span>
        </nav>

        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-10 overflow-hidden shadow-2xl shadow-blue-900/20 mb-10 group">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/10 rounded-full -ml-32 -mb-32 blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#00B4D8] mr-2 animate-pulse"></span>
                        Validator Portal
                    </div>
                    <h2 class="text-4xl font-black text-white tracking-tight leading-tight">
                        Dashboard <span class="text-[#00B4D8]">Validator</span>
                    </h2>
                    <p class="text-blue-100/80 mt-3 font-medium max-w-xl">
                        Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }}. Mari kita teliti dan verifikasi data budaya hari ini untuk menjaga integritas sistem.
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-[2rem] border border-white/20 text-center min-w-[140px]">
                        <p class="text-blue-200 text-[10px] font-black uppercase tracking-widest mb-1">Status Anda</p>
                        <p class="text-white font-black text-lg">Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Pending Tasks -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 mb-6 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Menunggu Verifikasi</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">0</h3>
                        <span class="text-xs font-bold text-slate-400">Berkas</span>
                    </div>
                </div>
            </div>

            <!-- Approved Tasks -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 mb-6 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Selesai Diverifikasi</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">0</h3>
                        <span class="text-xs font-bold text-slate-400">Berkas</span>
                    </div>
                </div>
            </div>

            <!-- Total Contributions -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 mb-6 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Pengabdian</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">0</h3>
                        <span class="text-xs font-bold text-slate-400">Hari</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State / Work Queue -->
        <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
            <div class="p-16 text-center">
                <div class="relative inline-block mb-8">
                    <div class="absolute inset-0 bg-blue-100 rounded-full blur-2xl opacity-50 group-hover:opacity-80 transition-opacity"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-full flex items-center justify-center shadow-2xl shadow-blue-900/40 transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-2xl font-black text-[#03045E] mb-3">Antrian Masih Kosong</h3>
                <p class="text-slate-500 max-w-sm mx-auto font-medium leading-relaxed">
                    Saat ini belum ada data pengajuan yang memerlukan verifikasi Anda. Anda akan menerima notifikasi jika ada berkas baru yang masuk.
                </p>
                
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <button class="px-8 py-3 bg-slate-50 text-slate-400 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-slate-100 cursor-not-allowed">
                        Lihat Riwayat Validasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.validator>
