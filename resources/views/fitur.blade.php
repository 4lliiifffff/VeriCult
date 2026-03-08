<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_fitur'] ?? 'Fitur - VeriCult' }}</title>
    <meta name="description" content="{{ $site_seo['desc_fitur'] ?? 'Fitur unggulan VeriCult - Ekosistem digital budaya Indonesia' }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .premium-gradient { background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%); }
        .premium-glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .hero-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .feature-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .feature-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px -15px rgba(3, 4, 94, 0.15); }
        .reveal { opacity: 0; transition: opacity 0.6s ease-out, transform 0.6s ease-out; will-change: transform, opacity; }
        .reveal-up { transform: translateY(20px); }
        .reveal-visible { opacity: 1; transform: translate(0, 0); will-change: auto; }

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
                
                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ route('beranda') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Beranda</a>
                    <a href="{{ route('tentang') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Tentang</a>
                    <a href="{{ route('fitur') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#00B4D8]' : 'text-white'">Fitur</a>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Profil Budaya</a>
                </div>
                
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

    <!-- Hero -->
    <section class="premium-gradient pt-32 sm:pt-40 pb-16 sm:pb-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute -top-24 -right-1/4 w-[400px] h-[400px] bg-[#00B4D8] rounded-full blur-[80px] opacity-15"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-xl rounded-2xl text-white text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] mb-8 border border-white/20">
                <span class="w-2 h-2 bg-[#00B4D8] rounded-full mr-3"></span>
                {{ $content['hero_badge'] ?? 'Fitur Unggulan' }}
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter leading-[1.1]">{!! $content['hero_title'] ?? 'Ekosistem <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#90E0EF] to-[#00B4D8]">Digital Budaya</span>' !!}</h1>
            <p class="text-sm sm:text-base md:text-xl text-[#CAF0F8]/80 max-w-2xl mx-auto font-medium leading-relaxed">
                {{ $content['hero_subtitle'] ?? 'Kami menghadirkan fitur-fitur berstandar industri untuk memastikan integritas dan kemudahan dalam pendataan kebudayaan.' }}
            </p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-24 md:py-32 bg-[#F8FAFC] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @php
                    $features = [
                        ['icon' => 'M12 4v16m8-8H4', 'title' => 'Input Digital', 'desc' => 'Ajukan objek budaya dengan data input yang mudah & terstruktur.'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Berjenjang', 'desc' => 'Metode validasi bertahap untuk memastikan keabsahan data.'],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10', 'title' => 'Monitoring', 'desc' => 'Pantau status pengajuan secara real-time di dashboard anda.'],
                        ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806', 'title' => 'Sertifikasi', 'desc' => 'Dapatkan sertifikat resmi digital setelah lolos verifikasi akhir.'],
                    ];
                @endphp

                @foreach($features as $f)
                <div class="feature-card bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border border-slate-100 shadow-sm relative overflow-hidden group reveal reveal-up">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#00B4D8]/5 rounded-full -mr-16 -mt-16 transition-all group-hover:bg-[#00B4D8]/10 group-hover:scale-150"></div>
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-[#F8FAFC] rounded-xl sm:rounded-2xl flex items-center justify-center mb-6 sm:mb-8 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $f['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="text-[10px] sm:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-3 sm:mb-4">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed font-bold uppercase tracking-widest text-opacity-70">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('reveal-visible'); obs.unobserve(entry.target); } });
            }, { threshold: 0.15, rootMargin: '0px 0px -30px 0px' });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
