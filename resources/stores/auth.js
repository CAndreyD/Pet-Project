import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    status: 'unauthorized', // 'authorized' | 'unauthorized'
  }),
  getters: {
    isAuthenticated: (state) => state.status === 'authorized',
  },
  actions: {
    async login(email, password) {
      const res = await axios.post('/api/login', { email, password })
      this.user = res.data.user || null
      this.token = res.data.access_token
      this.status = 'authorized'
      localStorage.setItem('token', this.token)
    },
    async register(email, password, password_confirmation, name) {
      const res = await axios.post('/api/register', { email, password, password_confirmation, name })
      this.user = res.data.user || null
      this.token = res.data.access_token
      this.status = 'authorized'
      localStorage.setItem('token', this.token)
    },
    logout() {
      this.user = null
      this.token = null
      this.status = 'unauthorized'
      localStorage.removeItem('token')
    },
    async loadFromStorage() {
      const token = localStorage.getItem('token')
      if (token) {
        try {
          // Проверяем токен через API
          const res = await axios.get('/api/me', {
            headers: { Authorization: `Bearer ${token}` }
          })
          this.user = res.data
          this.token = token
          this.status = 'authorized'
        } catch (err) {
          // Токен протух или недействителен
          this.logout()
        }
      } else {
        this.logout()
      }
    }
  }
})
