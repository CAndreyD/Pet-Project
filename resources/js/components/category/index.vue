<template>
  <div>
    <h1>Список категорий</h1>
    <!-- Здесь будет таблица или список категорий -->
    <ul>
      <li v-for="category in categories" :key="category.id">
        {{ category.name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Заготовка для данных
const categories = ref([])

// Пример загрузки данных при монтировании
onMounted(() => {
  // Здесь позже будет API запрос
  categories.value = [
    { id: 1, name: 'Категория 1' },
    { id: 2, name: 'Категория 2' }
  ]
})
</script>
