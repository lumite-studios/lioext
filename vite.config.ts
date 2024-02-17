import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/styles/app.scss', 'resources/scripts/app.ts'],
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources')
        },
        dedupe: ['vue']
    },
    server: {
        host: 'laravel.test',
    },
})
