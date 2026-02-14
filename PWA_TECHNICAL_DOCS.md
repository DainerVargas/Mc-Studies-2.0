# 🔧 MC Studies PWA - Documentación Técnica

## 📋 Descripción General

Esta aplicación Laravel ha sido convertida en una Progressive Web App (PWA) completa, permitiendo que los usuarios la instalen en sus dispositivos como una aplicación nativa.

## 🏗️ Arquitectura de la PWA

### Componentes Principales

1. **manifest.json** - Define las propiedades de la aplicación
2. **sw.js** - Service Worker para caché y funcionalidad offline
3. **offline.html** - Página mostrada cuando no hay conexión
4. **pwa-install-prompt** - Componente de instalación personalizado

## 📁 Estructura de Archivos

```
Mc-Studies2/
├── public/
│   ├── manifest.json          # Manifest de la PWA
│   ├── sw.js                  # Service Worker
│   ├── offline.html           # Página offline
│   └── Logo.png               # Icono de la app
├── resources/views/
│   ├── index.blade.php        # Layout login (con PWA)
│   ├── Dashboard.blade.php    # Layout principal (con PWA)
│   └── components/
│       └── pwa-install-prompt.blade.php  # Banner de instalación
└── PWA_INSTALLATION_GUIDE.md  # Guía de usuario
```

## ⚙️ Configuración del Manifest

**Ubicación:** `public/manifest.json`

```json
{
    "name": "MC Language Studies",
    "short_name": "MC Studies",
    "start_url": "/Lista-Aprendiz",
    "display": "standalone",
    "background_color": "#1a1a2e",
    "theme_color": "#4f46e5",
    "orientation": "portrait-primary"
}
```

### Propiedades Importantes:

- **name**: Nombre completo de la aplicación
- **short_name**: Nombre corto (12 caracteres máx)
- **start_url**: URL inicial al abrir la app
- **display**: Modo de visualización (standalone = sin barra del navegador)
- **theme_color**: Color de la barra de estado en Android
- **background_color**: Color de fondo durante la carga

## 🔄 Service Worker

**Ubicación:** `public/sw.js`

### Estrategias de Caché

El Service Worker implementa una estrategia **Network First, fallback to Cache**:

1. Intenta obtener recursos de la red
2. Si tiene éxito, guarda en caché
3. Si falla, sirve desde caché
4. Si no hay caché, muestra página offline

### URLs en Caché

```javascript
const urlsToCache = [
    "/",
    "/Lista-Aprendiz",
    "/Grupos",
    "/offline.html",
    "/Logo.png",
    "/images/Logo.png",
    "/images/LoginImage.jpg",
    "/build/assets/app-Be1cidhe.css",
    "/build/assets/app-DnEp5ElW.css",
];
```

### Eventos del Service Worker

1. **install** - Cachea archivos iniciales
2. **activate** - Limpia cachés antiguas
3. **fetch** - Intercepta peticiones de red
4. **sync** - Sincronización en background
5. **push** - Notificaciones push

## 🎨 Componente de Instalación

**Ubicación:** `resources/views/components/pwa-install-prompt.blade.php`

Un banner elegante que aparece automáticamente cuando la app puede ser instalada:

- Utiliza Alpine.js para la lógica
- Animaciones suaves con CSS
- Responsive design
- Auto-dismiss cuando se instala

### Uso:

```blade
@include('components.pwa-install-prompt')
```

## 📱 Meta Tags PWA

Implementados en ambos layouts (`index.blade.php` y `Dashboard.blade.php`):

```html
<!-- PWA Meta Tags -->
<meta name="theme-color" content="#4f46e5" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta
    name="apple-mobile-web-app-status-bar-style"
    content="black-translucent"
/>
<meta name="apple-mobile-web-app-title" content="MC Studies" />

<!-- App Icons -->
<link rel="icon" type="image/png" href="{{ asset('Logo.png') }}" />
<link rel="apple-touch-icon" href="{{ asset('Logo.png') }}" />

<!-- PWA Manifest -->
<link rel="manifest" href="{{ asset('manifest.json') }}" />
```

## 🚀 Registro del Service Worker

El Service Worker se registra automáticamente en ambos layouts:

```javascript
if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker.register("/sw.js").then((registration) => {
            console.log("✅ Service Worker registrado");

            // Auto-actualizar cada 30 minutos
            setInterval(() => {
                registration.update();
            }, 1800000);
        });
    });
}
```

