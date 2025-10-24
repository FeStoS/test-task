<template>
  <div class="auth-card">
    <h1>Вхід</h1>

    <form @submit.prevent="onSubmit">

      <label>Email <input v-model.trim="email" type="email" /></label>

      <label>Пароль <input v-model="password" type="password"/></label>

      <p v-if="auth.error" class="err">{{ auth.error }}</p>

      <button >Вхід</button>

      <p class="muted">Немає акаунта? <NuxtLink to="/register">Реєстрація</NuxtLink></p>

    </form>
  </div>
</template>

<script setup lang="ts">
const auth = useAuth()
const email = ref(''); const password = ref('')
const onSubmit = async () => {
  await auth.login(email.value, password.value)
  const user = auth.user.value
  console.log(user?.role?.name)
  const target = user?.role?.name == 'admin' ? '/admin' : '/dashboard'

  return navigateTo(target)
}
definePageMeta({ layout: false })
</script>

<style scoped>
.auth-card {
  max-width:420px;
  margin:64px auto;
  display:grid;
  gap:12px;
}
label{
  display:grid;
  gap:6px;
}
input{
  padding:10px;
  border:1px solid #ddd;
  border-radius:8px
}
button{
  padding:10px 14px;
  border-radius:8px;
  border:0;
  background:#111;
  color:#fff;
  cursor:pointer;
}
.err{
  color:#c00;
}
.muted{
  color:#666;
}
</style>
