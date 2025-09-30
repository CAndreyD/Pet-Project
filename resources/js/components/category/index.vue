<template>
  <div class="container">
    <AuthStatus />

    <header class="header">
      <h1>Категории</h1>
      <button @click="openForm()" class="btn btn-primary">➕ Добавить категорию</button>
    </header>

    <!-- Форма добавления/редактирования -->
    <div v-if="showForm" class="form-box card">
      <h2>{{ form.id ? 'Редактировать категорию' : 'Новая категория' }}</h2>
      <input v-model="form.name" type="text" placeholder="Название категории" class="input" />
      <textarea v-model="form.description" placeholder="Описание" class="textarea"></textarea>

      <!-- Выбор родителя -->
      <select v-model="form.parent_id" class="input">
        <option :value="null">-- Корневая категория --</option>
        <option v-for="c in flatCategories" :key="c.id" :value="c.id">{{ c.name }}</option>
      </select>

      <div class="form-actions">
        <button @click="submitForm" class="btn btn-success">{{ form.id ? 'Сохранить' : 'Добавить' }}</button>
        <button @click="resetForm" class="btn btn-secondary">Отмена</button>
      </div>
    </div>

    <!-- Сообщения -->
    <p v-if="error" class="alert alert-error">{{ error }}</p>
    <p v-if="message" class="alert alert-success">{{ message }}</p>

    <!-- Список категорий -->
    <div v-if="categories.length > 0">
      <CategoryCard v-for="c in categories" :key="c.id" :category="c" @edit-category="openForm"
        @delete-category="deleteCategory" />
    </div>
    <p v-else>Категорий пока нет</p>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import AuthStatus from '@/components/auth/AuthStatus.vue'
import { useAuthStore } from '@/../stores/auth'
import CategoryCard from './CategoryCard.vue' // рекурсивный компонент для категорий

const auth = useAuthStore()
const authHeaders = () => ({ headers: { Authorization: `Bearer ${auth.token}` } })

const showForm = ref(false)
const categories = ref([])
const form = ref({ id: null, name: '', description: '', parent_id: null })
const error = ref(null)
const message = ref(null)

onMounted(async () => {
  await auth.loadFromStorage()
  if (!auth.isAuthenticated) {
    error.value = 'Не авторизован'
    return
  }
  loadCategories()
})

const loadCategories = async () => {
  try {
    const res = await axios.get('/api/categories', authHeaders())
    categories.value = res.data.data
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при загрузке категорий'
  }
}

// Для выбора родителя — плоский список всех категорий
// Для выбора родителя — плоский список всех категорий, кроме самой себя
const flatCategories = computed(() => {
  const flatten = (cats, arr = []) => {
    cats.forEach(c => {
      // исключаем текущую редактируемую категорию
      if (form.value.id !== c.id) {
        arr.push({ id: c.id, name: c.name })
        if (c.children && c.children.length) flatten(c.children, arr)
      }
    })
    return arr
  }
  return flatten(categories.value)
})


const openForm = (category = null) => {
  if (category) {
    form.value = { ...category }
  } else {
    form.value = { id: null, name: '', description: '', parent_id: null }
  }
  showForm.value = true
}

const submitForm = async () => {
  error.value = null
  message.value = null

  if (!form.value.name) {
    error.value = 'Введите название'
    return
  }

  try {
    if (form.value.id) {
      await axios.put(`/api/categories/${form.value.id}`, form.value, authHeaders())
      loadCategories()
      message.value = 'Категория обновлена'
    } else {
      await axios.post('/api/categories', form.value, authHeaders())
      loadCategories()
      message.value = 'Категория добавлена'
    }
    resetForm()
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при сохранении'
  }
}

const resetForm = () => {
  form.value = { id: null, name: '', description: '', parent_id: null }
  showForm.value = false
}

const deleteCategory = async (id) => {
  try {
    await axios.delete(`/api/categories/${id}`, authHeaders())
    loadCategories()
    message.value = 'Категория удалена'
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при удалении'
  }
}
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.grid {
  display: grid;
  gap: 16px;
}

.card {
  background: #fff;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.form-box {
  margin-bottom: 20px;
}

.input,
.textarea,
select {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.textarea {
  min-height: 80px;
}

.btn {
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
}

.btn-primary {
  background: #007bff;
  color: white;
}

.btn-success {
  background: #28a745;
  color: white;
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-primary:hover {
  background: #0069d9;
}

.btn-success:hover {
  background: #218838;
}

.btn-secondary:hover {
  background: #5a6268;
}

.alert {
  margin-top: 10px;
  padding: 10px;
  border-radius: 4px;
}

.alert-success {
  background: #d4edda;
  color: #155724;
}

.alert-error {
  background: #f8d7da;
  color: #721c24;
}

.form-actions {
  display: flex;
  gap: 8px;
  margin-top: 10px;
}
</style>
