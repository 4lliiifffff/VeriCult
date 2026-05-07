<x-layouts.pengusul-desa>
    <x-slot name="header">
        <div class="space-y-4">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest">
                <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul-desa.submissions.create') }}" class="hover:text-[#0077B6] transition-colors">Pilih Jenis</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">Pilih Kategori OPK</span>
            </nav>

            <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-12 overflow-hidden shadow-2xl shadow-blue-900/20 group text-center">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto space-y-4 sm:space-y-6">
                    <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-xl mb-2">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500 shadow-sm"></span>
                        </span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Langkah 2 dari 2</span>
                    </div>
                    <h2 class="text-3xl sm:text-6xl font-black text-white tracking-tight leading-tight">
                        Kategori <span class="text-[#00B4D8]">OPK</span>
                    </h2>
                    <p class="text-blue-100/70 text-sm sm:text-xl font-medium leading-relaxed">
                        Pilih salah satu dari 10 Objek Pemajuan Kebudayaan untuk memulai inventarisasi mendalam di desa Anda.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-20 space-y-12">
        <!-- Category Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @php
                $categoryData = [
                    'tradisi-lisan' => ['name' => 'Tradisi Lisan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>', 'color' => 'from-blue-500 to-blue-600', 'bgLight' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                    'manuskrip' => ['name' => 'Manuskrip', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>', 'color' => 'from-amber-500 to-orange-600', 'bgLight' => 'bg-amber-50', 'textColor' => 'text-amber-600'],
                    'adat-istiadat' => ['name' => 'Adat Istiadat', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>', 'color' => 'from-emerald-500 to-teal-600', 'bgLight' => 'bg-emerald-50', 'textColor' => 'text-emerald-600'],
                    'ritus' => ['name' => 'Ritus', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>', 'color' => 'from-rose-500 to-red-600', 'bgLight' => 'bg-rose-50', 'textColor' => 'text-rose-600'],
                    'pengetahuan-tradisional' => ['name' => 'Pengetahuan Tradisional', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>', 'color' => 'from-violet-500 to-purple-600', 'bgLight' => 'bg-violet-50', 'textColor' => 'text-violet-600'],
                    'teknologi-tradisional' => ['name' => 'Teknologi Tradisional', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>', 'color' => 'from-slate-500 to-slate-700', 'bgLight' => 'bg-slate-100', 'textColor' => 'text-slate-600'],
                    'seni' => ['name' => 'Seni', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>', 'color' => 'from-pink-500 to-rose-600', 'bgLight' => 'bg-pink-50', 'textColor' => 'text-pink-600'],
                    'bahasa' => ['name' => 'Bahasa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>', 'color' => 'from-cyan-500 to-blue-600', 'bgLight' => 'bg-cyan-50', 'textColor' => 'text-cyan-600'],
                    'permainan-rakyat' => ['name' => 'Permainan Rakyat', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>', 'color' => 'from-yellow-500 to-amber-600', 'bgLight' => 'bg-yellow-50', 'textColor' => 'text-yellow-600'],
                    'olahraga-tradisional' => ['name' => 'Olahraga Tradisional', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>', 'color' => 'from-indigo-500 to-blue-700', 'bgLight' => 'bg-indigo-50', 'textColor' => 'text-indigo-600'],
                ];
            @endphp

            @foreach($categoryData as $slug => $cat)
                <a href="{{ route('pengusul-desa.opk-submissions.create-form', ['category' => $slug]) }}" 
                   class="group relative bg-white rounded-[2rem] p-8 border border-white shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-slate-300/50 hover:-translate-y-2 hover:border-transparent transition-all duration-500 overflow-hidden">
                    
                    <!-- Gradient overlay on hover -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $cat['color'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-[2rem]"></div>
                    
                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Icon -->
                        <div class="w-16 h-16 rounded-2xl {{ $cat['bgLight'] }} {{ $cat['textColor'] }} flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition-all duration-500 shadow-sm ring-4 ring-white group-hover:ring-transparent">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-black text-[#03045E] mb-3 group-hover:text-white transition-colors duration-500 tracking-tight">
                            {{ $cat['name'] }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-sm text-slate-400 leading-relaxed group-hover:text-white/80 transition-colors duration-500 line-clamp-3">
                            {{ \App\Models\CulturalSubmission::CATEGORY_DESCRIPTIONS[$cat['name']] ?? 'Dokumentasikan dan lestarikan salah satu objek pemajuan kebudayaan desa Anda.' }}
                        </p>
                        
                        <!-- Action indicator -->
                        <div class="mt-8 flex items-center gap-3 text-slate-300 group-hover:text-white transition-colors duration-500">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Pilih Kategori</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-[2.5rem] p-8 sm:p-12 border border-white shadow-xl shadow-slate-200/40 relative overflow-hidden group/info">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl group-hover/info:scale-110 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6 sm:gap-10">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6] shrink-0 shadow-inner ring-4 ring-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="space-y-3">
                    <h4 class="font-black text-[#03045E] text-xl sm:text-2xl tracking-tight">Inventarisasi Objek Pemajuan Kebudayaan</h4>
                    <p class="text-sm sm:text-base text-slate-500 leading-relaxed max-w-4xl">
                        10 Objek Pemajuan Kebudayaan (OPK) merupakan pilar utama identitas budaya bangsa. Melalui inventarisasi ini, desa Anda berkontribusi langsung dalam pemutakhiran data kebudayaan nasional yang akurat dan kredibel. Pastikan data yang diberikan valid untuk memudahkan proses verifikasi lapangan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.pengusul-desa>
