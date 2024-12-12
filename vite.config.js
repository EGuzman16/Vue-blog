import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  build: {
    sourcemap: false,
  },
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost/vue/blog/server',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, '')
      }
    }
  }
});