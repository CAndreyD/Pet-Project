<template>
  <div class="container">
    <!-- Статус авторизации -->
    <AuthStatus />

    <h1>Список товаров</h1>

    <!-- Кнопка добавить товар -->
    <button @click="showForm = true" class="btn-add">
      Добавить товар
    </button>

    <!-- Форма добавления / редактирования -->
    <div v-if="showForm" class="form-box">
      <!-- Название товара -->
      <input v-model="form.name" type="text" placeholder="Название товара" />

      <!-- Описание товара -->
      <textarea v-model="form.description" placeholder="Описание" class="form-textarea"></textarea>

      <!-- Цена -->
      <input v-model.number="form.price" type="number" step="0.01" min="0" placeholder="Цена" />

      <!-- Количество -->
      <input v-model.number="form.quantity" type="number" step="1" min="0" placeholder="Количество" />

      <!-- Кнопки сохранить/отмена -->
      <div>
        <button @click="submitForm" class="btn-save">
          {{ form.id ? 'Сохранить' : 'Добавить' }}
        </button>
        <button @click="resetForm" class="btn-cancel">Отмена</button>
      </div>
    </div>

    <!-- Сообщения -->
    <p v-if="error" class="message error">{{ error }}</p>
    <p v-if="message" class="message success">{{ message }}</p>

    <!-- Список товаров -->
    <ul v-if="products.length > 0" class="product-list">
      <li v-for="product in products" :key="product.id" class="product-item">
        <div class="product-info">
          <strong>{{ product.name }}</strong>

          <!-- Описание с возможностью развернуть/свернуть -->
          <div v-if="product.description" class="description-box" :ref="el => (descRefs[product.id] = el)"
            :style="{ maxHeight: heights[product.id] + 'px' }">
            {{ product.description }}
          </div>
          <button v-if="product.description && product.description.length > 100" @click="toggleDescription(product.id)"
            class="btn-toggle">
            {{ expanded[product.id] ? 'Свернуть' : 'Развернуть' }}
          </button>


          <br />
          Цена: {{ product.price }} | Кол-во: {{ product.quantity }}
        </div>

        <!-- Правая часть: кнопки -->
        <div class="product-actions">
          <button @click="editProduct(product)" class="btn-edit" title="Редактировать">🖉</button>
          <button @click="deleteProduct(product.id)" class="btn-delete" title="Удалить">🗑️</button>
        </div>
      </li>
    </ul>

    <!-- Пустой список -->
    <p v-else>Список товаров пуст</p>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, nextTick } from 'vue'
import axios from 'axios'
import AuthStatus from '@/components/auth/AuthStatus.vue'
import { useAuthStore } from '@/../stores/auth'

const heights = reactive({})  // для хранения текущей высоты каждого описания
const descRefs = reactive({}) // refs к блокам описаний


const auth = useAuthStore()
const authHeaders = () => ({ headers: { Authorization: `Bearer ${auth.token}` } })

const showForm = ref(false)
const products = ref([])
const form = ref({ id: null, name: '', description: '', price: 0, quantity: 0 })
const expanded = reactive({}) // Для списка товаров
const error = ref(null)
const message = ref(null)

// ---------- Загрузка товаров ----------
onMounted(async () => {
  await auth.loadFromStorage()
  if (!auth.isAuthenticated || !auth.token) {
    error.value = 'Не авторизован'
    return
  }

  try {
    const res = await axios.get('/api/products', authHeaders())
    products.value = res.data.data
    products.value.forEach(p => {
      expanded[p.id] = false
      heights[p.id] = 48 // или любая высота свернутого блока
    })
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при загрузке товаров'
  }
})

