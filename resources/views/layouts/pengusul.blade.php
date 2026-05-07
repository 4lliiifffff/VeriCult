<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VeriCult') }} - Pengusul</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <!-- Flatpickr Date Picker -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
        <style>
            .flatpickr-day.selected, .flatpickr-day.selected:hover { background: #03045E !important; border-color: #03045E !important; }
            .flatpickr-day.today { border-color: #03045E !important; }
            .flatpickr-day:hover { background: #F1F5F9 !important; }
            .flatpickr-months .flatpickr-month { color: #03045E !important; fill: #03045E !important; }
            .flatpickr-current-month .flatpickr-monthDropdown-months { font-weight: 800 !important; }
            .flatpickr-calendar { border-radius: 1.5rem !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important; border: 1px solid #F1F5F9 !important; padding: 10px !important; }
            .flatpickr-input { font-family: 'Outfit', sans-serif !important; }
            
            [x-cloak] { display: none !important; }
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#FDFDFF] text-slate-900" x-data="{ 
        sidebarOpen: false, 
        sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true',
        loaded: false,
        toggleMinimize() {
            this.sidebarMinimized = !this.sidebarMinimized;
            localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
        },
        init() {
            this.$nextTick(() => {
                this.loaded = true;
            });
        }
    }">
        <div class="flex h-screen overflow-hidden">
            <!-- Mobile Sidebar Backdrop -->
            <div x-show="sidebarOpen" 
                 x-cloak
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"></div>

            <!-- Sidebar -->
            @include('pengusul.partials.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden"
                 :class="[
                    sidebarMinimized ? 'lg:pl-20' : 'lg:pl-64',
                    loaded ? 'transition-all duration-300' : ''
                 ]">
                <!-- Navbar -->
                @include('pengusul.partials.navbar')

                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#FDFDFF] p-4 sm:p-10"
                      x-show="loaded"
                      x-cloak
                      x-transition:enter="transition opacity ease-out duration-500"
                      x-transition:enter-start="opacity-0 translate-y-4"
                      x-transition:enter-end="opacity-100 translate-y-0">
                    
                    @if (isset($header))
                        <div class="mb-8">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Flash Messages Modal -->
                    <x-flash-modal />

                    <div class="max-w-[1600px] mx-auto">
                        {{ $slot ?? '' }}
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
