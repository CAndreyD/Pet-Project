<template>
  <div class="p-6 max-w-3xl mx-auto">
    <!-- Статус авторизации -->
    <AuthStatus />
    <h1 class="text-3xl font-bold mb-6">📌 Backlog задач</h1>

    <section v-for="section in backlog" :key="section.title" class="mb-8">
      <h2 class="text-2xl font-semibold mb-4">
        {{ section.done ? '✅' : '📌' }} {{ section.title }}
      </h2>
      <ul class="task-list">
        <li v-for="item in section.tasks" :key="item.name" class="task-item">
          <!-- Галка / крест -->
          <button class="toggle-btn" @click="toggleDone(item)">
            {{ item.done ? '✔' : '✖' }}
          </button>

          <!-- Название задачи -->
          <span class="task-name" :class="item.done ? 'neon-done' : 'neon-pending'" @click="navigate(item)">
            {{ item.name }}
          </span>
        </li>
      </ul>

    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import AuthStatus from '@/components/auth/AuthStatus.vue'
const router = useRouter()

const backlog = ref([
  {
    title: 'MVP',
    done: true,
    tasks: [
      { name: 'Authorization', done: true, route: '/auth' },
      { name: 'CRUD: Product', done: true, route: '/products' },
      { name: 'CRUD: Category', done: true, route: '/categories' },
      // { name: 'CRUD: Supplier', done: false, route: '/suppliers' },
      // { name: 'Shipments', done: false, route: '/shipments' },
      // { name: 'StockMovement', done: false, route: '/stock-movements' }
    ]
  }
  // {
  //   title: 'Nice-to-have',
  //   done: false,
  //   tasks: [
  //     { name: 'Импорт товаров из Excel', done: false },
  //     { name: 'Логирование действий', done: false },
  //     { name: 'Интеграция Telegram уведомлений', done: false },
  //     { name: 'Линты', done: false }
  //   ]
  // }
])

function toggleDone(item) {
  item.done = !item.done
}

function navigate(item) {
  if (item.route) {
    router.push(item.route)
  }
}
</script>

<style lang='css'>
@import './backlog.css';
</style>
