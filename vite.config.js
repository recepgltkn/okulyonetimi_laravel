import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/block-builder-page.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    server: {
        host: '127.0.0.1',
        strictPort: true,
        port: 5173,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
