<template>
  <div :class="['app-wrapper', { dark: isDark }]">
    <nav class="navbar" ref="navbar">
      <h1 class="logo">📚 GenZ Library</h1>

      <div class="nav-links">
        <router-link to="/" active-class="active-link">Home</router-link>
        <router-link to="/login" active-class="active-link">Login</router-link>
        <router-link to="/register" active-class="active-link">Register</router-link>

        <button
          v-if="isAuthenticated"
          class="logout-btn"
          @click="logout"
        >
          🔓 Logout
        </button>

        <button class="toggle" @click="toggleDarkMode">
          {{ isDark ? '☀️ Light' : '🌙 Dark' }}
        </button>
      </div>
    </nav>

    <!-- Updated router-view with slot props for transition -->
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import gsap from 'gsap'

const router = useRouter()
const isAuthenticated = ref(false)
const isDark = ref(localStorage.getItem('theme') === 'dark')
const navbar = ref(null)

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    isAuthenticated.value = true
  }

  gsap.fromTo(
    navbar.value,
    { y: -80, opacity: 0 },
    { y: 0, opacity: 1, duration: 1, ease: 'power2.out' }
  )
})

const logout = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/auth/logout')
  } catch (e) {
    console.warn('Logout failed or token expired.')
  } finally {
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
    isAuthenticated.value = false
    router.push('/login')
  }
}

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}
</script>

<style scoped>
/* Your existing styles remain unchanged */
.app-wrapper {
  min-height: 100vh;
  background: linear-gradient(135deg, #fdfbfb, #ebedee);
  color: #333;
  font-family: 'Poppins', sans-serif;
  transition: background 0.4s, color 0.4s;
}

.app-wrapper.dark {
  background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
  color: #f0f0f0;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  padding: 1rem 2rem;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(12px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 1000;
  transition: background 0.3s;
}

.app-wrapper.dark .navbar {
  background: rgba(30, 30, 47, 0.85);
}

.logo {
  font-size: 1.8rem;
  font-weight: 800;
  background: linear-gradient(to right, #ff6a00, #ee0979);
  -webkit-text-fill-color: transparent;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

a {
  text-decoration: none;
  color: inherit;
  font-weight: 500;
  padding: 0.4rem 0.75rem;
  border-radius: 0.5rem;
  transition: background 0.3s, color 0.3s;
}

a:hover {
  background: rgba(120, 115, 245, 0.1);
  color: #7873f5;
}

.active-link {
  color: #7873f5;
  font-weight: 600;
}

button {
  background: #7873f5;
  color: white;
  border: none;
  padding: 0.45rem 1rem;
  border-radius: 0.75rem;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.3s;
}

button:hover {
  background: #5e5bd8;
}

.toggle {
  background: transparent;
  color: inherit;
  border: 2px solid currentColor;
  font-size: 1rem;
  padding: 0.3rem 0.75rem;
  border-radius: 1rem;
  margin-left: 0.5rem;
}

.logout-btn {
  background: #ff4d4f;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
