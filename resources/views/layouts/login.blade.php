@extends('index')
@section('title', 'Login')
@section('login')
    <div class="lp-login-container">
        {{-- Panel Izquierdo: Imagen y Bienvenida --}}
        <div class="lp-image-panel">
            <img src="/images/LoginImage.jpg" alt="Estudiante aprendiendo">
            <div class="lp-overlay">
                <h3>Welcome Back!</h3>
                <p>Recuerda que cada acción que tomes ayuda a mejorar la experiencia de los usuarios. ¡Sigamos avanzando
                    juntos!</p>
            </div>
        </div>

        {{-- Panel Derecho: Formulario de Login --}}
        <div class="lp-form-panel">
            <div class="lp-login-card">
                <div class="lp-logo-box">
                    <img src="/images/Logo.png" alt="MC Language Studies Logo">
                    <h2>Sign in to MC Studies</h2>
                </div>

                <form action="{{ route('loginPost') }}" method="post">
                    @csrf
                    <div class="lp-input-wrapper">
                        <input type="text" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}" required
                            autocomplete="username">
                        <span class="material-symbols-outlined">person</span>
                        @error('usuario')
                            <span class="lp-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="lp-input-wrapper">
                        <input id="password" type="password" name="password" placeholder="Contraseña" required
                            autocomplete="current-password">
                        <span class="material-symbols-outlined">password</span>
                        @error('password')
                            <span class="lp-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <a class="lp-forgot-link" href="/Recuperar-Contraseña">¿Haz olvidado la contraseña?</a>

                    <button class="lp-btn-submit" type="submit">INGRESAR</button>
                </form>

                {{-- PWA Install Button --}}
                <div id="pwa-install-container" class="lp-pwa-install" style="display: none;">
                    <div class="lp-pwa-divider">
                        <span>o</span>
                    </div>
                    <button id="pwa-install-btn" class="lp-btn-install-pwa">
                        <span class="material-symbols-outlined">download</span>
                        <span class="lp-install-text">
                            <strong>Descargar como App</strong>
                            <small>Acceso rápido desde tu dispositivo</small>
                        </span>
                    </button>
                    <p class="lp-pwa-features">
                        <span><span class="material-symbols-outlined">offline_bolt</span> Funciona sin conexión</span>
                        <span><span class="material-symbols-outlined">speed</span> Más rápida</span>
                    </p>
                </div>

                <style>
                    .lp-pwa-install {
                        margin-top: 12px;
                        animation: slideDown 0.4s ease-out;
                    }

                    @keyframes slideDown {
                        from {
                            opacity: 0;
                            transform: translateY(-10px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    .lp-pwa-divider {
                        text-align: center;
                        margin: 12px 0 10px 0;
                        position: relative;
                    }

                    .lp-pwa-divider::before,
                    .lp-pwa-divider::after {
                        content: '';
                        position: absolute;
                        top: 50%;
                        width: 40%;
                        height: 1px;
                        background: linear-gradient(to right, transparent, #e5e7eb, transparent);
                    }

                    .lp-pwa-divider::before {
                        left: 0;
                    }

                    .lp-pwa-divider::after {
                        right: 0;
                    }

                    .lp-pwa-divider span {
                        background: white;
                        padding: 0 12px;
                        color: #9ca3af;
                        font-size: 13px;
                        position: relative;
                        z-index: 1;
                    }

                    .lp-btn-install-pwa {
                        width: 100%;
                        padding: 12px 20px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border: none;
                        border-radius: 12px;
                        font-size: 14px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 10px;
                        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                        position: relative;
                        overflow: hidden;
                    }

                    .lp-btn-install-pwa::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: -100%;
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                        transition: left 0.5s;
                    }

                    .lp-btn-install-pwa:hover::before {
                        left: 100%;
                    }

                    .lp-btn-install-pwa:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
                    }

                    .lp-btn-install-pwa:active {
                        transform: translateY(0);
                    }

                    .lp-btn-install-pwa .material-symbols-outlined {
                        font-size: 22px;
                        animation: bounce 2s infinite;
                    }

                    @keyframes bounce {

                        0%,
                        100% {
                            transform: translateY(0);
                        }

                        50% {
                            transform: translateY(-4px);
                        }
                    }

                    .lp-install-text {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 2px;
                    }

                    .lp-install-text strong {
                        font-size: 14px;
                        letter-spacing: 0.2px;
                    }

                    .lp-install-text small {
                        font-size: 11px;
                        font-weight: 400;
                        opacity: 0.9;
                    }

                    .lp-pwa-features {
                        display: flex;
                        justify-content: center;
                        gap: 16px;
                        margin-top: 8px;
                        margin-bottom: 0;
                        font-size: 11px;
                        color: #6b7280;
                    }

                    .lp-pwa-features span {
                        display: flex;
                        align-items: center;
                        gap: 4px;
                    }

                    .lp-pwa-features .material-symbols-outlined {
                        font-size: 14px;
                        color: #667eea;
                    }

                    @media (max-width: 900px) {
                        .lp-pwa-install {
                            margin-top: 10px;
                        }

                        .lp-pwa-divider {
                            margin: 10px 0 8px 0;
                        }

                        .lp-btn-install-pwa {
                            padding: 11px 18px;
                        }

                        .lp-install-text strong {
                            font-size: 13px;
                        }

                        .lp-install-text small {
                            font-size: 10px;
                        }

                        .lp-pwa-features {
                            gap: 12px;
                            font-size: 10px;
                        }
                    }

                    @media (max-width: 768px) {
                        .lp-pwa-features {
                            flex-wrap: wrap;
                        }
                    }

                    @media (max-width: 400px) {
                        .lp-pwa-install {
                            margin-top: 8px;
                        }

                        .lp-pwa-divider {
                            margin: 8px 0 6px 0;
                        }

                        .lp-btn-install-pwa {
                            padding: 10px 16px;
                            font-size: 13px;
                        }

                        .lp-pwa-features {
                            flex-direction: column;
                            gap: 6px;
                            align-items: center;
                            margin-top: 6px;
                        }
                    }
                </style>

                <script>
                    // PWA Install Logic
                    let deferredPrompt;
                    const installContainer = document.getElementById('pwa-install-container');
                    const installBtn = document.getElementById('pwa-install-btn');

                    // Detectar si la app puede ser instalada
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        deferredPrompt = e;

                        // Mostrar el botón
                        if (installContainer) {
                            installContainer.style.display = 'block';
                        }
                    });

                    // Manejar click en el botón
                    if (installBtn) {
                        installBtn.addEventListener('click', async () => {
                            if (!deferredPrompt) {
                                return;
                            }

                            // Mostrar el prompt de instalación
                            deferredPrompt.prompt();

                            // Esperar la respuesta del usuario
                            const {
                                outcome
                            } = await deferredPrompt.userChoice;

                            if (outcome === 'accepted') {
                                console.log('✅ Usuario aceptó la instalación');
                            } else {
                                console.log('❌ Usuario rechazó la instalación');
                            }

                            // Limpiar el prompt
                            deferredPrompt = null;

                            // Ocultar el botón
                            if (installContainer) {
                                installContainer.style.display = 'none';
                            }
                        });
                    }

                    // Detectar si la app ya está instalada
                    window.addEventListener('appinstalled', () => {
                        console.log('✅ PWA instalada exitosamente');

                        // Ocultar el botón
                        if (installContainer) {
                            installContainer.style.display = 'none';
                        }

                        deferredPrompt = null;
                    });

                    // Verificar si ya está en modo standalone (instalada)
                    if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                        console.log('✅ App ya está instalada');
                        if (installContainer) {
                            installContainer.style.display = 'none';
                        }
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
