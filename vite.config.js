import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/informe-estudiante.scss',
                'resources/sass/servicios.scss',
                'resources/sass/grupo-crear.scss',
                'resources/sass/select-comprobante.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
