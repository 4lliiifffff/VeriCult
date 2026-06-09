<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_beranda'] ?? 'VeriCult - Sistem Verifikasi Kebudayaan Digital' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="description" content="{{ $site_seo['desc_beranda'] ?? 'Platform digital terintegrasi untuk pengajuan dan validasi objek kebudayaan Indonesia.' }}">

    <!-- PWA -->
    @include('partials.pwa-head')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 20% 70%, rgba(3, 4, 94, 0.05) 0%, transparent 50%),
                        #FFFFFF;
        }
        .reveal {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.2, 0, 0.2, 1), transform 0.8s cubic-bezier(0.2, 0, 0.2, 1);
            will-change: transform, opacity;
        }
        .reveal-up { transform: translateY(30px); }
        .reveal-visible {
            opacity: 1;
            transform: translate(0, 0);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-shadow:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-slate-900 selection:bg-[#00B4D8] selection:text-white">

    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero Section -->
    <section class="hero-gradient min-h-[90vh] flex items-center pt-24 md:pt-32 relative overflow-hidden">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12 sm:py-16 md:py-28 text-center reveal reveal-up">
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold text-[#03045E] mb-4 sm:mb-6 leading-[1.1] tracking-tight">
                {!! $content['hero_title'] ?? 'Lestarikan Budaya<br><span class="text-[#0077B6]">Melalui Verifikasi Digital</span>' !!}
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl text-slate-500 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed font-normal">
                {{ $content['hero_subtitle'] ?? 'Platform digital terintegrasi untuk pengajuan dan validasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat.' }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="bg-[#03045E] text-white px-10 py-4 rounded-lg font-bold text-sm hover:bg-[#023E8A] transition-all duration-300 shadow-lg shadow-blue-900/20 transform hover:scale-[1.02] flex items-center justify-center group">
                    {{ $content['cta_primary'] ?? 'Ajukan Objek' }}
                    <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="{{ route('profil-kebudayaan.index') }}" class="bg-white text-slate-600 border border-slate-200 px-10 py-4 rounded-lg font-bold text-sm hover:bg-slate-50 transition-all duration-300 flex items-center justify-center">
                    {{ $content['cta_secondary'] ?? 'Jelajahi Profil' }}
                </a>
            </div>
        </div>
    </section>

    <!-- Cultural Profile Gallery Section -->
    <section class="py-16 md:py-24 bg-[#FCFDFF] border-y border-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 sm:mb-16 reveal reveal-up">
                <div class="max-w-2xl">
                    <div class="text-[#0077B6] text-[11px] font-bold uppercase tracking-[0.3em] mb-4">Profil Kebudayaan</div>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-[#03045E] mb-4 sm:mb-6 tracking-tight">
                        {{ $content['gallery_title'] ?? 'Warisan Budaya Terverifikasi' }}
                    </h2>
                    <p class="text-slate-500 text-lg">
                        {{ $content['gallery_subtitle'] ?? 'Jelajahi kekayaan budaya Nusantara yang telah melewati proses verifikasi berjenjang.' }}
                    </p>
                </div>
                <div class="mt-8 md:mt-0">
                    <a href="{{ route('profil-kebudayaan.index') }}" class="inline-flex items-center text-sm font-bold text-[#0077B6] hover:text-[#03045E] transition-colors group">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            @if($recentDiscoveries->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentDiscoveries as $item)
                <a href="{{ route('profil-kebudayaan.show', $item->slug) }}" class="bg-white rounded-2xl border border-slate-100 card-shadow overflow-hidden flex flex-col reveal reveal-up">
                    <div class="aspect-[4/3] bg-slate-100 relative overflow-hidden">
                        @php
                            $mainImage = $item->files->first(function($file) {
                                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
                            });
                            $mainVideo = !$mainImage ? $item->files->first(function($file) {
                                return strtolower($file->file_type) === 'video';
                            }) : null;
                        @endphp
                        @if($mainImage)
                            <img src="{{ $mainImage->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @elseif($mainVideo)
                            <video src="{{ $mainVideo->url }}" autoplay loop muted playsinline class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"></video>
                            <div class="absolute inset-0 flex items-center justify-center z-20 pointer-events-none">
                                <div class="w-10 h-10 bg-black/40 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                                    <svg class="w-4 h-4 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur shadow-sm rounded-lg text-[9px] font-bold text-[#0077B6] uppercase tracking-wider border border-slate-100">
                                {{ ucfirst(str_replace('_', ' ', $item->category)) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-[#03045E] mb-2 leading-tight line-clamp-2">{{ $item->name }}</h3>
                        <div class="flex items-center text-slate-400 text-[11px] font-medium mt-auto">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $item->address }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200 reveal reveal-up">
                <p class="text-slate-400 font-medium">Belum ada profil budaya yang dipublikasikan.</p>
            </div>
            @endif
        </div>
    </section>



    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-[#03045E] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="grid grid-cols-4 md:grid-cols-8 h-full">
                @for($i=0; $i<64; $i++)
                    <div class="border-[0.5px] border-white/20"></div>
                @endfor
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal reveal-up">
            <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-white mb-6 md:mb-8 leading-tight tracking-tight">
                {!! $content['cta_bottom_title'] ?? 'Siap Melestarikan Warisan<br><span class="text-[#00B4D8]">Budaya Melalui VeriCult?</span>' !!}
            </h2>
            <p class="text-base sm:text-lg text-slate-300 mb-10 md:mb-12 max-w-2xl mx-auto">
                {{ $content['cta_bottom_subtitle'] ?? 'Bergabunglah dengan komunitas pengusul lainnya dan pastikan setiap warisan budaya tervalidasi dengan standar tertinggi.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-[#03045E] px-12 py-4 rounded-lg font-bold text-sm hover:bg-[#00B4D8] transition-all duration-300 shadow-xl shadow-blue-500/20">
                    Mulai Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Reveal Animations Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>

    <!-- PWA Install Banner -->
    @include('partials.pwa-install-banner')
</body>
</html>
