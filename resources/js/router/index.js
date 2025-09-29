import { createRouter, createWebHistory } from 'vue-router'
import Backlog from '@/components/backlog/Backlog.vue'

import Auth from '@/components/auth/index.vue'
// CRUD для продуктов
import ProductIndex from '@/components/product/index.vue'

// CRUD для категорий
import CategoryIndex from '@/components/category/index.vue'


const routes = [
  { path: '/', component: Backlog },
  
  { path: '/auth', component: Auth },

  { path: '/products', component: ProductIndex },

  { path: '/categories', component: CategoryIndex },

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
