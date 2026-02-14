# ✅ Checklist de Verificación PWA - MC Studies

## 📋 Pre-instalación

- [ ] El sitio está servido mediante HTTPS (o localhost para pruebas)
- [ ] El servidor web está configurado correctamente (Apache/Nginx)
- [ ] Los archivos PWA están en las ubicaciones correctas

## 🔍 Verificación de Archivos

### Archivos Principales

- [ ] `public/manifest.json` existe y es válido
- [ ] `public/sw.js` existe
- [ ] `public/offline.html` existe
- [ ] `public/Logo.png` existe
- [ ] `public/.htaccess` contiene configuraciones PWA

### Archivos de Vista

- [ ] `resources/views/index.blade.php` tiene meta tags PWA
- [ ] `resources/views/Dashboard.blade.php` tiene meta tags PWA
- [ ] `resources/views/components/pwa-install-prompt.blade.php` existe
- [ ] Script de registro del Service Worker está presente

### Documentación

- [ ] `PWA_INSTALLATION_GUIDE.md` - Guía de usuario
- [ ] `PWA_TECHNICAL_DOCS.md` - Documentación técnica
- [ ] `generate-pwa-icons.ps1` - Script de generación de iconos

## 🧪 Testing en Chrome DevTools

### 1. Manifest

Abrir: DevTools → Application → Manifest

- [ ] Nombre de la app se muestra correctamente
- [ ] Icono se visualiza
- [ ] Start URL es correcto
- [ ] Theme color es `#4f46e5`
- [ ] Display mode es `standalone`
- [ ] No hay errores en la consola

### 2. Service Worker

Abrir: DevTools → Application → Service Workers

- [ ] Service Worker está "activated and running"
- [ ] Source es `/sw.js`
- [ ] Status muestra timestamp de activación
- [ ] No hay errores en la consola

### 3. Cache Storage

Abrir: DevTools → Application → Cache Storage

- [ ] Cache `mc-studies-v1.0` existe
- [ ] Contiene los siguientes archivos:
    - [ ] `/`
    - [ ] `/Lista-Aprendiz`
    - [ ] `/Grupos`
    - [ ] `/offline.html`
    - [ ] `/Logo.png`
    - [ ] `/images/Logo.png`
    - [ ] Assets CSS

### 4. Lighthouse Audit

Abrir: DevTools → Lighthouse → Progressive Web App

- [ ] Score PWA ≥ 90/100
- [ ] "Installable" está marcado ✅
- [ ] "Works offline" está marcado ✅
- [ ] "Configured for a custom splash screen" está marcado ✅
- [ ] Sin errores críticos

## 📱 Testing en Dispositivos

### Android (Chrome)

- [ ] Abrir la aplicación en Chrome móvil
- [ ] Aparece el banner de instalación (o mensaje en consola)
- [ ] Tocar "Instalar"
- [ ] App se instala en pantalla de inicio
- [ ] Icono de la app es visible
- [ ] Al abrir, se muestra sin barra de navegador
- [ ] Color de tema aparece en barra de estado
- [ ] Funciona sin conexión (probar modo avión)

### iOS (Safari)

- [ ] Abrir la aplicación en Safari
- [ ] Tocar botón Compartir → Añadir a pantalla de inicio
- [ ] App se agrega a pantalla de inicio
- [ ] Icono de la app es visible
- [ ] Al abrir, se muestra sin barra de Safari
- [ ] Splash screen personalizado aparece (opcional)

### Escritorio (Chrome/Edge)

- [ ] Icono de instalación (+) aparece en barra de direcciones
- [ ] Hacer clic en "Instalar"
- [ ] App se abre en ventana independiente
- [ ] Sin barra de navegador
- [ ] App aparece en menú de aplicaciones del SO
- [ ] Se puede anclar a la barra de tareas

## 🔄 Funcionalidad Offline

- [ ] Abrir la app con conexión
- [ ] Navegar por varias secciones
- [ ] Activar modo avión / desconectar WiFi
- [ ] Navegar a páginas previamente visitadas (deben cargar)
- [ ] Intentar navegar a página nueva (debe mostrar offline.html)
- [ ] Botón "Reintentar" funciona al recuperar conexión
- [ ] Auto-reconexión funciona