// ---------- Добавление / редактирование ----------
const submitForm = async () => {
  error.value = null
  message.value = null

  if (!form.value.name || form.value.price < 0 || form.value.quantity < 0) {
    error.value = 'Заполните все поля корректно'
    return
  }

  try {
    if (form.value.id) {
      // Редактирование
      await axios.put(`/api/products/${form.value.id}`, form.value, authHeaders())
      const index = products.value.findIndex(p => p.id === form.value.id)
      if (index !== -1) products.value[index] = { ...form.value }
      message.value = 'Товар обновлен'
    } else {
      // Добавление
      const res = await axios.post('/api/products', form.value, authHeaders())
      products.value.push(res.data)
      expanded[res.data.id] = false
      message.value = 'Товар добавлен'
    }
    resetForm()
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при сохранении товара'
  }
}

// ---------- Очистка формы ----------
const resetForm = () => {
  form.value = { id: null, name: '', description: '', price: 0, quantity: 0 }
  showForm.value = false
  error.value = null
  message.value = null
}

// ---------- Редактирование ----------
const editProduct = (product) => {
  form.value = { ...product }
  showForm.value = true
}

// ---------- Удаление ----------
const deleteProduct = async (id) => {
  if (!auth.isAuthenticated || !auth.token) {
    error.value = 'Не авторизован'
    return
  }

  try {
    await axios.delete(`/api/products/${id}`, authHeaders())
    products.value = products.value.filter(p => p.id !== id)
    delete expanded[id]
    message.value = 'Товар удален'
  } catch (err) {
    console.error(err)
    error.value = 'Ошибка при удалении'
  }
}

// ---------- Развернуть / Свернуть описание ----------
const toggleDescription = async (id) => {
  expanded[id] = !expanded[id]
  await nextTick() // дождаться обновления DOM

  const el = descRefs[id]
  if (expanded[id]) {
    heights[id] = el.scrollHeight  // развернуть до полной высоты
  } else {
    heights[id] = 48               // свернуть обратно
  }
}
</script>

<style scoped>
.container {
  padding: 16px;
  max-width: 600px;
  margin: auto;
  font-family: sans-serif;
}

h1 {
  font-size: 24px;
  margin-bottom: 16px;
}

button {
  cursor: pointer;
  border: none;
  border-radius: 4px;
  padding: 8px 16px;
  transition: all 0.2s;
}

button:hover {
  opacity: 0.9;
}

.btn-add {
  background-color: #38a169;
  color: white;
  margin-bottom: 16px;
}

.btn-save {
  background-color: #3182ce;
  color: white;
  margin-right: 8px;
}

.btn-cancel {
  background-color: #e2e8f0;
  color: #333;
}

.btn-edit,
.btn-delete {
  width: 32px;
  height: 32px;
  padding: 0;
  font-size: 18px;
  /* размер иконки */
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
}

.btn-edit {
  background-color: #ecc94b;
  color: #333;
  margin-right: 4px;
}

.btn-delete {
  background-color: #e53e3e;
  color: white;
}


.btn-toggle {
  background: none;
  border: none;
  color: #3182ce;
  cursor: pointer;
  font-size: 12px;
  margin-top: 4px;
  padding: 0;
}

.form-box input,
.form-textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 8px;
  box-sizing: border-box;
}

.form-textarea {
  min-height: 80px;
  resize: vertical;
}

.product-list {
  list-style: none;
  padding: 0;
}

.product-item {
  border: 1px solid #ccc;
  padding: 12px;
  margin-bottom: 8px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border-radius: 4px;
  background-color: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.product-info strong {
  display: block;
  margin-bottom: 4px;
}

/* Ограничение по высоте для описания в списке товаров */
.description-box {
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 3px 12px;
  background-color: #f9f9f9;
  overflow: hidden;
  transition: max-height 0.3s ease;

  /* новые свойства для переноса текста */
  white-space: pre-wrap;
  /* сохраняет реальные переносы \n */
  word-break: break-word;
  /* переносит длинные слова */
  overflow-wrap: break-word;
  /* дополнительная защита */
}




.description-box.collapsed {
  max-height: 48px;
  /* свернуто */
}

.description-box:not(.collapsed) {
  max-height: none;
  /* развернуто — весь текст виден */
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  /* лёгкая внешняя тень при раскрытии */
}

.message {
  margin-bottom: 8px;
}

.error {
  color: red;
}

.success {
  color: green;
}
</style>
