export function useApi() {
    const c = useRuntimeConfig()
    const token = process.client ? decodeURIComponent(useCookie('XSRF-TOKEN').value || '') : ''

    const base = c.public.apiBase || c.apiBaseInternal || 'http://localhost:8080'
    return $fetch.create({
        baseURL: base,
        credentials: 'include',
        headers: { 'X-Requested-With': 'XMLHttpRequest', ...(token ? { 'X-XSRF-TOKEN': token } : {}) }
    })
}
