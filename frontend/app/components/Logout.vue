<script setup lang="ts">
const { user, logout } = useAuth()

const onLogout = async () => {
  await logout()
  await navigateTo('/login')
}
</script>

<template>
  <button type="button" @click="onLogout">Вихід</button>
</template>

<style scoped>
button {
  padding: 4px 8px;
  font-size: 20px;
  margin-right: 10px;
  border: 1px solid black;
  background: #ffffff;
  border-radius: 5px;
}
button:hover{
  background: #000000;
  color: #ffffff;
  cursor: pointer;
}
</style>