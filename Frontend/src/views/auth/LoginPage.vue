<template>
  <div class="auth-wrapper">
    <div class="auth-card" ref="card">
      <h2>Welcome Back 👋</h2>
      <form @submit.prevent="handleLogin">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit" :disabled="loading">
          {{ loading ? 'Logging in...' : 'Login' }}
        </button>
        <p v-if="error" class="error">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import gsap from 'gsap'

const email = ref('')
const password = ref('')
const error = ref(null)
const loading = ref(false)
const router = useRouter()
const card = ref(null)

const handleLogin = async () => {
  error.value = null
  loading.value = true

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
      email: email.value,
      password: password.value
    })

    const token = response.data.data.token
    const user = response.data.data.user

    if (!token) {
      throw new Error('Token missing in response')
    }

    localStorage.setItem('token', token)
    localStorage.setItem('user', JSON.stringify(user))

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

    router.push('/')
  } catch (err) {
    console.error('Login error:', err)
    error.value =
      err.response?.data?.message ||
      err.response?.data?.errors?.email?.[0] ||
      'Login failed. Please check your credentials.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  gsap.fromTo(
    card.value,
    { y: 50, opacity: 0 },
    { y: 0, opacity: 1, duration: 1.2, ease: 'power3.out' }
  )
})
</script>

<style scoped>
.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(135deg, #ff6ec4, #7873f5);
  font-family: 'Poppins', sans-serif;
}

.auth-card {
  background: white;
  padding: 2.5rem;
  border-radius: 1.25rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.auth-card h2 {
  margin-bottom: 1.5rem;
  font-weight: 600;
  color: #333;
}

input {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #ddd;
  border-radius: 0.75rem;
  font-size: 1rem;
  transition: border 0.3s;
}

input:focus {
  border-color: #7873f5;
  outline: none;
}

button {
  width: 100%;
  padding: 0.75rem;
  background: #7873f5;
  color: white;
  font-weight: 600;
  border: none;
  border-radius: 0.75rem;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #5e5bd8;
}

.error {
  color: #ff4d4f;
  margin-top: 0.5rem;
}
</style>
