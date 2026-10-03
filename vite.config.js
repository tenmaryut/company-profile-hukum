import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            // Halaman publik sengaja tanpa JavaScript: menu seluler dan FAQ memakai <details>.
            input: ['resources/css/app.css', 'resources/css/filament/admin/theme.css'],
            // Font dan gambar statis ikut di-versioning supaya bisa di-preload lewat Vite::asset().
            assets: ['resources/fonts/**', 'resources/images/**'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
