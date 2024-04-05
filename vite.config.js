import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const leafletFiles = [
    'layers-2x.png',
    'layers.png',
    'marker-icon.png'
];

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    server: { 
        hmr: {
            host: 'localhost',
        },
    }, 
    //https://stackoverflow.com/questions/69614671/vite-without-hash-in-filename
    build: {
        rollupOptions: {
          output: {
           assetFileNames: function (file) {
            return leafletFiles.includes(file.name)
              ? `assets/[name].[ext]`
              : `assets/[name]-[hash].[ext]`;
            },
          }
        }
      }
});
