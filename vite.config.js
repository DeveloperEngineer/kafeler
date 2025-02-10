import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'node:path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'), // Doğru yolu kullan
        },
    },
    server: {
        origin: process.env.ASSET_URL,
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
});
