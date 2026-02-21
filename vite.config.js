import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/sass/attendant-dashboard.scss",
                "resources/sass/grupo-crear.scss",
                "resources/sass/info-aprendiz.scss",
                "resources/sass/informe-estudiante.scss",
                "resources/sass/list-aprendiz.scss",
                "resources/sass/list-teacher.scss",
                "resources/sass/login-premium.scss",
                "resources/sass/select-comprobante.scss",
                "resources/sass/servicios.scss",
                "resources/sass/user-profile.scss",
                "resources/sass/qualification-premium.scss",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
