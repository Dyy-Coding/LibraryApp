// src/router/routes.js
import Login from '@/views/auth/LoginPage.vue'
import Register from '@/views/auth/RegisterPage.vue'
import Home from '@/views/pages/HomePage.vue'

export const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: { requiresGuest: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { requiresGuest: true }
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: '/book',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]
