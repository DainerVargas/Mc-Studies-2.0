// Service Worker para MC Studies PWA
const CACHE_NAME = 'mc-studies-v1.0';
const urlsToCache = [
  '/',
  '/Lista-Aprendiz',
  '/Grupos',
  '/offline.html',
  '/Logo.png',
  '/images/Logo.png',
  '/images/LoginImage.jpg',
  'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0'
];

// Instalación del service worker
self.addEventListener('install', (event) => {
  console.log('[SW] Instalando Service Worker...');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[SW] Cacheando archivos de la app');
        return cache.addAll(urlsToCache.filter(url => !url.startsWith('http')));
      })
      .catch((error) => {
        console.error('[SW] Error al cachear:', error);
      })
  );
  self.skipWaiting();
});

// Activación del service worker
self.addEventListener('activate', (event) => {
  console.log('[SW] Activando Service Worker...');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('[SW] Eliminando caché antigua:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  return self.clients.claim();
});

// Estrategia de caché: Network First, fallback to Cache
self.addEventListener('fetch', (event) => {
  // Ignorar solicitudes no-http/https
  if (!event.request.url.startsWith('http')) {
    return;
  }

  // Ignorar solicitudes POST, PUT, DELETE
  if (event.request.method !== 'GET') {
    return;
  }

  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // Si la respuesta es válida, cachear una copia
        if (response && response.status === 200 && response.type === 'basic') {
          const responseToCache = response.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return response;
      })
      .catch(() => {
        // Si falla la red, intentar el caché
        return caches.match(event.request).then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          // Si no está en caché y es navegación, mostrar página offline
          if (event.request.mode === 'navigate') {
            return caches.match('/offline.html');
          }
        });
      })
  );
});

// Sincronización en segundo plano
self.addEventListener('sync', (event) => {
  if (event.tag === 'sync-data') {
    console.log('[SW] Sincronizando datos...');
    event.waitUntil(syncData());
  }
});

// Notificaciones push
self.addEventListener('push', (event) => {
  const options = {
    body: event.data ? event.data.text() : 'Nueva notificación',
    icon: '/Logo.png',
    badge: '/Logo.png',
    vibrate: [200, 100, 200],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    },
    actions: [
      {
        action: 'explore',
        title: 'Ver detalles'
      },
      {
        action: 'close',
        title: 'Cerrar'
      }
    ]
  };

  event.waitUntil(
    self.registration.showNotification('MC Studies', options)
  );
});

// Manejo de clics en notificaciones
self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});

// Función auxiliar para sincronización
async function syncData() {
  try {
    // Aquí puedes implementar lógica de sincronización
    console.log('[SW] Datos sincronizados');
  } catch (error) {
    console.error('[SW] Error en sincronización:', error);
  }
}
