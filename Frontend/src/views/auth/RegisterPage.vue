<template>
  <div class="auth-wrapper">
    <div class="auth-card" ref="card">
      <h2>🚀 Create Your GenZ Account</h2>

      <form @submit.prevent="handleRegister">
        <input
          v-model="name"
          type="text"
          placeholder="👤 Full Name"
          required
        />

        <input
          v-model="email"
          type="email"
          placeholder="📧 Email Address"
          required
        />

        <input
          v-model="password"
          type="password"
          placeholder="🔒 Password"
          required
        />

        <input
          v-model="confirmPassword"
          type="password"
          placeholder="🔁 Confirm Password"
          required
        />

        <!-- Profile Image Upload -->
        <input
          type="file"
          @change="handleImageUpload"
          accept="image/*"
        />
        <div v-if="imagePreview" class="preview-container">
          <img :src="imagePreview" alt="Image Preview" class="preview-img" />
        </div>

        <button type="submit" :disabled="loading">
          {{ loading ? 'Registering...' : '🚀 Register' }}
        </button>

        <!-- Error Message -->
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

// Form state
const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const image = ref(null)
const imagePreview = ref(null)
const error = ref(null)
const loading = ref(false)

// Router & animation
const router = useRouter()
const card = ref(null)

// Handle image upload with validation
const handleImageUpload = (event) => {
  const file = event.target.files[0]

  if (!file) return

  if (!file.type.startsWith('image/')) {
    error.value = 'Only image files are allowed'
    return
  }

  if (file.size > 2 * 1024 * 1024) {
    error.value = 'Image size must be less than 2MB'
    return
  }

  image.value = file
  imagePreview.value = URL.createObjectURL(file)
}

// Submit registration form
const handleRegister = async () => {
  error.value = null
  loading.value = true

  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match'
    loading.value = false
    return
  }

  try {
    const formData = new FormData()
    formData.append('name', name.value)
    formData.append('email', email.value)
    formData.append('password', password.value)
    formData.append('password_confirmation', confirmPassword.value)
    if (image.value) {
      formData.append('image', image.value)
    }

    await axios.post('http://127.0.0.1:8000/api/auth/register', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    router.push('/login')
  } catch (err) {
    if (err.response?.status === 422) {
      const messages = Object.values(err.response.data.errors).flat()
      error.value = messages.join(', ')
    } else {
      error.value = 'Registration failed. Please try again.'
    }
  } finally {
    loading.value = false
  }
}

// Animate card on mount
onMounted(() => {
  gsap.fromTo(
    card.value,
    { y: 60, opacity: 0 },
    { y: 0, opacity: 1, duration: 1.2, ease: 'power4.out' }
  )
})
</script>

<style scoped>
.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 2rem;
  background: radial-gradient(circle at top, #0f0c29, #302b63, #24243e);
  font-family: 'Poppins', sans-serif;
}

.auth-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(20px);
  padding: 2.5rem;
  border-radius: 1.5rem;
  box-shadow: 0 0 40px rgba(0, 0, 0, 0.4);
  width: 100%;
  max-width: 420px;
  text-align: center;
  color: #ffffff;
}

.auth-card h2 {
  margin-bottom: 1.5rem;
  font-weight: 700;
  font-size: 1.75rem;
  background: linear-gradient(to right, #00c6ff, #0072ff);
  -webkit-text-fill-color: transparent;
}

input {
  width: 100%;
  padding: 0.8rem;
  margin-bottom: 1rem;
  border: none;
  border-radius: 0.75rem;
  font-size: 1rem;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  outline: none;
  transition: all 0.3s;
}

input::placeholder {
  color: #aaa;
}

input:focus {
  background: rgba(255, 255, 255, 0.2);
  box-shadow: 0 0 0 2px #0072ff;
}

button {
  width: 100%;
  padding: 0.9rem;
  background: linear-gradient(to right, #00c6ff, #0072ff);
  color: white;
  font-weight: 700;
  font-size: 1.1rem;
  border: none;
  border-radius: 0.75rem;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: linear-gradient(to right, #0072ff, #00c6ff);
}

.error {
  color: #ff4d4f;
  margin-top: 0.75rem;
  font-weight: 500;
  text-align: left;
}

.preview-container {
  margin: 1rem 0;
  text-align: center;
}

.preview-img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 50%;
  border: 2px solid #00c6ff;
}
</style>
