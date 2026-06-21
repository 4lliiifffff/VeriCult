<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_fitur'] ?? 'Fitur - VeriCult' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=1.1" type="image/x-icon">
    <meta name="description" content="{{ $site_seo['desc_fitur'] ?? 'Fitur Utama Sistem Verifikasi Kebudayaan Digital VeriCult' }}">
    
    <!-- PWA -->
    @include('partials.pwa-head')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 20% 70%, rgba(3, 4, 94, 0.05) 0%, transparent 50%),
                        #FFFFFF;
        } */
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
    <section class="hero-gradient pt-40 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMyw0LDk0LDAuMDMpIi8+PC9zdmc+')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-blue-100 text-[#0077B6] text-[10px] font-black uppercase tracking-[0.2em] mb-8 shadow-sm shadow-blue-500/5 reveal reveal-up">
                Sistem & Kapabilitas
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-[#03045E] mb-6 tracking-tight leading-[1.1] reveal reveal-up" style="transition-delay: 100ms;">
                Fitur Unggulan Untuk<br>
                <span class="text-[#0077B6] relative inline-block">Efisiensi Verifikasi
                     
                </span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed reveal reveal-up" style="transition-delay: 200ms;">
                VeriCult menghadirkan ekosistem digital yang komprehensif untuk mendata, memvalidasi, dan melindungi aset budaya bangsa.
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
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'title' => 'Monitoring', 'desc' => 'Pantau status pengajuan secara real-time di dashboard anda.'],
                        ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>', 'title' => 'Keamanan Data', 'desc' => 'Data budaya terlindungi dengan sistem keamanan digital berlapis.'],
                    ];
                @endphp

                @foreach($features as $idx => $feature)
                <div class="bg-white p-10 sm:p-12 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-500 reveal reveal-up group" style="transition-delay: {{ $idx * 50 }}ms;">
                    <div class="w-16 h-16 bg-blue-50/50 rounded-2xl flex items-center justify-center mb-8 text-[#0077B6] group-hover:bg-gradient-to-br group-hover:from-[#03045E] group-hover:to-[#0077B6] group-hover:text-white transition-all duration-500 shadow-sm">
                        {!! $feature['icon'] !!}
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E] mb-4 tracking-tight group-hover:text-[#0077B6] transition-colors">{{ $feature['title'] }}</h3>
                    <p class="text-slate-500 leading-relaxed font-medium text-sm">
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

    <!-- PWA Install Banner -->
    @include('partials.pwa-install-banner')
</body>
</html>
