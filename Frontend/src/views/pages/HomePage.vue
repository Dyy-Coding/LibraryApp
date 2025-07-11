<template>
  <div class="home-wrapper">
    <h1 class="title">👥 GenZ User Directory</h1>

    <div v-if="loading" class="status">Loading users...</div>
    <div v-if="error" class="status error">{{ error }}</div>

    <div class="card-grid">
      <div v-for="user in users" :key="user.id" class="user-card">
        <img
          :src="user.image || 'https://i.pravatar.cc/150?u=' + user.id"
          alt="User Image"
          class="user-image"
        />
        <h3>{{ user.name }}</h3>
        <p>{{ user.email }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const loading = ref(true)
const error = ref(null)

const fetchUsers = async () => {
  loading.value = true
  error.value = null

  try {
    const token = localStorage.getItem('token')
    if (!token) throw new Error('Not authenticated')

    const res = await axios.get('http://127.0.0.1:8000/api/auth/users', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    users.value = res.data.data || res.data  // adjust depending on API response shape
  } catch (err) {
    error.value = 'Failed to load users. Please login.'
  } finally {
    loading.value = false
  }
}

onMounted(fetchUsers)
</script>


<style scoped>
.home-wrapper {
  padding: 2rem;
  min-height: 100vh;
  background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
  font-family: 'Poppins', sans-serif;
}

.title {
  font-size: 2.2rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 2rem;
  color: #333;
}

.status {
  text-align: center;
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 1rem;
}

.status.error {
  color: #ff4d4f;
}

.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
}

.user-card {
  background: white;
  border-radius: 1rem;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.user-card:hover {
  transform: translateY(-8px);
}

.user-image {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 1rem;
  border: 3px solid #8ec5fc;
}
</style>
