<!-- frontend/app/pages/admin/index.vue -->
<template>
  <div>
    <h1>Адмін панель</h1>
    <p>Привіт, {{ user?.first_name + ' ' + user?.last_name + ' ' + user?.middle_name }}</p>
    <Logout />

    <div class="mt-6">
      <div class="flex items-center gap-3 mb-3">
        <h2 class="text-xl font-semibold">Користувачі</h2>
        <button @click="refresh" :disabled="pending">Перезавантажити</button>
      </div>

      <div v-if="error">Не вдалося завантажити</div>
      <div v-else-if="pending">Завантаження…</div>
      <table v-else class="min-w-full border border-gray-200">
        <thead>
        <tr>
          <th class="p-2 border-b">ID</th>
          <th class="p-2 border-b">Прізвище</th>
          <th class="p-2 border-b">Ім’я</th>
          <th class="p-2 border-b">По батькові</th>
          <th class="p-2 border-b">Email</th>
          <th class="p-2 border-b">Роль</th>
          <th class="p-2 border-b">Дії</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="u in users" :key="u.id">
          <td class="p-2 border-b">{{ u.id }}</td>

          <!-- last_name -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <input v-model="form.last_name" placeholder="Прізвище" class="input"/>
            </template>
            <template v-else>
              {{ u.last_name }}
            </template>
          </td>

          <!-- first_name -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <input v-model="form.first_name" placeholder="Ім’я" class="input"/>
            </template>
            <template v-else>
              {{ u.first_name ?? u.name }}
            </template>
          </td>

          <!-- middle_name -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <input v-model="form.middle_name" placeholder="По батькові" class="input"/>
            </template>
            <template v-else>
              {{ u.middle_name }}
            </template>
          </td>

          <!-- email -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <input v-model="form.email" type="email" class="input"/>
            </template>
            <template v-else>
              {{ u.email }}
            </template>
          </td>

          <!-- role -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <select v-model="form.role_id" class="input">
                <option :value="1">Admin</option>
                <option :value="2">User</option>
              </select>
            </template>
            <template v-else>
              {{ u.role?.name ?? u.role_id ?? '—' }}
            </template>
          </td>

          <!-- actions -->
          <td class="p-2 border-b">
            <template v-if="editId === u.id">
              <button @click="save(u.id)" :disabled="saving" class="btn">Зберегти</button>
              <button @click="cancel()" class="btn ml-2">Скасувати</button>
            </template>
            <template v-else>
              <button @click="startEdit(u)" class="btn">Редагувати</button>
              <button @click="remove(u.id)" class="btn ml-2 danger">Видалити</button>
            </template>
          </td>
        </tr>
        </tbody>
      </table>

      <p v-if="msg" class="mt-3">{{ msg }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'protected' })

const { user, fetchUser } = useAuth()
await fetchUser()
if (user.value?.role !== 'admin') navigateTo('/login')

const api = useApi()
const { data, pending, error, refresh } = await useAsyncData('admin-users', () => api('/api/users'))
const users = computed(() => data.value?.result ?? [])

// inline edit state
const editId = ref<number|null>(null)
const saving = ref(false)
const msg = ref('')

const form = reactive<{first_name?:string; last_name?:string; middle_name?:string; email?:string; role_id?:number}>({})

function startEdit(u: any) {
  editId.value = u.id
  Object.assign(form, {
    first_name: u.first_name ?? '',
    last_name:  u.last_name  ?? '',
    middle_name:  u.middle_name  ?? '',
    email:      u.email      ?? '',
    role_id:    u.role_id ?? u.role?.id ?? null
  })
}
function cancel() {
  editId.value = null
  Object.keys(form).forEach(k => delete (form as any)[k])
  msg.value = ''
}
async function save(id: number) {
  saving.value = true
  msg.value = ''
  try {
    await api(`/api/users/${id}`, { method: 'PATCH', body: form })
    await refresh()
    cancel()
    msg.value = 'Збережено'
  } catch (e:any) {
    msg.value = e?.data?.message || 'Помилка збереження'
  } finally {
    saving.value = false
  }
}
async function remove(id: number) {
  if (!confirm('Видалити користувача?')) return
  msg.value = ''
  try {
    await api(`/api/users/${id}`, { method: 'DELETE' })
    await refresh()
    msg.value = 'Видалено'
  } catch (e:any) {
    msg.value = e?.data?.message || 'Помилка видалення'
  }
}
</script>

<style scoped>
.page { padding: 24px; }
.mt-6 { margin-top: 24px; }
.flex { display:flex; }
.items-center { align-items:center; }
.gap-3 { gap:12px; }
.mb-3 { margin-bottom:12px; }
.min-w-full { min-width:100%; }
.border { border:1px solid #e5e7eb; }
.border-b { border-bottom:1px solid #e5e7eb; }
.p-2 { padding:8px; }
.text-xl { font-size:1.25rem; }
.font-semibold { font-weight:600; }
.input { border:1px solid #e5e7eb; padding:6px 8px; border-radius:6px; width:100%; }
.btn { border:1px solid #e5e7eb; padding:6px 10px; border-radius:6px; background:#f8fafc; }
.btn.danger { border-color:#fecaca; background:#fff1f2; }
.ml-2 { margin-left:8px; }
</style>
