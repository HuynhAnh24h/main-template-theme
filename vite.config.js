import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
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
        about: resolve(__dirname, 'src/js/pages/about.js'),
        contact: resolve(__dirname, 'src/js/pages/contact.js'),
        'category-all': resolve(__dirname, 'src/js/pages/category-all.js'),
        category: resolve(__dirname, 'src/js/pages/category.js'),
        product: resolve(__dirname, 'src/js/pages/product.js'),
        'product-detail': resolve(__dirname, 'src/js/pages/product-detail.js'),
        blog: resolve(__dirname, 'src/js/pages/blog.js'),
        'category-blog': resolve(__dirname, 'src/js/pages/category-blog.js'),
        'blog-detail': resolve(__dirname, 'src/js/pages/blog-detail.js'),
        cart: resolve(__dirname, 'src/js/pages/cart.js'),
        checkout: resolve(__dirname, 'src/js/pages/checkout.js'),
        'my-account': resolve(__dirname, 'src/js/pages/my-account.js'),
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
