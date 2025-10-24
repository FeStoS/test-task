<template>
  <main>
    <h1>Система авторизації</h1>
    <div class="h-block">
      <NuxtLink class="link-h link" to="/login"><button type="button" class="link-item">Вхід</button></NuxtLink>
      <NuxtLink to="/register" class="link-h link"><button type="button" class="link-item">Реєстрація</button></NuxtLink>
    </div>

  </main>
</template>

<style scoped>
main {
  display:grid;
  gap:12px;
  max-width:420px;
  margin:64px auto;
}
.h-block {
  display: flex;
}
a {
  max-width: max-content;
}
button {
  padding: 4px 8px;
  font-size: 20px;
  margin-right: 10px;
  border: 1px solid black;
  background: #ffffff;
}
button:hover{
  background: #000000;
  color: #ffffff;
}

.link-h {
  padding: 4px 8px;
  font-size: 20px;
  margin-right: 10px;
}
.link-h:last-of-type {
  margin-right: 0;
}
.link-item {
  border-radius: 5px;
}
button:hover, a:hover {
  cursor: pointer;
}
</style>