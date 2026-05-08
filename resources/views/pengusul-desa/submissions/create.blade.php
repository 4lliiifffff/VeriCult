<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 text-[10px] sm:text-xs font-black text-slate-400 mb-8 sm:mb-12 uppercase tracking-[0.2em]">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pilih Kategori</span>
        </nav>

        <div class="relative bg-white rounded-[2.5rem] sm:rounded-[3.5rem] p-8 sm:p-16 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group text-center max-w-5xl mx-auto">
            <!-- Decorative Bubbles -->
            <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-[#00B4D8]/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 space-y-6 sm:space-y-8">
                <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-blue-50/50 border border-blue-100/50 backdrop-blur-xl mb-2">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0077B6] shadow-sm"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#03045E]">Langkah 1 dari 2</span>
                </div>
                
                <div class="space-y-4">
                    <h2 class="text-3xl sm:text-6xl font-black text-[#03045E] tracking-tight leading-tight">
                        Pilih <span class="text-[#00B4D8]">Kategori</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-xl font-medium leading-relaxed max-w-2xl mx-auto uppercase tracking-wide">
                        Silakan pilih jenis data kebudayaan yang ingin Anda ajukan untuk memulai proses inventarisasi di wilayah Anda.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-20">
        <!-- Category Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-10 max-w-6xl mx-auto">
            <!-- Kebudayaan Aktif -->
            <a href="{{ route('pengusul-desa.submissions.create-form', 'laporan-kebudayaan-aktif') }}" 
               class="group relative bg-white p-8 sm:p-12 rounded-[2.5rem] sm:rounded-[3.5rem] border border-white shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-[#0077B6]/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-10 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                    <svg class="w-12 h-12 text-[#0077B6]/10" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[2rem] bg-blue-50 text-[#0077B6] flex items-center justify-center mb-8 sm:mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner ring-4 ring-white">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                
                <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] mb-4 tracking-tight">Kebudayaan Aktif</h3>
                <p class="text-slate-400 font-medium text-sm sm:text-base leading-relaxed mb-8 max-w-xs">
                    Dokumentasikan kegiatan atau objek kebudayaan yang sedang dilaksanakan secara aktif di masyarakat.
                </p>
                
                <div class="mt-auto inline-flex items-center gap-2 px-8 py-4 bg-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl group-hover:bg-[#03045E] group-hover:text-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-blue-900/20">
                    Pilih Kategori
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>

            <!-- OPK -->
            <a href="{{ route('pengusul-desa.opk-submissions.create') }}" 
               class="group relative bg-white p-8 sm:p-12 rounded-[2.5rem] sm:rounded-[3.5rem] border border-white shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-10 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                    <svg class="w-12 h-12 text-indigo-500/10" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[2rem] bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 sm:mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner ring-4 ring-white">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                
                <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] mb-4 tracking-tight">Data OPK</h3>
                <p class="text-slate-400 font-medium text-sm sm:text-base leading-relaxed mb-8 max-w-xs">
                    Isi formulir inventarisasi mendalam untuk 10 Objek Pemajuan Kebudayaan desa sesuai standar nasional.
                </p>
                
                <div class="mt-auto inline-flex items-center gap-2 px-8 py-4 bg-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-indigo-900/20">
                    Pilih Kategori
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>

            <!-- Cagar Budaya -->
            <a href="{{ route('pengusul-desa.cagar-budaya-submissions.create') }}" 
               class="group relative bg-white p-8 sm:p-12 rounded-[2.5rem] sm:rounded-[3.5rem] border border-white shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-10 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                    <svg class="w-12 h-12 text-amber-500/10" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[2rem] bg-amber-50 text-amber-600 flex items-center justify-center mb-8 sm:mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner ring-4 ring-white">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                
                <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] mb-4 tracking-tight">Cagar Budaya</h3>
                <p class="text-slate-400 font-medium text-sm sm:text-base leading-relaxed mb-8 max-w-xs">
                    Ajukan inventarisasi untuk benda, bangunan, atau situs yang memiliki nilai sejarah sebagai cagar budaya.
                </p>
                
                <div class="mt-auto inline-flex items-center gap-2 px-8 py-4 bg-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-amber-900/20">
                    Pilih Kategori
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>

            <!-- Potensi Kebudayaan -->
            <a href="{{ route('pengusul-desa.potensi-submissions.create') }}" 
               class="group relative bg-white p-8 sm:p-12 rounded-[2.5rem] sm:rounded-[3.5rem] border border-white shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-10 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                    <svg class="w-12 h-12 text-emerald-500/10" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[2rem] bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 sm:mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner ring-4 ring-white">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                
                <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] mb-4 tracking-tight">Potensi Kebudayaan</h3>
                <p class="text-slate-400 font-medium text-sm sm:text-base leading-relaxed mb-8 max-w-xs">
                    Pendataan tenaga budaya, lembaga kebudayaan, serta sarana prasarana penunjang seni budaya desa.
                </p>
                
                <div class="mt-auto inline-flex items-center gap-2 px-8 py-4 bg-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-emerald-900/20">
                    Pilih Kategori
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>
        </div>
    </div>
</x-layouts.pengusul-desa>
