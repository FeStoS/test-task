export default defineNuxtRouteMiddleware(async (to) => {
    if (!['/', '/login', '/register'].includes(to.path)) return
    const { user, fetchUser } = useAuth()
    if (!user.value) await fetchUser()
    if (!user.value) return

    return navigateTo(user.value.role.name === 'admin' ? '/admin' : '/dashboard')
})
