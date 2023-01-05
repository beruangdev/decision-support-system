import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',
            ],
            refresh: ["public/webworker/**/*.js", "app/Http/Controllers/*.php"],
            // refresh: [
            //     {
            //         paths: 
            //     }
            // ],
            publicDirectory: 'public'
        }),
    ],
});
