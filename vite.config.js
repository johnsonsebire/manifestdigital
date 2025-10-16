import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/admin-enhanced.css',
                'resources/css/styles.css',
                'resources/css/projects.css',
                'resources/css/book-a-call.css',
                'resources/css/request-quote.css',
                'resources/css/about.css',
                'resources/assets/css/opportunities.css',
                'resources/css/ai-chat.css',
                'resources/css/simple-preloader.css',
                'resources/css/advanced-preloader.css',
                'resources/css/opportunities.css',
                'resources/js/scripts.js',
                'resources/js/ai-chat.js',
                'resources/js/simple-preloader.js',
                'resources/js/advanced-preloader.js',
                'resources/js/features/projects-performance-optimizer.js',
                'resources/js/features/projects/projects-data-manager.js',
                'resources/js/features/projects/infinite-projects-scroll.js',
                'resources/js/features/projects/project-navigation.js',
                'resources/js/app.js'
            ],
            refresh: true,
            buildDirectory: 'build',
            publicDirectory: 'public'
        }),
        tailwindcss(),
    ],
    server: {
        cors: true
    },

    resolve: {
        alias: {
            '@': '/resources',
            '~': '/resources',
            '@images': '/resources/images',
            '@css': '/resources/css'
        }
    },
    assetsInclude: ['**/*.png', '**/*.jpg', '**/*.jpeg', '**/*.gif', '**/*.svg']
});