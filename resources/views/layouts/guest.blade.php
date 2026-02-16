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
                
                <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white w-full">
                    <div class="max-w-md space-y-8">
                        <!-- Logo & Brand -->
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-2xl mb-6 shadow-2xl shadow-[#00B4D8]/50 border-2 border-white/20">
                                <svg class="w-11 h-11 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h1 class="text-4xl font-bold mb-3 tracking-tight">VeriCult</h1>
                            <p class="text-[#CAF0F8] text-lg font-medium">Sistem Verifikasi Kebudayaan Digital</p>
                        </div>
                        
                        <div class="h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
                        
                        <!-- Features -->
                        <div class="space-y-4">
                            <div class="feature-badge rounded-xl p-4 transition-all duration-300 hover:bg-white/20">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <svg class="w-6 h-6 text-[#03045E]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-white mb-1">Keamanan Terjamin</h3>
                                        <p class="text-sm text-[#CAF0F8] leading-relaxed">Enkripsi tingkat tinggi untuk melindungi data budaya Anda</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-badge rounded-xl p-4 transition-all duration-300 hover:bg-white/20">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#90E0EF] to-[#ADE8F4] rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <svg class="w-6 h-6 text-[#03045E]" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-white mb-1">Validasi Profesional</h3>
                                        <p class="text-sm text-[#CAF0F8] leading-relaxed">Tim validator berpengalaman dan tersertifikasi</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feature-badge rounded-xl p-4 transition-all duration-300 hover:bg-white/20">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#ADE8F4] to-[#CAF0F8] rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <svg class="w-6 h-6 text-[#03045E]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-white mb-1">Sertifikasi Digital</h3>
                                        <p class="text-sm text-[#CAF0F8] leading-relaxed">Sertifikat resmi terverifikasi secara otomatis</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badge -->
                        <div class="text-center pt-6">
                            <div class="inline-flex items-center space-x-2 text-[#90E0EF] text-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Dipercaya oleh 300+ Institusi Budaya</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gradient-to-br from-[#F8FAFC] via-white to-[#EFF6FF]">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8">
                    <a href="/" class="flex items-center justify-center space-x-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-xl shadow-[#0077B6]/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-[#03045E]">Veri<span class="text-[#0077B6]">Cult</span></span>
                    </a>
                </div>

                <!-- Back to Home Link -->
                <div class="w-full max-w-md mb-6">
                    <a href="/" class="inline-flex items-center text-sm text-[#0077B6] hover:text-[#023E8A] font-medium transition-colors duration-200 group">
                        <svg class="w-4 h-4 mr-2 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>

                <div class="w-full max-w-md">
                    <div class="glass-card shadow-2xl shadow-[#0077B6]/5 rounded-2xl p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} VeriCult. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </body>
</html>
