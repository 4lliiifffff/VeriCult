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
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" 
         x-data="{ scrolled: false, mobileMenu: false }" 
         @scroll.window="scrolled = window.pageYOffset > 20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-[2rem] transition-all duration-300 px-6 py-4 flex justify-between items-center relative"
                 :class="scrolled || mobileMenu ? 'premium-glass shadow-2xl py-3 mt-0 mb-4' : 'bg-transparent'">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-lg shadow-[#0077B6]/30 group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tighter transition-colors duration-300"
                              :class="scrolled || mobileMenu ? 'text-[#03045E]' : 'text-white'">Veri<span class="text-[#00B4D8]">Cult</span></span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ route('beranda') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Beranda</a>
                    <a href="{{ route('tentang') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Tentang</a>
                    <a href="{{ route('fitur') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Fitur</a>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#00B4D8]' : 'text-white'">Profil Budaya</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <div class="hidden sm:flex items-center gap-3 sm:gap-4 md:gap-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white px-6 md:px-8 py-2.5 rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 hover:shadow-xl hover:scale-105 transition-all duration-300">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                                   :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-white text-[#03045E] px-6 md:px-8 py-2.5 rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.2em] shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-slate-100">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden transition-colors duration-300 p-2 rounded-xl"
                            :class="scrolled || mobileMenu ? 'text-[#03045E] hover:bg-[#F8FAFC]' : 'text-white hover:bg-white/10'"
                            @click="mobileMenu = !mobileMenu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenu">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenu" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Navigation Dropdown -->
                <div class="absolute top-full left-0 right-0 mt-2 p-4 premium-glass rounded-[2rem] shadow-2xl md:hidden origin-top transition-all duration-300"
                     x-show="mobileMenu"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     x-cloak>
                    <div class="flex flex-col space-y-4 p-4 text-center">
                        <a href="{{ route('beranda') }}" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Beranda</a>
                        <a href="{{ route('tentang') }}" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Tentang</a>
                        <a href="{{ route('fitur') }}" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Fitur</a>
                        <a href="{{ route('profil-kebudayaan.index') }}" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Profil Budaya</a>
                        <div class="pt-4 border-t border-[#03045E]/10 flex flex-col space-y-4 sm:hidden">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="premium-gradient text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em]">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-black uppercase tracking-widest text-[#03045E]">Masuk</a>
                                    <a href="{{ route('register') }}" class="bg-white text-[#03045E] py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] border border-[#03045E]/10 shadow-lg">Daftar</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

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
                    <div class="relative min-w-full md:min-w-[200px]">
                        <select name="year" onchange="this.form.submit()" class="w-full bg-white border-2 border-slate-100 rounded-[1.5rem] sm:rounded-[2rem] px-6 py-4 sm:py-5 text-[#03045E] font-black uppercase tracking-widest text-[9px] sm:text-[10px] hover:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none shadow-sm appearance-none cursor-pointer">
                            @if(empty($availableYears))
                                <option value="{{ date('Y') }}">Periode {{ date('Y') }}</option>
                            @else
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $activeYear == $year ? 'selected' : '' }}>
                                        Periode {{ $year }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-6 text-[#0077B6]">
                            <svg class="w-4 h-4" border="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
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
                <div class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50 hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                    <!-- Image Wrapper -->
                    <div class="relative h-64 overflow-hidden">
                        @php $mainImage = $submission->files->first(); @endphp
                        @if($mainImage)
                            <img src="{{ Storage::url($mainImage->file_path) }}" alt="{{ $submission->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
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
                    <div class="p-6 sm:p-8 flex flex-col flex-grow">
                        <h3 class="text-lg sm:text-xl font-black text-[#03045E] mb-3 line-clamp-1 capitalize">{{ $submission->name }}</h3>
                        <p class="text-slate-500 text-xs sm:text-sm font-medium line-clamp-3 mb-6 leading-relaxed">
                            {{ $submission->description }}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ $submission->address }}</span>
                            </div>
                            <a href="{{ route('profil-kebudayaan.show', $submission->slug) }}" 
                               class="text-[#0077B6] font-black text-[10px] uppercase tracking-widest hover:translate-x-1 transition-transform flex items-center gap-2">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
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
