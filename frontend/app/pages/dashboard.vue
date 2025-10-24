<template>
  <main>
    <span v-if="fullName"> {{ fullName }}</span>

    <Logout />
  </main>
</template>

<script setup lang="ts">
import Logout from "~/components/Logout.vue";

definePageMeta({ middleware: 'protected' })
const { user, fetchUser } = useAuth()

// якщо сторінка може відкритися раніше, ніж користувач підтягнеться — добір даних
if (!user.value) {
  await fetchUser()
}

const fullName = computed(() => {
  const u = user.value
  if (!u) return ''
  const name = [u.last_name, u.first_name, u.middle_name].filter(Boolean).join(' ')
  return name || u.email
})


</script>

<style scoped>
main {
  display:grid;
  gap:12px;
  max-width:420px;
  margin:64px auto;
}

</style>