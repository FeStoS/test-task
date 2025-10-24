type Role = { id: number; name: string }
type User = {
    id: number; email: string;
    last_name?: string; first_name?: string; middle_name?: string | null;
    role?: Role | null;
}

export function useAuth() {
    const user = useState<User | null>('user', () => null)
    const loading = useState<boolean>('authLoading', () => false)
    const error = useState<string | null>('authError', () => null)

    const api = useApi()
    const csrf = () => api('/sanctum/csrf-cookie')

    const fetchUser = async () => {
        try {
            error.value = null
            user.value = await api<User>('/api/user')
            return user.value
        } catch {
            user.value = null
            return null
        }
    }

    const login = async (email: string, password: string) => {
        loading.value = true; error.value = null
        try {
            await csrf()
            await api('/login', { method: 'POST', body: { email, password } })
            await fetchUser()
            return user.value
        } catch (e: any) {
            error.value = normalizeLaravelError(e)
            throw e
        } finally { loading.value = false }
    }


    const register = async (p: {
        last_name: string; first_name: string; middle_name?: string | null;
        email: string; password: string; password_confirmation: string;
    }) => {
        loading.value = true; error.value = null
        try {
            await csrf()
            await api('/register', {
                method: 'POST',
                body: {
                    last_name: p.last_name,
                    first_name: p.first_name,
                    middle_name: p.middle_name ?? null,
                    email: p.email,
                    password: p.password,
                    password_confirmation: p.password_confirmation
                }
            })
            await fetchUser()
            return user.value
        } catch (e: any) {
            error.value = normalizeLaravelError(e)
            throw e
        } finally { loading.value = false }
    }

    const logout = async () => {
        try { await api('/logout', { method: 'POST' }) } finally { user.value = null }
    }

    return { user, loading, error, fetchUser, login, register, logout }
}
function normalizeLaravelError(e: any): string {
    if (e?.data?.message) return e.data.message
    const errs = e?.data?.errors
    if (errs && typeof errs === 'object') {
        const firstKey = Object.keys(errs)[0]
        if (firstKey && Array.isArray(errs[firstKey]) && errs[firstKey][0]) return errs[firstKey][0]
    }
    return 'Request failed'
}
