<template>
  <div class="auth-page">
    <div class="auth-container">
      <!-- Кнопка на главную -->
      <button class="auth-home-btn" @click="$router.push('/')">На главную</button>
      <!-- Статус авторизации -->
      <AuthStatus />


      <h2>Авторизация</h2>

      <!-- Навигация -->
      <div class="auth-nav">
        <button @click="mode = 'login'" :style="{ fontWeight: mode === 'login' ? 'bold' : 'normal' }">Вход</button>
        <button @click="mode = 'register'"
          :style="{ fontWeight: mode === 'register' ? 'bold' : 'normal' }">Регистрация</button>
        <button @click="mode = 'forgot'" :style="{ fontWeight: mode === 'forgot' ? 'bold' : 'normal' }">Забыл
          пароль</button>
      </div>

      <!-- Ошибка / сообщение -->
      <p v-if="error" class="auth-error">{{ error }}</p>
      <p v-if="message" class="auth-message">{{ message }}</p>

      <!-- Форма -->
      <form @submit.prevent="submitForm" class="auth-form">
        <div class="auth-input" v-if="mode !== 'forgot'">
          <input v-model="form.email" type="email" placeholder="Email" required>
          <input v-model="form.password" type="password" placeholder="Пароль" required>
          <input v-if="mode === 'register'" v-model="form.password_confirmation" type="password"
            placeholder="Повторить пароль" required>
          <input v-if="mode === 'register'" v-model="form.name" type="text" placeholder="Имя" required>
        </div>

        <div class="auth-input" v-else>
          <input v-model="form.email" type="email" placeholder="Email для восстановления" required>
        </div>

        <button type="submit">
          {{ mode === 'login' ? 'Войти' : mode === 'register' ? 'Регистрация' : 'Отправить ссылку' }}
        </button>
      </form>
    </div>
  </div>
</template>


<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/../stores/auth'
import AuthStatus from '@/components/auth/AuthStatus.vue'

const auth = useAuthStore()
auth.loadFromStorage()

const mode = ref('login')
const form = ref({ email: '', password: '', name: '', password_confirmation: '' })
const error = ref(null)
const message = ref(null)

const submitForm = async () => {
  error.value = null
  message.value = null
  try {
    if (mode.value === 'login') {
      await auth.login(form.value.email, form.value.password)
      message.value = 'Вход успешен!'
    } else if (mode.value === 'register') {
      await auth.register(form.value.email, form.value.password, form.value.password_confirmation, form.value.name)
      message.value = 'Регистрация успешна!'
    } else if (mode.value === 'forgot') {
      await auth.forgotPassword(form.value.email)
      message.value = 'Ссылка на сброс пароля отправлена'
    }
  } catch (err) {
    error.value = err.response?.data?.error || err.response?.data?.message || 'Ошибка запроса'
  }
}
</script>
<style lang="css">
@import './auth.css';
</style>