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
                'resources/css/styles.css',
                'resources/css/projects.css',
                'resources/css/book-a-call.css',
                'resources/css/request-quote.css',
                'resources/css/simple-preloader.css',
                'resources/css/advanced-preloader.css',
                'resources/js/scripts.js',
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
    build: {
        manifest: true,
        outDir: 'public/build',
        assetsDir: 'assets',
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.').at(1);
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        return `assets/images/[name]-[hash][extname]`;
                    }
                    return `assets/[ext]/[name]-[hash][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js'
            }
        }
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