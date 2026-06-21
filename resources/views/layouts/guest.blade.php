<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VeriCult') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=1.1" type="image/x-icon">

        <!-- PWA -->
        @include('partials.pwa-head')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Outfit', sans-serif; }
            .auth-bg {
                background-color: #ffffff;
                background-image: 
                    radial-gradient(circle at 0% 0%, rgba(144, 224, 239, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at 100% 100%, rgba(0, 119, 182, 0.05) 0%, transparent 40%);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .reveal {
                opacity: 0;
                transition: all 0.8s cubic-bezier(0.2, 0, 0.2, 1);
            }
            .reveal-visible {
                opacity: 1;
                transform: none;
            }
        </style>
    </head>
    <body class="antialiased text-slate-900 auth-bg">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 sm:p-12">
            <!-- Logo Section -->
            <div class="mb-12 text-center" id="auth-logo">
                <a href="/" class="inline-flex flex-col items-center gap-4 group">
                    <div class="w-16 h-16 bg-[#03045E] rounded-2xl flex items-center justify-center shadow-2xl shadow-blue-900/20 group-hover:scale-110 transition-transform duration-500">
                        <img class="w-12 h-12" src="{{ asset('Logo/Putih/Logo-Sistem-W.png') }}" alt="Logo VeriCult" fetchpriority="high">
                    </div>
                    <h1 class="text-3xl font-bold text-[#03045E] tracking-tight">Veri<span class="text-[#0077B6]">Cult</span></h1>
                </a>
            </div>

            <!-- Content Area -->
            <div class="w-full max-w-xl reveal" id="auth-card">
                <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-8 sm:p-12 border border-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <!-- Subtle Blobs inside card -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#90E0EF]/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-[#0077B6]/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="mt-12 text-center">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                        &copy; {{ date('Y') }} VeriCult &bull; <a href="/" class="hover:text-[#0077B6] transition-colors">Beranda</a>
                    </p>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    document.getElementById('auth-card').classList.add('reveal-visible');
                    document.getElementById('auth-card').style.transform = 'translateY(0)';
                }, 100);
            });
        </script>
        <style>
            #auth-card { transform: translateY(20px); }
        </style>

        <!-- PWA Install Banner -->
        @include('partials.pwa-install-banner')
    </body>
</html>
