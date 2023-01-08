import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',
                // 'resources/js/algorithms/ahp.js',
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
