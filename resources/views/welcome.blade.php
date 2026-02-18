<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeriCult - Sistem Verifikasi Kebudayaan Digital</title>
    
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
        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px -15px rgba(3, 4, 94, 0.15);
        }

        /* Animation Classes */
        .reveal {
            opacity: 0;
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-up {
            transform: translateY(40px);
        }
        .reveal-left {
            transform: translateX(-40px);
        }
        .reveal-right {
            transform: translateX(40px);
        }
        .reveal-visible {
            opacity: 1;
            transform: translate(0, 0);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F8FAFC;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #0077B6;
            border-radius: 10px;
        }
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
                    <a href="/" class="flex items-center space-x-3 group">
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
                    <a href="#tentang" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Tentang</a>
                    <a href="#fitur" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Fitur</a>
                    <a href="#statistik" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Statistik</a>
                </div>
                
                <!-- Auth Buttons & Mobile Toggle -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <div class="hidden sm:flex items-center space-x-4 md:space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white px-6 md:px-8 py-2.5 rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 hover:shadow-xl hover:scale-105 transition-all duration-300">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                                   :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="bg-white text-[#03045E] px-6 md:px-8 py-2.5 rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.2em] shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                                        Daftar
                                    </a>
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
                        <a href="#tentang" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Tentang</a>
                        <a href="#fitur" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Fitur</a>
                        <a href="#statistik" class="text-sm font-black uppercase tracking-widest text-[#03045E]" @click="mobileMenu = false">Statistik</a>
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

    <!-- Hero Section -->
    <section class="premium-gradient min-h-screen relative flex items-center pt-24 md:pt-32 overflow-hidden">
        <!-- Hero Pattern & Glow -->
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute -top-24 -right-1/4 w-[500px] h-[500px] bg-[#00B4D8] rounded-full blur-[160px] opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-24 -left-1/4 w-[500px] h-[500px] bg-[#48CAE4] rounded-full blur-[160px] opacity-20 animate-pulse delay-700"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="text-left reveal reveal-left">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-xl rounded-2xl text-white text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] mb-10 border border-white/20 shadow-2xl">
                        <span class="w-2 h-2 bg-[#00B4D8] rounded-full mr-3 animate-ping"></span>
                        Sistem Verifikasi Kebudayaan Terpercaya
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="text-4xl md:text-7xl font-black text-white mb-8 leading-[1.1] tracking-tighter">
                        Lestarikan Budaya<br>
                        Melalui <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#90E0EF] to-[#00B4D8]">Verifikasi Digital</span>
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="text-base md:text-xl text-[#CAF0F8]/80 mb-12 max-w-xl leading-relaxed font-medium">
                        Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 md:gap-6">
                        <a href="{{ route('register') }}" class="bg-white text-[#03045E] px-8 md:px-10 py-4 md:py-5 rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] hover:bg-[#CAF0F8] transition-all duration-300 shadow-2xl shadow-blue-900/40 transform hover:scale-105 flex items-center justify-center group">
                            Ajukan Objek
                            <svg class="w-5 h-5 ml-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#fitur" class="bg-white/10 backdrop-blur-xl text-white px-8 md:px-10 py-4 md:py-5 rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] hover:bg-white/20 transition-all duration-300 border border-white/20 flex items-center justify-center group">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <!-- Hero Image/Element Area -->
                <div class="relative hidden lg:block reveal reveal-right">
                    <div class="relative z-10 animate-float">
                        <div class="bg-white/10 backdrop-blur-2xl p-8 rounded-[3rem] border border-white/20 shadow-2xl">
                            <div class="bg-gradient-to-br from-[#0077B6] to-[#03045E] rounded-[2rem] p-10 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                                <div class="relative z-10 flex flex-col items-center text-center">
                                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-xl">
                                         <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-black text-white mb-2 uppercase tracking-widest">Validasi Terjamin</h3>
                                    <p class="text-white/60 text-sm font-bold uppercase tracking-widest">Tervalidasi secara akurat & cepat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Circles -->
                    <div class="absolute -top-10 -left-10 w-24 h-24 bg-[#00B4D8] rounded-full blur-2xl opacity-40"></div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-[#48CAE4] rounded-full blur-3xl opacity-40"></div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Divider -->
         <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
            <svg class="w-full h-16 md:h-24 text-[#F8FAFC] fill-current" preserveAspectRatio="none" viewBox="0 0 1440 320">
                <path d="M0,224L48,218.7C96,213,192,203,288,208C384,213,480,235,576,224C672,213,768,171,864,165.3C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-24 md:py-32 relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="relative order-2 lg:order-1 reveal reveal-left">
                    <div class="premium-glass rounded-[2rem] md:rounded-[3rem] p-6 md:p-10 shadow-2xl relative z-10 overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#0077B6]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <div class="relative z-10 space-y-6 md:space-y-8">
                            <div class="flex items-center space-x-4 md:space-x-6 p-4 md:p-6 rounded-[1.5rem] md:rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-900/20">
                                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[10px] md:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Pengajuan Digital</h4>
                                    <p class="text-[#03045E]/60 text-[9px] md:text-[10px] font-bold uppercase tracking-widest">Efisien, transparan & terdata</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 md:space-x-6 p-4 md:p-6 rounded-[1.5rem] md:rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/20">
                                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[10px] md:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Validasi Berjenjang</h4>
                                    <p class="text-[#03045E]/60 text-[9px] md:text-[10px] font-bold uppercase tracking-widest">Verifikasi multi-level akurat</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 md:space-x-6 p-4 md:p-6 rounded-[1.5rem] md:rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-cyan-400/20">
                                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[10px] md:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Sertifikasi Digital</h4>
                                    <p class="text-[#03045E]/60 text-[9px] md:text-[10px] font-bold uppercase tracking-widest">Sertifikat terverifikasi sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 reveal reveal-right">
                    <div class="inline-flex items-center px-4 py-1.5 bg-[#03045E]/5 rounded-full text-[#03045E] text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                        Tentang Platform
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-[#03045E] mb-8 leading-[1.2] tracking-tighter">
                        Misi Kami Untuk<br>
                        <span class="text-[#0077B6]">Pelestarian Budaya Indonesia</span>
                    </h2>
                    <p class="text-base md:text-lg text-slate-600 mb-8 leading-relaxed font-medium">
                        VeriCult adalah sistem digital inovatif yang dirancang untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia. Kami berkomitmen menjaga otentisitas data melalui teknologi mutakhir.
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start bg-[#F8FAFC] p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] border border-slate-100 transition-all hover:bg-white hover:shadow-xl group">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-[1rem] md:rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4 md:ml-6">
                                <h3 class="text-[10px] md:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-2">Verifikasi Akurat</h3>
                                <p class="text-slate-500 text-xs md:text-sm leading-relaxed font-medium">Setiap objek budaya melalui proses validasi berjenjang oleh tim ahli yang tersertifikasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 md:py-32 bg-[#F8FAFC] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 md:mb-24 reveal reveal-up">
                <div class="inline-flex items-center px-4 py-1.5 bg-[#03045E]/5 rounded-full text-[#03045E] text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                    Fitur Unggulan
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-[#03045E] mb-6 tracking-tighter">
                    Ekosistem <span class="text-[#00B4D8]">Digital Budaya</span>
                </h2>
                <p class="text-base md:text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    Kami menghadirkan fitur-fitur berstandar industri untuk memastikan integritas dan kemudahan dalam pendataan kebudayaan.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Feature Cards -->
                @php
                    $features = [
                        ['icon' => 'M12 4v16m8-8H4', 'title' => 'Input Digital', 'desc' => 'Ajukan objek budaya dengan data input yang mudah & terstruktur.'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Berjenjang', 'desc' => 'Metode validasi bertahap untuk memastikan keabsahan data.'],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10', 'title' => 'Monitoring', 'desc' => 'Pantau status pengajuan secara real-time di dashboard anda.'],
                        ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806', 'title' => 'Sertifikasi', 'desc' => 'Dapatkan sertifikat resmi digital setelah lolos verifikasi akhir.'],
                    ];
                @endphp

                @foreach($features as $f)
                <div class="feature-card bg-white rounded-[2rem] md:rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-sm relative overflow-hidden group reveal reveal-up">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#00B4D8]/5 rounded-full -mr-16 -mt-16 transition-all group-hover:bg-[#00B4D8]/10 group-hover:scale-150"></div>
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-[#F8FAFC] rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $f['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="text-[10px] md:text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-4">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 text-[11px] md:text-sm leading-relaxed font-bold uppercase tracking-widest text-opacity-70">
                        {{ $f['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-24 md:py-32 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 overflow-hidden lg:overflow-visible">
            <div class="premium-gradient rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-16 lg:p-24 shadow-2xl relative overflow-hidden group reveal reveal-up">
                <!-- Background Pattern -->
                <div class="absolute inset-0 hero-pattern opacity-10"></div>
                <div class="absolute top-0 right-0 w-[30rem] md:w-[40rem] h-[30rem] md:h-[40rem] bg-white/5 rounded-full -mr-24 md:-mr-48 -mt-24 md:-mt-48 blur-3xl group-hover:bg-white/10 transition-all duration-700"></div>
                
                <div class="relative z-10 grid md:grid-cols-3 gap-12 lg:gap-16 text-center text-white">
                    <div class="space-y-4">
                        <div class="text-[10px] md:text-xs font-black uppercase tracking-[0.5em] text-white/60">Total Objek</div>
                        <div class="text-5xl md:text-7xl font-black tracking-tighter tabular-nums">1.2k+</div>
                        <p class="text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Warisan Budaya</p>
                    </div>
                    <div class="space-y-4 border-y md:border-y-0 md:border-x border-white/10 py-10 md:py-0">
                        <div class="text-[10px] md:text-xs font-black uppercase tracking-[0.5em] text-white/60">Tervalidasi</div>
                        <div class="text-5xl md:text-7xl font-black tracking-tighter tabular-nums">892</div>
                        <p class="text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Objek Terverifikasi</p>
                    </div>
                    <div class="space-y-4">
                        <div class="text-[10px] md:text-xs font-black uppercase tracking-[0.5em] text-white/60">Pengusul</div>
                        <div class="text-5xl md:text-7xl font-black tracking-tighter tabular-nums">324</div>
                        <p class="text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Kontributor Aktif</p>
                    </div>
                </div>

                <!-- Footer Summary Card Inside Stats -->
                <div class="mt-16 md:mt-20 bg-white/10 backdrop-blur-3xl rounded-[1.5rem] md:rounded-[2.5rem] p-6 md:p-10 border border-white/20 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center items-center">
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">156</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Pending Review</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">89</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Dalam Revisi</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">45</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Validator Aktif</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-[#90E0EF]">98.2%</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 md:py-32 bg-[#F8FAFC]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal reveal-up">
            <div class="inline-flex items-center px-4 py-1.5 bg-[#03045E]/5 rounded-full text-[#03045E] text-[10px] font-black uppercase tracking-[0.2em] mb-10">
                Langkah Berikutnya
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-[#03045E] mb-8 leading-[1.2] tracking-tighter">
                Siap Melestarikan Warisan<br>
                <span class="text-[#0077B6]">Budaya Melalui VeriCult?</span>
            </h2>
            <p class="text-base md:text-lg text-slate-500 mb-12 font-medium leading-relaxed">
                Bergabunglah dengan komunitas pengusul lainnya dan pastikan setiap warisan budaya tervalidasi dengan standar tertinggi.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center px-4">
                <a href="{{ route('register') }}" class="premium-gradient text-white px-8 md:px-12 py-4 md:py-5 rounded-[2rem] md:rounded-[2.5rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transition-all duration-300 flex items-center justify-center">
                    Mulai Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#03045E] text-white pt-16 md:pt-24 pb-12 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 pb-16 md:pb-20 border-b border-white/5">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <a href="/" class="flex items-center space-x-3 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-lg shadow-[#0077B6]/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-white">Veri<span class="text-[#48CAE4]">Cult</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm font-medium">
                        Platform verifikasi digital terpercaya untuk melestarikan dan mengabsahkan kekayaan budaya Nusantara.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-[10px] md:text-xs font-black uppercase tracking-[0.3em] text-white mb-6 md:mb-8">Menu Cepat</h3>
                    <ul class="space-y-3 md:space-y-4">
                        <li><a href="#tentang" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Tentang Kami</a></li>
                        <li><a href="#fitur" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Fitur Teknis</a></li>
                        <li><a href="#statistik" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Data Publik</a></li>
                        <li><a href="{{ route('login') }}" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Masuk Sistem</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-[10px] md:text-xs font-black uppercase tracking-[0.3em] text-white mb-6 md:mb-8">Kontak Resmi</h3>
                    <ul class="space-y-3 md:space-y-4">
                        <li class="flex items-center text-xs md:text-sm font-bold text-slate-400 group">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#00B4D8]/20 group-hover:text-white transition-all text-xs md:text-sm">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            official@vericult.id
                        </li>
                        <li class="flex items-center text-xs md:text-sm font-bold text-slate-400 group">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#00B4D8]/20 group-hover:text-white transition-all text-xs md:text-sm">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            +62 123 4455 6677
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-12 flex flex-col md:flex-row justify-between items-center text-slate-500 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em]">
                <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} VeriCult Platform. All rights reserved.</p>
                <div class="flex space-x-6 md:space-x-10 mt-2 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Security</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Reveal Animations Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        // Optional: unobserve after showing
                        // observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const revealElements = document.querySelectorAll('.reveal');
            revealElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
