<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_beranda'] ?? 'VeriCult - Sistem Verifikasi Kebudayaan Digital' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="description" content="{{ $site_seo['desc_beranda'] ?? 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia.' }}">

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
        <!-- Abstract Shapes -->
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-[#90E0EF]/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-1/4 -left-20 w-[500px] h-[500px] bg-[#0077B6]/5 rounded-full blur-[120px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12 md:py-20">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-left reveal reveal-up">
                    <!-- Badge -->
                    <!-- <div class="inline-flex items-center px-4 py-1.5 bg-slate-50 rounded-full border border-slate-100 text-[#0077B6] text-[10px] font-bold uppercase tracking-[0.2em] mb-8">
                        <span class="flex h-2 w-2 relative mr-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00B4D8] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00B4D8]"></span>
                        </span>
                        {{ $content['hero_badge'] ?? 'Sistem Verifikasi Kebudayaan Terpercaya' }}
                    </div> -->

                    <!-- Main Heading -->
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-[#03045E] mb-6 leading-[1.1] tracking-tight">
                        {!! $content['hero_title'] ?? 'Lestarikan Budaya<br><span class="text-[#0077B6]">Melalui Verifikasi Digital</span>' !!}
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-lg md:text-xl text-slate-500 mb-10 max-w-2xl leading-relaxed font-normal">
                        {{ $content['hero_subtitle'] ?? 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat.' }}
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
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

                    <!-- Trusted By Section -->
                    <!-- <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-6 opacity-60">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Dipercaya Oleh</p>
                        <div class="flex gap-8 items-center grayscale">
                            <div class="font-black text-xl text-slate-400">KEMENDIKBUD</div>
                            <div class="font-black text-xl text-slate-400">PEMPROV</div>
                            <div class="font-black text-xl text-slate-400">PEMKAB</div>
                        </div>
                    </div> -->
                </div>

                <!-- Hero Graphic Area -->
                <div class="lg:col-span-5 relative hidden lg:block reveal reveal-up" style="transition-delay: 200ms;">
                    <div class="relative">
                        <!-- Main Card -->
                        <div class="bg-white rounded-3xl p-8 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] border border-slate-50 relative z-20">
                            <div class="bg-slate-50 rounded-2xl p-8 mb-6 border border-slate-100 flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-[#00B4D8]/10 rounded-2xl flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-[#03045E] mb-2 tracking-tight">Validasi Terjamin</h3>
                                <p class="text-slate-500 text-sm">Setiap data diverifikasi melalui proses audit digital berjenjang yang transparan.</p>
                            </div>
                            <div class="space-y-4">
                                <div class="h-2 w-full bg-slate-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-[#0077B6] to-[#00B4D8] w-[85%] rounded-full"></div>
                                </div>
                                {{-- <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                    <span>Skor Keabsahan Data</span>
                                    <span class="text-[#0077B6]">85% Sangat Akurat</span>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Decorative floating elements -->
                        <div class="absolute -top-10 -left-10 w-24 h-24 bg-white rounded-2xl shadow-xl flex items-center justify-center p-6 border border-slate-50 z-30 animate-bounce" style="animation-duration: 4s;">
                            <svg class="w-full h-full text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2z"/></svg>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[#03045E] rounded-2xl shadow-2xl flex flex-col items-center justify-center p-6 text-white z-10">
                            <div class="text-2xl font-bold">300+</div>
                            <div class="text-[8px] font-bold uppercase tracking-widest opacity-60">Sertifikat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Profile Gallery Section -->
    <section class="py-24 bg-[#FCFDFF] border-y border-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 reveal reveal-up">
                <div class="max-w-2xl">
                    <div class="text-[#0077B6] text-[11px] font-bold uppercase tracking-[0.3em] mb-4">Profil Kebudayaan</div>
                    <h2 class="text-3xl md:text-5xl font-bold text-[#03045E] mb-6 tracking-tight">
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
                        @endphp
                        @if($mainImage)
                            <img src="{{ $mainImage->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
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

    <!-- Stats Section -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal reveal-up">
                    <div class="text-[#0077B6] text-[11px] font-bold uppercase tracking-[0.3em] mb-4">Statistik Platform</div>
                    <h2 class="text-3xl md:text-5xl font-bold text-[#03045E] mb-8 tracking-tight leading-tight">
                        Ekosistem Digital yang<br>Terus Bertumbuh
                    </h2>
                    <p class="text-slate-500 text-lg mb-10 leading-relaxed">
                        VeriCult menghubungkan institusi, pengusul, dan validator dalam satu alur kerja yang terintegrasi untuk pendataan budaya yang berkelanjutan.
                    </p>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <div class="text-4xl font-bold text-[#03045E] mb-1">{{ $stats['total'] }}</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Objek</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-[#0077B6] mb-1">{{ $stats[\App\Models\CulturalSubmission::STATUS_PUBLISHED] }}</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tervalidasi</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-[#03045E] mb-1">{{ $stats['users'] }}</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kontributor</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-[#00B4D8] mb-1">100%</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akurasi Audit</div>
                        </div>
                    </div>
                </div>
                <div class="reveal reveal-up" style="transition-delay: 200ms;">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 md:p-16 relative overflow-hidden border border-slate-100">
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white rounded-full opacity-50"></div>
                        <div class="relative z-10 space-y-10">
                            <div class="flex items-start gap-6">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[#03045E] uppercase tracking-wide mb-2">Audit Digital Berjenjang</h4>
                                    <p class="text-slate-500 text-xs leading-relaxed uppercase tracking-widest font-bold opacity-70">Memastikan integritas data dari tingkat desa hingga pusat.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[#03045E] uppercase tracking-wide mb-2">Keamanan Aset Budaya</h4>
                                    <p class="text-slate-500 text-xs leading-relaxed uppercase tracking-widest font-bold opacity-70">Enkripsi tingkat tinggi untuk melindungi dokumentasi berharga.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-[#03045E] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="grid grid-cols-8 h-full">
                @for($i=0; $i<64; $i++)
                    <div class="border-[0.5px] border-white/20"></div>
                @endfor
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal reveal-up">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-8 leading-tight tracking-tight">
                {!! $content['cta_bottom_title'] ?? 'Siap Melestarikan Warisan<br><span class="text-[#00B4D8]">Budaya Melalui VeriCult?</span>' !!}
            </h2>
            <p class="text-slate-300 text-lg mb-12 max-w-2xl mx-auto">
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
</body>
</html>
