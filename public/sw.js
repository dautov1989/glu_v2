const CACHE_NAME = 'glucosa-v1';
const ASSETS_TO_CACHE = [
    '/favicon.ico',
    '/favicon.svg',
    '/favicon-192x192.png',
    '/favicon-512x512.png',
    '/site.webmanifest',
    '/offline.html', // We might not have this yet, but good practice
    '/tools/insulin-calculator' // Pre-cache the calculator
];

// Install Event
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

// Activate Event
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch Event
self.addEventListener('fetch', (event) => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) return;

    // Handle GET requests
    if (event.request.method === 'GET') {
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    // Update cache with new response
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                    return response;
                })
                .catch(() => {
                    // Return cached response if network fails
                    return caches.match(event.request);
                })
        );
    }
});
