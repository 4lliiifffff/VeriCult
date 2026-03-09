<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Kebudayaan - VeriCult</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .premium-gradient {
            background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%);
        }
        .premium-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #F8FAFC; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #0077B6; border-radius: 10px; }
    </style>
</head>
<body class="antialiased font-sans custom-scrollbar bg-[#F8FAFC] overflow-x-hidden">
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Header Section -->
    <section class="premium-gradient pt-32 sm:pt-40 pb-16 sm:pb-24 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-1.5 bg-white/10 backdrop-blur-xl rounded-full text-white text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] mb-8 border border-white/20">
                Eksplorasi Budaya Nusantara
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter">Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#90E0EF] to-[#00B4D8]">Kebudayaan Indonesia</span></h1>
            <p class="text-sm sm:text-base md:text-lg text-[#CAF0F8]/80 max-w-2xl mx-auto font-medium leading-relaxed">
                Temukan kekayaan tradisi, seni, dan warisan budaya yang telah tervalidasi oleh tim ahli VeriCult.
            </p>
        </div>
    </section>

    <!-- Filter & Gallery Section -->
    <section class="py-16 -mt-12 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Bar -->
            <div class="premium-glass rounded-[2.5rem] p-4 mb-16 shadow-2xl overflow-x-auto whitespace-nowrap scrollbar-hide">
                <div class="flex items-center gap-2 p-1">
                    <a href="{{ route('profil-kebudayaan.index') }}" 
                       class="px-6 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all {{ !$activeCategory ? 'bg-[#03045E] text-white shadow-xl shadow-blue-900/20' : 'text-[#03045E]/60 hover:bg-[#03045E]/5' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('profil-kebudayaan.index', ['category' => $category]) }}" 
                           class="px-6 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all {{ $activeCategory === $category ? 'bg-[#03045E] text-white shadow-xl shadow-blue-900/20' : 'text-[#03045E]/60 hover:bg-[#03045E]/5' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Search & Year Filter Form -->
            <div class="mb-12 max-w-3xl mx-auto text-center">
                <form action="{{ route('profil-kebudayaan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <!-- Year Filter -->
                    <div class="relative min-w-full md:min-w-[220px] auto-submit">
                        <x-dropdown-select 
                            name="year" 
                            id="year" 
                            placeholder="Pilih Periode"
                            variant="light"
                            :selected="$activeYear" 
                            :options="!empty($availableYears) ? collect($availableYears)->mapWithKeys(fn($y) => [$y => 'Periode ' . $y])->toArray() : [date('Y') => 'Periode ' . date('Y')]" 
                        />
                    </div>

                    <!-- Search Input -->
                    <div class="relative flex-1 group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari objek kebudayaan..." 
                               class="w-full h-full bg-white border-2 border-slate-100 rounded-[1.5rem] sm:rounded-[2rem] pl-6 pr-28 sm:pl-8 sm:pr-32 py-4 sm:py-5 text-slate-700 font-bold text-sm sm:text-base focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none shadow-sm">
                        <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 sm:px-8 bg-[#03045E] text-white rounded-[1rem] sm:rounded-[1.5rem] font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-md">
                            Cari
                        </button>
                    </div>
                </form>

                @if($activeYear != date('Y') && $activeYear == $defaultYear && !request()->has('year') && !empty($availableYears))
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Menampilkan data periode terbaru yang tersedia ({{ $activeYear }})
                    </div>
                @endif
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($submissions as $submission)
                <a href="{{ route('profil-kebudayaan.show', $submission->slug) }}" class="group bg-white rounded-[2rem] sm:rounded-[3rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                    <!-- Image Wrapper -->
                    <div class="relative h-64 overflow-hidden">
                        @php $mainImage = $submission->files->first(); @endphp
                        @if($mainImage)
                            <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#03045E]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-1.5 rounded-full bg-white/90 backdrop-blur-md text-[#03045E] text-[9px] font-black uppercase tracking-widest shadow-lg">
                                {{ $submission->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 sm:p-10 flex flex-col flex-grow">
                        <h3 class="text-lg sm:text-2xl font-black text-[#03045E] mb-3 line-clamp-1 capitalize group-hover:text-[#0077B6] transition-colors">{{ $submission->name }}</h3>
                        <p class="text-slate-500 text-xs sm:text-sm font-medium line-clamp-3 mb-8 leading-relaxed">
                            {{ $submission->description }}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest truncate w-32 pb-0.5" title="{{ $submission->address }}">{{ $submission->address }}</span>
                            </div>
                            <div class="text-[#0077B6] font-black text-[10px] uppercase tracking-widest group-hover:translate-x-1 transition-transform flex items-center gap-2">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 py-20 text-center">
                    <div class="w-24 h-24 bg-slate-100 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-300">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E] mb-2 tracking-tighter">Belum Ada Objek Budaya</h3>
                    <p class="text-slate-400 font-medium">Beberapa kategori mungkin masih dalam tahap verifikasi oleh tim validator.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $submissions->links() }}
            </div>
        </div>
    </section>

    <!-- Footer (Simplified) -->
    <footer class="bg-[#03045E] text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em]">&copy; {{ date('Y') }} VeriCult Platform. Melestarikan Budaya Digital.</p>
        </div>
    </footer>

</body>
</html>
