<template>
  <div class="auth-card">
    <h1>Реєстрація</h1>
    <form @submit.prevent="onSubmit">
      <label>Прізвище
        <input v-model.trim="last_name" type="text" />
      </label>
      <label>Ім’я
        <input v-model.trim="first_name" type="text" />
      </label>
      <label>По батькові
        <input v-model.trim="middle_name" type="text" />
      </label>
      <label>Email
        <input v-model.trim="email" type="email" />
      </label>
      <label>Пароль
        <input v-model="password" type="password" minlength="8" />
      </label>
      <label>Підтвердження пароля
        <input v-model="password_confirmation" type="password" :class="{bad: mismatch}" />
      </label>

      <p v-if="mismatch" class="err">Паролі не співпадають</p>
      <p v-if="auth.error" class="err">{{ auth.error }}</p>

      <button>Створити акаунт</button>
      <p class="muted">Вже є акаунт? <NuxtLink to="/login">Увійти</NuxtLink></p>
    </form>
  </div>
</template>

<script setup lang="ts">
const auth = useAuth()
const last_name = ref('');
const first_name = ref('');
const middle_name = ref('')
const email = ref('');
const password = ref('');
const password_confirmation = ref('')
const mismatch = computed(() => password.value !== password_confirmation.value)

const onSubmit = async () => {
  if (mismatch.value) return
  await auth.register({
    last_name: last_name.value,
    first_name: first_name.value,
    middle_name: middle_name.value || null,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value
  })
  const u = auth.user.value
  const target = u?.role?.name === 'admin' ? '/admin' : '/dashboard'
  return navigateTo(target)
}
definePageMeta({ layout: false })
</script>

<style scoped>
.auth-card{max-width:520px;margin:64px auto;display:grid;gap:12px}
label{display:grid;gap:6px} input{padding:10px;border:1px solid #ddd;border-radius:8px}
input.bad{border-color:#c00}
button{padding:10px 14px;border-radius:8px;border:0;background:#111;color:#fff;cursor:pointer}
.err{color:#c00}.muted{color:#666}
</style>
