import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/css/login.css',
                    'resources/css/catalog.css',
                    'resources/css/administration.css', 
                    'resources/css/productDetails.css', 
                    'resources/js/app.js',
                    'resources/js/login.js',
                    'resources/js/catalog.js',
                    'resources/js/administration.js',
                    'resources/js/productDetails.js'
                ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
