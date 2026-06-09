{{-- ============================================================ --}}
{{-- PWA Head Tags - Include di semua layout <head>              --}}
{{-- ============================================================ --}}

{{-- Web App Manifest --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">

{{-- Theme Color --}}
<meta name="theme-color" content="#03045E">
<meta name="msapplication-TileColor" content="#03045E">
<meta name="msapplication-TileImage" content="{{ asset('icons/icon-144x144.png') }}">

{{-- iOS / Apple Touch Icons --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="VeriCult">
<link rel="apple-touch-icon" href="{{ asset('icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">

{{-- Fallback Icon --}}
<link rel="icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
<link rel="icon" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">

{{-- Register Service Worker --}}
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js', { scope: '/' })
                .then(function (reg) {
                    console.log('[VeriCult PWA] Service Worker registered:', reg.scope);

                    // Cek update SW baru
                    reg.addEventListener('updatefound', function () {
                        const newWorker = reg.installing;
                        newWorker.addEventListener('statechange', function () {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // Ada versi baru tersedia
                                console.log('[VeriCult PWA] New content available, will refresh.');
                            }
                        });
                    });
                })
                .catch(function (err) {
                    console.warn('[VeriCult PWA] Service Worker registration failed:', err);
                });
        });
    }

    // Handle PWA Install Prompt - simpan ke window supaya bisa diakses Alpine.js
    window.__pwaInstallPrompt = null;
    window.__pwaInstalled = false;

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        window.__pwaInstallPrompt = e;
        // Dispatch event ke Alpine.js
        document.dispatchEvent(new CustomEvent('pwa-installable'));
        console.log('[VeriCult PWA] Install prompt ready.');
    });

    window.addEventListener('appinstalled', function () {
        window.__pwaInstalled = true;
        window.__pwaInstallPrompt = null;
        document.dispatchEvent(new CustomEvent('pwa-installed'));
        console.log('[VeriCult PWA] App installed!');
    });
</script>
