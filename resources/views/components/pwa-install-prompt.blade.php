<!-- Botón de instalación PWA -->
<div x-data="{
    showInstall: false,
    deferredPrompt: null,
    isIOS: false,
    showIOSPrompt: false,
    init() {
        // Detectar si es iOS
        this.isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        // Detectar si ya está en modo standalone (ya instalada)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

        if (this.isIOS && !isStandalone) {
            // Mostrar prompt de iOS después de unos segundos si no está instalada
            setTimeout(() => {
                this.showIOSPrompt = true;
            }, 3000);
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstall = true;
        });

        window.addEventListener('appinstalled', () => {
            this.showInstall = false;
            this.deferredPrompt = null;
        });
    }
}" x-init="init()" class="pwa-container">

    <!-- Prompt para Android/Chrome -->
    <div x-show="showInstall" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" class="pwa-install-prompt" style="display: none;">

        <div class="pwa-install-content">
            <div class="pwa-icon">
                <img src="{{ asset('Logo.png') }}" alt="MC Studies">
            </div>

            <div class="pwa-text">
                <h4>Instalar MC Studies</h4>
                <p>Accede más rápido y trabaja sin conexión</p>
            </div>

            <div class="pwa-actions">
                <button
                    @click="
                        if (deferredPrompt) {
                            deferredPrompt.prompt();
                            deferredPrompt.userChoice.then((choiceResult) => {
                                if (choiceResult.outcome === 'accepted') {
                                    console.log('Usuario aceptó la instalación');
                                }
                                deferredPrompt = null;
                                showInstall = false;
                            });
                        }
                    "
                    class="pwa-btn-install">
                    <span class="material-symbols-outlined">download</span>
                    Instalar
                </button>

                <button @click="showInstall = false" class="pwa-btn-dismiss">
                    Ahora no
                </button>
            </div>
        </div>
    </div>

    <!-- Prompt específico para iOS (iPhone/iPad) -->
    <div x-show="showIOSPrompt" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" class="pwa-ios-prompt" style="display: none;">

        <div class="pwa-ios-content">
            <div class="ios-header">
                <div class="pwa-icon-small">
                    <img src="{{ asset('Logo.png') }}" alt="MC Studies">
                </div>
                <div class="ios-text">
                    <h4>Instalar en tu iPhone</h4>
                    <p>Para descargar la app, sigue estos pasos:</p>
                </div>
                <button @click="showIOSPrompt = false" class="ios-close">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="ios-steps">
                <div class="ios-step">
                    <span class="step-num">1</span>
                    <p>Pulsa el botón <strong>Compartir</strong> <span class="ios-icon-share"></span> en la barra
                        inferior.</p>
                </div>
                <div class="ios-step">
                    <span class="step-num">2</span>
                    <p>Desliza hacia abajo y pulsa en <strong>Añadir a la pantalla de inicio</strong> <span
                            class="ios-icon-add"></span>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pwa-container {
        position: relative;
        z-index: 9999;
    }

    .pwa-install-prompt,
    .pwa-ios-prompt {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 420px;
        width: calc(100% - 40px);
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        padding: 20px;
        color: white;
    }

    .pwa-ios-prompt {
        background: #f8f8f8;
        color: #333;
        bottom: 30px;
        border: none;
    }

    .pwa-install-content,
    .pwa-ios-content {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .ios-header {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .pwa-icon,
    .pwa-icon-small {
        border-radius: 12px;
        overflow: hidden;
        background: white;
        padding: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .pwa-icon {
        width: 56px;
        height: 56px;
    }

    .pwa-icon-small {
        width: 42px;
        height: 42px;
    }

    .pwa-icon img,
    .pwa-icon-small img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .ios-text h4 {
        margin: 0;
        font-size: 16px;
        color: #000;
    }

    .ios-text p {
        margin: 2px 0 0 0;
        font-size: 13px;
        color: #666;
    }

    .ios-close {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #eee;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ios-close .material-symbols-outlined {
        font-size: 16px;
        color: #666;
    }

    .ios-steps {
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: white;
        padding: 15px;
        border-radius: 12px;
    }

    .ios-step {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .step-num {
        background: #007aff;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .ios-step p {
        margin: 0;
        font-size: 14px;
        line-height: 1.4;
        color: #333;
    }

    .ios-icon-share {
        display: inline-block;
        width: 20px;
        height: 20px;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23007aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>') no-repeat center;
        vertical-align: middle;
    }

    .ios-icon-add {
        display: inline-block;
        width: 20px;
        height: 20px;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>') no-repeat center;
        vertical-align: middle;
    }

    /* Estilos originales para Android refinados */
    .pwa-text h4 {
        margin: 0 0 4px 0;
        font-size: 18px;
        font-weight: 600;
    }

    .pwa-text p {
        margin: 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .pwa-actions {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    .pwa-btn-install,
    .pwa-btn-dismiss {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .pwa-btn-install {
        background: #4f46e5;
        color: white;
    }

    .pwa-btn-dismiss {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    @media (max-width: 480px) {

        .pwa-install-prompt,
        .pwa-ios-prompt {
            width: calc(100% - 20px);
        }
    }
</style>

<!-- Script Alpine.js si no está incluido -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
