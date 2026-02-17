<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VeriCult Admin') }} - Super Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F8FAFC]" x-data="{ 
        sidebarOpen: false, 
        sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true',
        toggleMinimize() {
            this.sidebarMinimized = !this.sidebarMinimized;
            localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
        }
    }">
        <div class="flex h-screen overflow-hidden">
            <!-- Mobile Sidebar Backdrop -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden backdrop-blur-sm"
                 style="display: none;"></div>

            <!-- Sidebar -->
            @include('super-admin.partials.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
                 :class="sidebarMinimized ? 'lg:pl-20' : 'lg:pl-64'">
                <!-- Navbar -->
                @include('super-admin.partials.navbar')

                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F8FAFC] p-6">
                    @if (isset($header))
                        <header class="mb-6">
                            <h1 class="text-2xl font-bold text-[#0077B6]">{{ $header }}</h1>
                        </header>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