## 🔔 Notificaciones (Si implementado)

- [ ] Solicitud de permisos aparece
- [ ] Usuario puede aceptar/rechazar
- [ ] Notificaciones se muestran correctamente
- [ ] Al hacer clic abre la app
- [ ] Icono y badge se muestran

## 🎨 UI/UX

### Banner de Instalación

- [ ] Aparece automáticamente cuando se cumplen criterios
- [ ] Animación de entrada es suave
- [ ] Información clara (nombre, descripción)
- [ ] Botón "Instalar" funciona
- [ ] Botón "Ahora no" cierra el banner
- [ ] Banner no aparece después de instalación
- [ ] Responsive en móvil y escritorio

### Diseño General

- [ ] Theme color se aplica en barra de estado (Android)
- [ ] Splash screen usa colores del manifest (opcional)
- [ ] Iconos se ven bien en todas las resoluciones
- [ ] No hay elementos cortados o mal posicionados

## 🔧 Actualizaciones

### Service Worker

- [ ] Cambiar versión en `sw.js` (ej: v1.0 → v1.1)
- [ ] Recargar página
- [ ] Nuevo service worker se instala
- [ ] Caché antigua se elimina
- [ ] Nueva caché se crea

### Manifest

- [ ] Cambiar algún valor en `manifest.json`
- [ ] Limpiar caché del navegador
- [ ] Recargar página
- [ ] Cambios se reflejan en DevTools

## 🛡️ Seguridad

- [ ] Manifest se sirve con MIME type correcto
- [ ] Service Worker se sirve con MIME type correcto
- [ ] HTTPS habilitado en producción
- [ ] Headers de seguridad configurados
- [ ] No hay mixed content warnings

## 🌐 Cross-Browser Testing

- [ ] Chrome (Escritorio)
- [ ] Chrome (Android)
- [ ] Edge (Escritorio)
- [ ] Safari (iOS)
- [ ] Firefox (Escritorio) - soporte limitado
- [ ] Samsung Internet (Android)

## 📊 Performance

- [ ] First Contentful Paint < 2s
- [ ] Time to Interactive < 3.5s
- [ ] Caché reduce tamaño de recursos
- [ ] Compresión GZIP activa
- [ ] Recursos estáticos cacheados

## 🐛 Debugging Checklist

Si algo no funciona, verificar:

### Service Worker no se registra

- [ ] HTTPS está activo (o localhost)
- [ ] Archivo `sw.js` existe en `/public`
- [ ] No hay errores de sintaxis en `sw.js`
- [ ] Consola muestra errores específicos

### App no se puede instalar

- [ ] Manifest es válido JSON
- [ ] Manifest tiene `name`, `short_name`, `icons`
- [ ] Service Worker está activo
- [ ] Usuario ha interactuado con la página
- [ ] No está ya instalada

### Caché no funciona

- [ ] Service Worker está active
- [ ] URLs en `urlsToCache` son correctas
- [ ] Event listener `fetch` está configurado
- [ ] Revisar Cache Storage en DevTools

### Offline no funciona

- [ ] `offline.html` está en caché
- [ ] Fetch handler devuelve offline.html
- [ ] Service Worker intercepta requests

## ✨ Optimizaciones Adicionales

- [ ] Generar iconos en múltiples tamaños (usar script PS)
- [ ] Añadir shortcuts en manifest
- [ ] Implementar background sync
- [ ] Agregar share target
- [ ] Optimizar tamaño de caché
- [ ] Implementar estrategia de caché específica por tipo

## 📝 Notas Finales

**Fecha de verificación:** ******\_\_\_******

**Verificado por:** ******\_\_\_******

**Versión PWA:** 1.0

**Issues encontrados:**

-
-
-

**Próximos pasos:**

-
-
-

---

**Estado General:**

- [ ] ✅ Todo funciona correctamente
- [ ] ⚠️ Funciona con advertencias
- [ ] ❌ Requiere correcciones
