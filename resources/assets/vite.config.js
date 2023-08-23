import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
    plugins: [react()],
    build: {
        emptyOutDir: true,
        outDir: '../../public/static',
        assetsDir: 'js',
        manifest: true,
        rollupOptions: {
            input: 'js/index.jsx',
            output: {
                entryFileNames: '[name].[hash].js',
                chunkFileNames: '[name].[hash].js',
                assetFileNames: '[name].[hash].[ext]',
                manifestEntries: {
                    'index.js': 'index.js',
                },
            },
        },
    }
})
