<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_beranda'] ?? 'VeriCult - Sistem Verifikasi Kebudayaan Digital' }}</title>
    <meta name="description" content="{{ $site_seo['desc_beranda'] ?? 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia.' }}">
    
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

        /* Animation Classes - Optimized for performance */
        .reveal {
            opacity: 0;
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            will-change: transform, opacity;
        }
        .reveal-up {
            transform: translateY(20px);
        }
        .reveal-left {
            transform: translateX(-20px);
        }
        .reveal-right {
            transform: translateX(20px);
        }
        .reveal-visible {
            opacity: 1;
            transform: translate(0, 0);
            will-change: auto;
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

    <!-- Hero Section -->
    <section class="premium-gradient min-h-screen relative flex items-center pt-24 md:pt-32 overflow-hidden">
        <!-- Hero Pattern & Glow -->
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute -top-24 -right-1/4 w-[400px] h-[400px] bg-[#00B4D8] rounded-full blur-[80px] opacity-15"></div>
        <div class="absolute -bottom-24 -left-1/4 w-[400px] h-[400px] bg-[#48CAE4] rounded-full blur-[80px] opacity-15"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="text-left reveal reveal-left">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-xl rounded-2xl text-white text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] mb-10 border border-white/20 shadow-2xl">
                        <span class="w-2 h-2 bg-[#00B4D8] rounded-full mr-3"></span>
                        {{ $content['hero_badge'] ?? 'Sistem Verifikasi Kebudayaan Terpercaya' }}
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="text-3xl sm:text-4xl md:text-7xl font-black text-white mb-6 sm:mb-8 leading-[1.1] tracking-tighter">
                        {!! $content['hero_title'] ?? 'Lestarikan Budaya<br>Melalui Verifikasi Digital' !!}
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="text-sm sm:text-base md:text-xl text-[#CAF0F8]/80 mb-8 sm:mb-12 max-w-xl leading-relaxed font-medium">
                        {{ $content['hero_subtitle'] ?? 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat.' }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                        <a href="{{ route('login') }}" class="bg-white text-[#03045E] px-8 md:px-10 py-4 md:py-5 rounded-2xl sm:rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] hover:bg-[#CAF0F8] transition-all duration-300 shadow-2xl shadow-blue-900/40 transform hover:scale-105 flex items-center justify-center group w-full sm:w-auto">
                            {{ $content['cta_primary'] ?? 'Ajukan Objek' }}
                            <svg class="w-5 h-5 ml-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('profil-kebudayaan.index') }}" class="bg-white/10 backdrop-blur-xl text-white px-8 md:px-10 py-4 md:py-5 rounded-2xl sm:rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] hover:bg-white/20 transition-all duration-300 border border-white/20 flex items-center justify-center group w-full sm:w-auto">
                            {{ $content['cta_secondary'] ?? 'Jelajahi Profil Budaya' }}
                        </a>
                    </div>
                </div>

                <!-- Hero Image/Element Area -->
                <div class="relative hidden lg:block reveal reveal-right">
                    <div class="relative z-10">
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

    <!-- Cultural Profile Gallery Section -->
    <section class="py-24 md:py-32 bg-[#F8FAFC] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 md:mb-24 reveal reveal-up">
                <div class="inline-flex items-center px-4 py-1.5 bg-[#03045E]/5 rounded-full text-[#03045E] text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                    Profil Kebudayaan
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-[#03045E] mb-6 tracking-tighter">
                   {{ $content['gallery_title'] ?? 'Warisan Budaya Terverifikasi' }}
                </h2>
                <p class="text-base md:text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    {{ $content['gallery_subtitle'] ?? 'Jelajahi kekayaan budaya Nusantara yang telah melewati proses verifikasi berjenjang dan diakui keabsahannya.' }}
                </p>
            </div>

            @if($recentDiscoveries->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-16">
                @foreach($recentDiscoveries as $item)
                <a href="{{ route('profil-kebudayaan.show', $item->slug) }}" class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal reveal-up">
                    <!-- Image/Thumbnail -->
                    <div class="h-48 md:h-56 bg-gradient-to-br from-[#03045E] to-[#0077B6] relative overflow-hidden">
                        @if($item->files->first())
                            <img src="{{ $item->files->first()->url }}" 
                                 alt="{{ $item->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-1.5 bg-white/20 backdrop-blur-xl rounded-full text-white text-[9px] font-black uppercase tracking-[0.2em] border border-white/30">
                                {{ ucfirst(str_replace('_', ' ', $item->category)) }}
                            </span>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="p-6 md:p-8">
                        <h3 class="text-sm md:text-base font-black text-[#03045E] mb-2 tracking-tight group-hover:text-[#0077B6] transition-colors line-clamp-2">{{ $item->name }}</h3>
                        <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $item->address }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 reveal reveal-up">
                <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-slate-400 font-bold text-sm">Belum ada objek budaya yang dipublikasikan.</p>
            </div>
            @endif

            <!-- View All Button -->
            <div class="text-center reveal reveal-up">
                <a href="{{ route('profil-kebudayaan.index') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-white rounded-[2rem] border-2 border-slate-100 text-[#03045E] font-black text-[10px] md:text-xs uppercase tracking-[0.25em] hover:border-[#0077B6] hover:text-[#0077B6] hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group">
                    Lihat Semua Profil Budaya
                    <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-24 md:py-32 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 overflow-hidden lg:overflow-visible">
            <div class="premium-gradient rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-16 lg:p-24 shadow-2xl relative overflow-hidden reveal reveal-up">
                <!-- Background Pattern -->
                <div class="absolute inset-0 hero-pattern opacity-10"></div>
                <div class="absolute top-0 right-0 w-[30rem] md:w-[40rem] h-[30rem] md:h-[40rem] bg-white/5 rounded-full -mr-24 md:-mr-48 -mt-24 md:-mt-48 blur-3xl"></div>
                
                <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-10 md:gap-12 lg:gap-16 text-center text-white">
                    <div class="space-y-4">
                        <div class="text-[9px] sm:text-[10px] md:text-xs font-black uppercase tracking-[0.4em] sm:tracking-[0.5em] text-white/60">Total Objek</div>
                        <div class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tighter tabular-nums">{{ $stats['total'] }}</div>
                        <p class="text-[9px] sm:text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Warisan Budaya</p>
                    </div>
                    <div class="space-y-4 border-y sm:border-y-0 sm:border-x border-white/10 py-10 sm:py-0">
                        <div class="text-[9px] sm:text-[10px] md:text-xs font-black uppercase tracking-[0.4em] sm:tracking-[0.5em] text-white/60">Tervalidasi</div>
                        <div class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tighter tabular-nums">{{ $stats['published'] }}</div>
                        <p class="text-[9px] sm:text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Objek Terverifikasi</p>
                    </div>
                    <div class="space-y-4">
                        <div class="text-[9px] sm:text-[10px] md:text-xs font-black uppercase tracking-[0.4em] sm:tracking-[0.5em] text-white/60">Pengusul</div>
                        <div class="text-4xl sm:text-5xl md:text-7xl font-black tracking-tighter tabular-nums">{{ $stats['users'] }}</div>
                        <p class="text-[9px] sm:text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#90E0EF]">Kontributor Aktif</p>
                    </div>
                </div>

                <!-- Footer Summary Card Inside Stats -->
                <div class="mt-16 md:mt-20 bg-white/10 backdrop-blur-3xl rounded-[1.5rem] md:rounded-[2.5rem] p-6 md:p-10 border border-white/20 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center items-center">
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">{{ $stats['pending'] }}</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Pending Review</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">{{ $stats['revision'] }}</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Dalam Revisi</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-white">{{ $stats['validators'] }}</div>
                        <div class="text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] text-white/50">Validator Aktif</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-black text-[#90E0EF]">100%</div>
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
                {!! $content['cta_bottom_title'] ?? 'Siap Melestarikan Warisan<br><span class="text-[#0077B6]">Budaya Melalui VeriCult?</span>' !!}
            </h2>
            <p class="text-base md:text-lg text-slate-500 mb-12 font-medium leading-relaxed">
                {{ $content['cta_bottom_subtitle'] ?? 'Bergabunglah dengan komunitas pengusul lainnya dan pastikan setiap warisan budaya tervalidasi dengan standar tertinggi.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center">
                <a href="{{ route('register') }}" class="premium-gradient text-white px-8 md:px-12 py-4 md:py-5 rounded-2xl md:rounded-[2.5rem] font-black text-[10px] md:text-xs uppercase tracking-[0.3em] shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transition-all duration-300 flex items-center justify-center w-full sm:w-auto">
                    Mulai Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Reveal Animations Script (Optimized) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -30px 0px' });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
