import react from '@vitejs/plugin-react';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [ react() ],
    base: '/static/',
    assetsInclude: '**/images/**',
    build: {
        sourcemap: true,
        emptyOutDir: true,
        outDir: '../../public/static',
        assetsDir: 'js',
        manifest: true,
        rollupOptions: {
            input: {
                main: './js/index.jsx',
                styles: './css/app.css'
            },
            output: {
                entryFileNames: '[name].[hash].js',
                chunkFileNames: '[name].[hash].js',
                assetFileNames: '[name].[hash].[ext]'
            }
        }
    }
});
