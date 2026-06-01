<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_seo['title_tentang'] ?? 'Tentang - VeriCult' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="description" content="{{ $site_seo['desc_tentang'] ?? 'Tentang VeriCult - Sistem Verifikasi Kebudayaan Digital Indonesia' }}">
    
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
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ $content['hero_badge'] ?? 'Tentang Platform' }}
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-[#03045E] mb-6 tracking-tight leading-[1.1] reveal reveal-up" style="transition-delay: 100ms;">
                {!! $content['hero_title'] ?? 'Misi Kami Untuk<br><span class="text-[#0077B6] relative inline-block">Pelestarian Budaya Indonesia </span>' !!}
                
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed reveal reveal-up" style="transition-delay: 200ms;">
                {{ $content['hero_subtitle'] ?? 'VeriCult adalah sistem digital inovatif yang dirancang untuk memfasilitasi proses pengajuan dan validasi objek kebudayaan Indonesia.' }}
            </p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="reveal reveal-up">
                    <div class="bg-white rounded-[3rem] p-10 sm:p-12 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500 space-y-8 relative overflow-hidden group">
                        <div class="absolute -right-20 -top-20 w-56 h-56 bg-blue-50/50 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                        
                        <div class="flex items-center gap-6 relative z-10">
                            <div class="w-16 h-16 bg-blue-50/50 rounded-2xl flex items-center justify-center text-[#0077B6] shadow-sm border border-white group-hover:bg-gradient-to-br group-hover:from-[#03045E] group-hover:to-[#0077B6] group-hover:text-white transition-all duration-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#03045E] mb-1">Pengajuan Digital</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Efisien & Terdata</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 relative z-10">
                            <div class="w-16 h-16 bg-blue-50/50 rounded-2xl flex items-center justify-center text-[#0077B6] shadow-sm border border-white group-hover:bg-gradient-to-br group-hover:from-[#03045E] group-hover:to-[#0077B6] group-hover:text-white transition-all duration-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#03045E] mb-1">Validasi Berjenjang</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Akurasi Terjamin</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="reveal reveal-up" style="transition-delay: 200ms;">
                    <h2 class="text-3xl md:text-4xl lg:text-6xl font-black text-[#03045E] mb-8 tracking-tight leading-tight">
                        {!! str_replace('text-[#0077B6]', 'text-[#0077B6] relative inline-block', $content['about_title'] ?? 'Mengapa<br><span class="text-[#0077B6] relative inline-block">VeriCult?</span>') !!}
                    </h2>
                    <p class="text-lg text-slate-500 mb-10 leading-relaxed font-medium">
                        {{ $content['about_description'] ?? 'VeriCult adalah platform digital terintegrasi yang dirancang khusus untuk memfasilitasi proses pengajuan dan validasi objek kebudayaan Indonesia. Kami berkomitmen menjaga otentisitas data melalui teknologi mutakhir dan sistem verifikasi berjenjang.' }}
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 text-[#0077B6] flex-shrink-0 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-slate-600 font-bold text-sm">Setiap objek budaya melalui proses validasi berjenjang oleh tim ahli yang berpengalaman.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 text-[#0077B6] flex-shrink-0 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-slate-600 font-bold text-sm">Seluruh data pengajuan terdokumentasi dengan aman dan dapat dilacak secara real-time.</p>
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
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
