<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_tentang'] ?? 'Tentang - VeriCult' }}</title>
    <meta name="description" content="{{ $site_seo['desc_tentang'] ?? 'Tentang VeriCult - Sistem Verifikasi Kebudayaan Digital Indonesia' }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .premium-gradient { background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%); }
        .premium-glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .hero-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .reveal { opacity: 0; transition: opacity 0.6s ease-out, transform 0.6s ease-out; will-change: transform, opacity; }
        .reveal-up { transform: translateY(20px); }
        .reveal-left { transform: translateX(-20px); }
        .reveal-right { transform: translateX(20px); }
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
                       :class="scrolled || mobileMenu ? 'text-[#00B4D8]' : 'text-white'">Tentang</a>
                    <a href="{{ route('fitur') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Fitur</a>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110"
                       :class="scrolled || mobileMenu ? 'text-[#03045E] hover:text-[#00B4D8]' : 'text-white/80 hover:text-white'">Profil Budaya</a>
                </div>
                
                <div class="flex items-center space-x-4 md:space-x-6">
                    <div class="hidden sm:flex items-center space-x-4 md:space-x-6">
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="premium-gradient pt-40 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute -top-24 -right-1/4 w-[400px] h-[400px] bg-[#00B4D8] rounded-full blur-[80px] opacity-15"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-xl rounded-2xl text-white text-[10px] font-black uppercase tracking-[0.3em] mb-8 border border-white/20">
                <span class="w-2 h-2 bg-[#00B4D8] rounded-full mr-3"></span>
                {{ $content['hero_badge'] ?? 'Tentang Platform' }}
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter leading-[1.1]">{!! $content['hero_title'] ?? 'Misi Kami Untuk<br>Pelestarian Budaya Indonesia' !!}</h1>
            <p class="text-base md:text-xl text-[#CAF0F8]/80 max-w-2xl mx-auto font-medium leading-relaxed">
                {{ $content['hero_subtitle'] ?? 'VeriCult adalah sistem digital inovatif yang dirancang untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia.' }}
            </p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-24 md:py-32 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="relative reveal reveal-left">
                    <div class="premium-glass rounded-[3rem] p-10 shadow-2xl relative z-10 overflow-hidden">
                        <div class="relative z-10 space-y-8">
                            <div class="flex items-center space-x-6 p-6 rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-14 h-14 bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-900/20">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Pengajuan Digital</h4>
                                    <p class="text-[10px] text-[#03045E]/60 font-bold uppercase tracking-widest">Efisien, transparan & terdata</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6 p-6 rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-14 h-14 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/20">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Validasi Berjenjang</h4>
                                    <p class="text-[10px] text-[#03045E]/60 font-bold uppercase tracking-widest">Verifikasi multi-level akurat</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6 p-6 rounded-3xl bg-white/50 border border-white/40 shadow-sm hover:shadow-md transition-all">
                                <div class="w-14 h-14 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-cyan-400/20">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-1">Sertifikasi Digital</h4>
                                    <p class="text-[10px] text-[#03045E]/60 font-bold uppercase tracking-widest">Sertifikat terverifikasi sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-right">
                    <h2 class="text-3xl md:text-5xl font-black text-[#03045E] mb-8 leading-[1.2] tracking-tighter">
                        {!! $content['about_title'] ?? 'Mengapa<br><span class="text-[#0077B6]">VeriCult?</span>' !!}
                    </h2>
                    <p class="text-base md:text-lg text-slate-600 mb-8 leading-relaxed font-medium">
                        {{ $content['about_description'] ?? 'VeriCult adalah platform digital terintegrasi yang dirancang khusus untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia. Kami berkomitmen menjaga otentisitas data melalui teknologi mutakhir dan sistem verifikasi berjenjang.' }}
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start bg-[#F8FAFC] p-8 rounded-[2rem] border border-slate-100 transition-all hover:bg-white hover:shadow-xl group">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                                <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-2">Verifikasi Akurat</h3>
                                <p class="text-slate-500 text-sm leading-relaxed font-medium">Setiap objek budaya melalui proses validasi berjenjang oleh tim ahli yang tersertifikasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start bg-[#F8FAFC] p-8 rounded-[2rem] border border-slate-100 transition-all hover:bg-white hover:shadow-xl group">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                                <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xs font-black text-[#03045E] uppercase tracking-[0.2em] mb-2">Aman & Transparan</h3>
                                <p class="text-slate-500 text-sm leading-relaxed font-medium">Seluruh data pengajuan terdokumentasi dengan aman dan dapat dilacak secara real-time.</p>
                            </div>
                        </div>
                    </div>
                </div>
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
