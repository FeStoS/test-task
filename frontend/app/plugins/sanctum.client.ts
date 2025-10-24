export default defineNuxtPlugin(async () => {
    const api = useApi()
    try { await api('/sanctum/csrf-cookie') } catch {}
})