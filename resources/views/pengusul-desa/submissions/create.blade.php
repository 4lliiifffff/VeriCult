<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pilih Kategori</span>
        </nav>

        <div class="relative mb-12 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-10 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 text-center max-w-2xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-xl mb-4">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Langkah 1 dari 2</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    Pilih <span class="text-[#00B4D8]">Kategori</span> Pengajuan
                </h2>
                <p class="text-blue-100/70 text-lg font-medium leading-relaxed">
                    Silakan pilih jenis data kebudayaan yang ingin Anda ajukan untuk memulai proses inventarisasi.
                </p>
            </div>
        </div>

        <!-- Category Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-20">
            <!-- Kebudayaan Aktif -->
            <a href="{{ route('pengusul-desa.submissions.create-form', 'laporan-kebudayaan-aktif') }}" 
               class="group relative bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <svg class="w-8 h-8 text-[#00B4D8]/20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 rounded-[2rem] bg-blue-50 text-[#0077B6] flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-[#03045E] mb-4 tracking-tight">Kebudayaan Aktif</h3>
                <p class="text-slate-400 font-medium leading-relaxed mb-8">
                    Dokumentasikan kegiatan atau objek kebudayaan yang sedang dilaksanakan secara aktif di masyarakat.
                </p>
                
                <div class="mt-auto px-8 py-4 bg-[#03045E]/5 text-[#03045E] font-black text-xs uppercase tracking-[0.2em] rounded-2xl group-hover:bg-[#03045E] group-hover:text-white transition-all duration-300">
                    Pilih Kategori
                </div>
            </a>

            <!-- OPK -->
            <a href="{{ route('pengusul-desa.opk-submissions.create') }}" 
               class="group relative bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <svg class="w-8 h-8 text-indigo-500/20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 rounded-[2rem] bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-[#03045E] mb-4 tracking-tight">Data OPK</h3>
                <p class="text-slate-400 font-medium leading-relaxed mb-8">
                    Isi formulir inventarisasi mendalam untuk 10 Objek Pemajuan Kebudayaan desa sesuai standar nasional.
                </p>
                
                <div class="mt-auto px-8 py-4 bg-indigo-600/5 text-indigo-600 font-black text-xs uppercase tracking-[0.2em] rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    Pilih Kategori
                </div>
            </a>

            <!-- Cagar Budaya -->
            <a href="{{ route('pengusul-desa.cagar-budaya-submissions.create') }}" 
               class="group relative bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <svg class="w-8 h-8 text-amber-500/20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 rounded-[2rem] bg-amber-50 text-amber-600 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-[#03045E] mb-4 tracking-tight">Cagar Budaya</h3>
                <p class="text-slate-400 font-medium leading-relaxed mb-8">
                    Ajukan inventarisasi untuk benda, bangunan, atau situs yang memiliki nilai sejarah sebagai cagar budaya.
                </p>
                
                <div class="mt-auto px-8 py-4 bg-amber-600/5 text-amber-600 font-black text-xs uppercase tracking-[0.2em] rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                    Pilih Kategori
                </div>
            </a>

            <!-- Potensi Kebudayaan -->
            <a href="{{ route('pengusul-desa.potensi-submissions.create') }}" 
               class="group relative bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center">
                <div class="absolute top-0 right-0 p-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <svg class="w-8 h-8 text-emerald-500/20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <div class="w-20 h-20 rounded-[2rem] bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-[#03045E] mb-4 tracking-tight">Potensi Kebudayaan</h3>
                <p class="text-slate-400 font-medium leading-relaxed mb-8">
                    Pendataan tenaga budaya, lembaga kebudayaan, serta sarana prasarana penunjang seni budaya desa.
                </p>
                
                <div class="mt-auto px-8 py-4 bg-emerald-600/5 text-emerald-600 font-black text-xs uppercase tracking-[0.2em] rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    Pilih Kategori
                </div>
            </a>
        </div>
    </x-slot>
</x-layouts.pengusul-desa>
