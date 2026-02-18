<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .auth-pattern {
                background: linear-gradient(135deg, #03045E 0%, #023E8A 35%, #0077B6 100%);
                position: relative;
            }
            
            .auth-pattern::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: 
                    radial-gradient(circle at 20% 50%, rgba(0, 180, 216, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(72, 202, 228, 0.1) 0%, transparent 50%),
                    url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2300B4D8' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.4;
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .feature-badge {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side - Branding (Desktop Only) -->
            <div class="hidden lg:flex lg:w-1/2 auth-pattern relative overflow-hidden">
                <!-- Decorative Blur Elements -->
                <div class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-br from-[#00B4D8]/20 to-transparent rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-gradient-to-tr from-[#48CAE4]/15 to-transparent rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white w-full text-center lg:text-left">
                    <div class="max-w-md space-y-12">
                        <!-- Logo & Brand -->
                        <div class="space-y-6">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-[#00B4D8] to-[#0077B6] rounded-[2rem] shadow-2xl shadow-blue-400/30 border border-white/20 group hover:rotate-6 transition-transform duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-5xl font-black mb-3 tracking-tighter">Veri<span class="text-[#00B4D8]">Cult</span></h1>
                                <p class="text-[#CAF0F8] text-sm font-black uppercase tracking-[0.3em] opacity-80">Pelestarian Budaya Digital</p>
                            </div>
                        </div>
                        
                        <div class="h-1 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                        
                        <!-- Features -->
                        <div class="space-y-6">
                            <div class="feature-badge rounded-[1.5rem] p-6 transition-all duration-500 hover:scale-[1.02] hover:bg-white/10 group">
                                <div class="flex items-center space-x-6">
                                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/20 shadow-xl self-start">
                                        <svg class="w-7 h-7 text-[#48CAE4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-white text-xs uppercase tracking-widest mb-1">Keamanan Data</h3>
                                        <p class="text-sm text-[#CAF0F8] font-bold opacity-70 leading-relaxed">Proteksi enkripsi modern untuk aset budaya digital Anda.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-badge rounded-[1.5rem] p-6 transition-all duration-500 hover:scale-[1.02] hover:bg-white/10 group">
                                <div class="flex items-center space-x-6">
                                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/20 shadow-xl self-start">
                                        <svg class="w-7 h-7 text-[#48CAE4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-white text-xs uppercase tracking-widest mb-1">Validasi Ahli</h3>
                                        <p class="text-sm text-[#CAF0F8] font-bold opacity-70 leading-relaxed">Proses verifikasi oleh tim ahli kebudayaan tersertifikasi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badge -->
                        <div class="pt-8">
                            <div class="inline-flex items-center space-x-3 px-6 py-3 rounded-full bg-white/5 border border-white/10 text-white/60 text-[10px] font-black uppercase tracking-[0.2em]">
                                <div class="flex -space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-400 border-2 border-[#03045E]"></div>
                                    <div class="w-6 h-6 rounded-full bg-cyan-400 border-2 border-[#03045E]"></div>
                                    <div class="w-6 h-6 rounded-full bg-indigo-400 border-2 border-[#03045E]"></div>
                                </div>
                                <span>300+ Institusi Bergabung</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex-1 flex flex-col justify-center items-center p-8 sm:p-20 bg-[#F8FAFC]">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12">
                    <a href="/" class="flex flex-col items-center gap-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-[1.5rem] flex items-center justify-center shadow-2xl shadow-blue-900/30">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-black text-[#03045E] tracking-tighter">Veri<span class="text-[#0077B6]">Cult</span></h1>
                    </a>
                </div>

                <!-- Back to Home Link -->
                <div class="w-full max-w-md mb-8">
                    <a href="/" class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-[#0077B6] transition-all duration-300 group">
                        <svg class="w-4 h-4 mr-3 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Beranda Utama
                    </a>
                </div>

                <div class="w-full max-w-md">
                    <div class="bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] rounded-[2.5rem] p-10 sm:p-14 border border-slate-50 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent opacity-50 rounded-bl-full"></div>
                        <div class="relative z-10">
                            {{ $slot }}
                        </div>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="mt-12 text-center">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">&copy; {{ date('Y') }} VeriCult &bull; Digital Heritage System</p>
                </div>
            </div>
        </div>
    </body>
</html>
