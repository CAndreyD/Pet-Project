<template>
  <div
    class="auth-status mb-4 flex items-center gap-2 cursor-pointer"
    @click="goAuth"
  >
    <span :class="['auth-status-dot', auth.isAuthenticated ? 'bg-green-500' : 'bg-red-500']"></span>
    <span class="auth-status-text">
      {{ auth.isAuthenticated ? 'Авторизован' : 'Не авторизован' }}
    </span>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/../stores/auth'

const auth = useAuthStore()
auth.loadFromStorage()

const router = useRouter()
const route = useRoute()

const goAuth = () => {
  if (route.path !== '/auth') {
    router.push('/auth')
  }
}
</script>

<style lang="css">
@import './auth.css';
</style>
