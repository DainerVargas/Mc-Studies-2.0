# 🧪 Prueba Rápida de PWA - MC Studies

## ⚡ Testing Rápido (5 minutos)

### 1️⃣ Verifica el Manifest (30 segundos)

Abre en tu navegador:

```
http://localhost/Mc-Studies2/manifest.json
```

**Deberías ver:** Un archivo JSON con la configuración de la app.

✅ **Verificado si:** El archivo se carga sin errores.

---

### 2️⃣ Verifica el Service Worker (30 segundos)

Abre en tu navegador:

```
http://localhost/Mc-Studies2/sw.js
```

**Deberías ver:** Código JavaScript del service worker.

✅ **Verificado si:** El archivo se carga sin errores.

---

### 3️⃣ Abre la Aplicación (1 minuto)

1. Abre Chrome o Edge
2. Ve a: `http://localhost/Mc-Studies2`
3. Presiona **F12** para abrir DevTools
4. Ve a la pestaña **Console**

**Deberías ver:**

```
✅ Service Worker registrado: http://localhost/Mc-Studies2/sw.js
💡 La app puede ser instalada
```

✅ **Verificado si:** Ves estos mensajes en la consola.

---

### 4️⃣ Verifica el Manifest en DevTools (1 minuto)

Con DevTools abierto (F12):

1. Ve a la pestaña **Application**
2. En el menú izquierdo, click en **Manifest**

**Deberías ver:**

- **Name:** MC Language Studies
- **Short name:** MC Studies
- **Start URL:** /Lista-Aprendiz
- **Theme color:** #4f46e5 (morado)
- **Iconos:** Logo.png en varios tamaños

✅ **Verificado si:** Todo aparece sin errores ni advertencias.

---

### 5️⃣ Verifica el Service Worker (1 minuto)

Aún en **Application** tab:

1. Click en **Service Workers** en el menú izquierdo

**Deberías ver:**

- **Status:** ✅ activated and is running
- **Source:** sw.js

✅ **Verificado si:** El Service Worker está "activated".

---

### 6️⃣ Verifica el Caché (1 minuto)

Aún en **Application** tab:

1. Click en **Cache Storage** en el menú izquierdo
2. Expande el caché **mc-studies-v1.0**

**Deberías ver:** Varios archivos cacheados como:

- /
- /Lista-Aprendiz
- /offline.html
- /Logo.png
- etc.

✅ **Verificado si:** Hay archivos en el caché.

---

### 7️⃣ Prueba Instalación (30 segundos)

**En Escritorio (Chrome/Edge):**

Busca un icono **⊕** o **+** en la barra de direcciones.

✅ **Verificado si:** Aparece el icono de instalación.

**En Móvil (Android Chrome):**

Deberías ver un banner en la parte inferior ofreciendo instalar la app.

✅ **Verificado si:** Aparece el banner de instalación.

---

### 8️⃣ Prueba Modo Offline (1 minuto)

1. Con DevTools abierto (F12)
2. Ve a la pestaña **Network**
3. Activa **Offline** (checkbox en la parte superior)
4. Recarga la página (F5)

**Deberías ver:**

- La app sigue funcionando
- O la página `offline.html` con mensaje de "Sin conexión"

✅ **Verificado si:** La app no muestra error de conexión del navegador.

---

## 🎯 Resultado Final

Si todos los pasos muestran ✅, entonces:

### 🎉 ¡PWA INSTALADA CORRECTAMENTE!

Tu aplicación ahora:

- ✅ Puede ser instalada en dispositivos
- ✅ Funciona parcialmente sin conexión
- ✅ Tiene mejor rendimiento
- ✅ Se comporta como app nativa

---

## 🚨 Si Algo Falla

### ❌ Manifest no carga

**Solución:** Verifica que `public/manifest.json` existe.

### ❌ Service Worker no se registra

**Solución:**

1. Verifica que `public/sw.js` existe
2. Asegúrate de usar HTTPS o localhost
3. Revisa errores en consola

### ❌ No aparece icono de instalación

**Solución:**

1. Espera 30 segundos después de cargar la página
2. Interactúa con la página (click en algo)
3. Verifica que el Service Worker esté activo

### ❌ Caché vacío

**Solución:**

1. Recarga la página (F5)
2. Espera 5-10 segundos
3. Revisa Cache Storage nuevamente

---

## 📱 Testing en Móvil

### Android (Chrome)

1. Asegúrate de que el servidor sea accesible en la red local
2. Usa la IP de tu PC: `http://192.168.x.x/Mc-Studies2`
3. Abre en Chrome Android
4. Espera el banner de instalación

### iOS (Safari)

1. Abre en Safari iOS
2. Toca el botón **Compartir**
3. Selecciona **"Añadir a pantalla de inicio"**

---

## 🔍 Lighthouse Audit (Opcional - 2 minutos)

Para una verificación completa:

1. Abre DevTools (F12)
2. Ve a la pestaña **Lighthouse**
3. Selecciona solo **Progressive Web App**
4. Click en **Generate report**

**Objetivo:** Score de 90-100/100

---

## ✅ Checklist Rápido

- [ ] Manifest carga (paso 1)
- [ ] Service Worker carga (paso 2)
- [ ] Consola muestra registro exitoso (paso 3)
- [ ] Manifest válido en DevTools (paso 4)
- [ ] Service Worker activo (paso 5)
- [ ] Archivos en caché (paso 6)
- [ ] Icono de instalación visible (paso 7)
- [ ] Funciona offline (paso 8)

**Si todo está ✅ → PWA funcionando correctamente! 🎉**

---

## 📞 Siguiente Paso

Una vez verificado todo:

1. **Prueba instalar la app** (click en icono +)
2. **Úsala desde la pantalla de inicio**
3. **Comparte la guía** `PWA_INSTALLATION_GUIDE.md` con usuarios
4. **Monitorea el uso** con Analytics

---

**Tiempo total de testing:** ~5-10 minutos  
**Actualizado:** 2026-02-12
