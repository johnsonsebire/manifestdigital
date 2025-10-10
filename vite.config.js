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
                'resources/css/simple-preloader.css',
                'resources/css/advanced-preloader.css',
                'resources/js/scripts.js',
                'resources/js/simple-preloader.js',
                'resources/js/advanced-preloader.js',
                'resources/js/app.js'
            ],
            refresh: true,
            buildDirectory: 'build',
            publicDirectory: 'public'
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources',
            '~': '/resources',
            '@images': '/resources/images'
        }
    },
    server: {
        cors: true
    },
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        assetsDir: 'assets',
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                styles: 'resources/css/styles.css',
            },
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
    publicDir: 'resources',
    assetsInclude: ['**/*.png', '**/*.jpg', '**/*.jpeg', '**/*.gif', '**/*.svg']
});