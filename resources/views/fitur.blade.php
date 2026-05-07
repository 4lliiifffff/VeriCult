<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_fitur'] ?? 'Fitur - VeriCult' }}</title>
    <meta name="description" content="{{ $site_seo['desc_fitur'] ?? 'Fitur Utama Sistem Verifikasi Kebudayaan Digital VeriCult' }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 20% 70%, rgba(3, 4, 94, 0.05) 0%, transparent 50%),
                        #FFFFFF;
        }
        .reveal {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.2, 0, 0.2, 1), transform 0.8s cubic-bezier(0.2, 0, 0.2, 1);
            will-change: transform, opacity;
        }
        .reveal-up { transform: translateY(30px); }
        .reveal-visible { opacity: 1; transform: translate(0, 0); }
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
<body class="antialiased font-sans bg-white text-slate-900">
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero -->
    <section class="hero-gradient pt-32 pb-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-1.5 bg-slate-50 rounded-full border border-slate-100 text-[#0077B6] text-[10px] font-bold uppercase tracking-[0.2em] mb-8">
                Sistem & Kapabilitas
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-[#03045E] mb-6 tracking-tight leading-[1.1]">
                {!! $content['hero_title'] ?? 'Fitur Unggulan Untuk<br><span class="text-[#0077B6]">Efisiensi Verifikasi</span>' !!}
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-normal leading-relaxed">
                {{ $content['hero_subtitle'] ?? 'VeriCult menghadirkan ekosistem digital yang komprehensif untuk mendata, memvalidasi, dan melindungi aset budaya bangsa.' }}
            </p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $features = [
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>', 'title' => 'Input Digital', 'desc' => 'Ajukan objek budaya dengan data input yang mudah & terstruktur.'],
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'title' => 'Berjenjang', 'desc' => 'Metode validasi bertahap untuk memastikan keabsahan data.'],
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path></svg>', 'title' => 'Monitoring', 'desc' => 'Pantau status pengajuan secara real-time di dashboard anda.'],
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806"></path></svg>', 'title' => 'Sertifikasi', 'desc' => 'Dapatkan sertifikat resmi digital setelah lolos verifikasi akhir.'],
                    ];
                @endphp

                @foreach($features as $feature)
                <div class="bg-white p-10 rounded-[2rem] border border-slate-100 card-shadow reveal reveal-up">
                    <div class="w-14 h-14 bg-[#00B4D8]/5 rounded-2xl flex items-center justify-center mb-8 text-[#0077B6]">
                        {!! $feature['icon'] !!}
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-4 tracking-tight">{{ $feature['title'] }}</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        {{ $feature['desc'] }}
                    </p>
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
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
