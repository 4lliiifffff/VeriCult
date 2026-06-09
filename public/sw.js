// VeriCult Service Worker v1.0
const CACHE_NAME = 'vericult-v1';
const STATIC_CACHE = 'vericult-static-v1';
const DYNAMIC_CACHE = 'vericult-dynamic-v1';

// Aset yang di-cache saat install
const STATIC_ASSETS = [
    '/',
    '/offline',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/manifest.json',
];

// =====================
// INSTALL EVENT
// =====================
self.addEventListener('install', (event) => {
    console.log('[SW] Installing VeriCult Service Worker...');
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            console.log('[SW] Caching static assets...');
            // Cache satu per satu agar tidak gagal semua jika ada yang error
            return Promise.allSettled(
                STATIC_ASSETS.map(url =>
                    cache.add(url).catch(err => console.warn(`[SW] Failed to cache: ${url}`, err))
                )
            );
        }).then(() => {
            console.log('[SW] Static assets cached.');
            return self.skipWaiting();
        })
    );
});

// =====================
// ACTIVATE EVENT
// =====================
self.addEventListener('activate', (event) => {
    console.log('[SW] Activating VeriCult Service Worker...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter(name => name !== STATIC_CACHE && name !== DYNAMIC_CACHE)
                    .map(name => {
                        console.log('[SW] Deleting old cache:', name);
                        return caches.delete(name);
                    })
            );
        }).then(() => {
            console.log('[SW] Service Worker activated and old caches cleaned.');
            return self.clients.claim();
        })
    );
});

// =====================
// FETCH EVENT
// =====================
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Hanya tangani request HTTP/HTTPS
    if (!request.url.startsWith('http')) return;

    // Lewati request ke API eksternal, Chrome extensions, dll
    if (url.origin !== self.location.origin) return;

    // Lewati POST/PUT/DELETE requests (form submit, API mutations)
    if (request.method !== 'GET') return;

    // Lewati request admin, API, logout
    const skipPaths = ['/logout', '/login', '/register', '/_debugbar'];
    if (skipPaths.some(path => url.pathname.startsWith(path))) return;

    // Strategi: Stale-While-Revalidate untuk navigasi halaman
    if (request.mode === 'navigate') {
        event.respondWith(networkFirstStrategy(request));
        return;
    }

    // Strategi: Cache First untuk aset statis (JS, CSS, font, gambar)
    if (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'font' ||
        request.destination === 'image' ||
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/icons/')
    ) {
        event.respondWith(cacheFirstStrategy(request));
        return;
    }

    // Default: Network First
    event.respondWith(networkFirstStrategy(request));
});

// =====================
// STRATEGI CACHE
// =====================

// Network First: Coba network dulu, fallback ke cache
async function networkFirstStrategy(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            // Jangan cache halaman yang butuh auth
            const url = new URL(request.url);
            const noCacheRoutes = ['/dashboard', '/admin', '/super-admin', '/validator', '/pengusul'];
            const shouldCache = !noCacheRoutes.some(route => url.pathname.startsWith(route));
            if (shouldCache) {
                cache.put(request, networkResponse.clone());
            }
        }
        return networkResponse;
    } catch (error) {
        console.log('[SW] Network failed, trying cache:', request.url);
        const cachedResponse = await caches.match(request);
        if (cachedResponse) return cachedResponse;

        // Offline fallback untuk navigasi
        if (request.mode === 'navigate') {
            const offlinePage = await caches.match('/offline');
            if (offlinePage) return offlinePage;
        }

        throw error;
    }
}

// Cache First: Coba cache dulu, fallback ke network
async function cacheFirstStrategy(request) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) return cachedResponse;

    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(STATIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.warn('[SW] Cache first - network failed:', request.url);
        throw error;
    }
}

// =====================
// MESSAGE EVENT
// =====================
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    if (event.data && event.data.type === 'CLEAR_CACHE') {
        caches.keys().then(keys => keys.forEach(key => caches.delete(key)));
    }
});
