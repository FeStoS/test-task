// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  runtimeConfig: {
    apiBaseInternal: 'http://localhost:8080',
    public: { apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8080' }
  }

})
