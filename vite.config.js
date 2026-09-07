import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
  base: './',
  plugins: [
    tailwindcss(),
  ],
  build: {
    outDir: resolve(__dirname, 'assets/dist'),
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/js/main.js'),
        home: resolve(__dirname, 'src/js/pages/home.js'),
        menu: resolve(__dirname, 'src/js/pages/menu.js'),
        booking: resolve(__dirname, 'src/js/pages/booking.js'),
        contact: resolve(__dirname, 'src/js/pages/contact.js'),
        blog: resolve(__dirname, 'src/js/pages/blog.js'),
        'blog-detail': resolve(__dirname, 'src/js/pages/blog-detail.js'),
        search: resolve(__dirname, 'src/js/pages/search.js'),
        page: resolve(__dirname, 'src/js/pages/page.js'),
        style: resolve(__dirname, 'src/css/main.css')
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'css/[name].[ext]';
          }
          return 'assets/[name].[ext]';
        }
      }
    }
  }
});