## 📴 Página Offline

**Ubicación:** `public/offline.html`

Página elegante mostrada cuando:

- No hay conexión a Internet
- El recurso solicitado no está en caché
- El usuario está navegando (no recursos estáticos)

Características:

- Auto-detección de reconexión
- Botón de reintento manual
- Animaciones y diseño moderno
- Indicador de estado offline

## 🔔 Notificaciones Push (Preparado)

El Service Worker está preparado para manejar notificaciones push:

```javascript
self.addEventListener("push", (event) => {
    const options = {
        body: event.data ? event.data.text() : "Nueva notificación",
        icon: "/Logo.png",
        badge: "/Logo.png",
        vibrate: [200, 100, 200],
    };

    event.waitUntil(self.registration.showNotification("MC Studies", options));
});
```

### Para implementar notificaciones:

1. Generar VAPID keys
2. Configurar servidor push
3. Solicitar permisos al usuario
4. Suscribir usuario al push service

## 🔄 Actualización de la PWA

### Automática:

El Service Worker se actualiza automáticamente cada 30 minutos.

### Manual:

```javascript
navigator.serviceWorker.getRegistration().then((reg) => {
    reg.update();
});
```

### Forzar actualización:

```javascript
navigator.serviceWorker.addEventListener("controllerchange", () => {
    window.location.reload();
});
```

## 🧪 Testing

### Verificar instalación de PWA:

1. Abre Chrome DevTools (F12)
2. Ve a Application → Manifest
3. Verifica que todos los campos estén correctos

### Verificar Service Worker:

1. Chrome DevTools → Application → Service Workers
2. Verifica que esté "activated and is running"
3. Prueba "Update" y "Unregister"

### Verificar Caché:

1. Chrome DevTools → Application → Cache Storage
2. Verifica que los archivos estén cacheados
3. Prueba modo offline (Network → Offline)

### Lighthouse Audit:

```bash
# En Chrome DevTools → Lighthouse
# Ejecutar auditoría PWA
# Objetivo: Score 100/100
```

## 📊 Métricas PWA

La app debe cumplir con estos criterios:

- ✅ HTTPS habilitado
- ✅ Responsive design
- ✅ Service Worker registrado
- ✅ Manifest válido
- ✅ Iconos de múltiples tamaños
- ✅ Página offline
- ✅ Meta tags configurados
- ✅ Tema de color definido

## 🔧 Mantenimiento

### Actualizar versión del caché:

Cuando hagas cambios importantes, actualiza la versión en `sw.js`:

```javascript
const CACHE_NAME = "mc-studies-v1.1"; // Incrementar versión
```

### Agregar nuevas rutas al caché:

```javascript
const urlsToCache = [
    // ... existentes
    "/nueva-ruta",
    "/nuevo-recurso.css",
];
```

### Limpiar caché antigua:

```javascript
caches.keys().then((names) => {
    names.forEach((name) => {
        if (name !== CACHE_NAME) {
            caches.delete(name);
        }
    });
});
```

## 🐛 Troubleshooting

### El Service Worker no se actualiza:

```javascript
// Forzar skip waiting
self.skipWaiting();
self.clients.claim();
```

### Los archivos no se cachean:

- Verificar URLs correctas
- Verificar CORS
- Verificar códigos de respuesta (200)

### El banner de instalación no aparece:

- Verificar HTTPS
- Verificar manifest válido
- Verificar Service Worker activo
- Esperar criterios de engagement

## 📚 Recursos Adicionales

- [PWA Documentation - MDN](https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps)
- [Service Worker API](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)
- [Web App Manifest](https://developer.mozilla.org/en-US/docs/Web/Manifest)
- [Workbox (Google's PWA Library)](https://developers.google.com/web/tools/workbox)

## ✨ Mejoras Futuras

1. **Background Sync**: Sincronizar datos cuando se recupera conexión
2. **Push Notifications**: Implementar notificaciones push completas
3. **App Shortcuts**: Agregar atajos a funciones específicas
4. **Share Target**: Permitir compartir contenido a la app
5. **Install Prompt**: Personalizar más el timing del prompt
6. **Analytics**: Tracking de instalaciones y uso offline

---

**Última actualización:** 2026-02-12
**Versión PWA:** 1.0
**Autor:** MC Studies Development Team
