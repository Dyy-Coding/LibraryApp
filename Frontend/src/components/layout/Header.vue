<template>
  <header class="sticky top-0 z-50 glassmorphism border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <RouterLink to="/" class="flex items-center space-x-2 text-2xl font-bold">
          <span class="text-3xl">📚</span>
          <span class="bg-gradient-to-r from-blue-500 to-pink-500 bg-clip-text text-transparent">GenZ Library</span>
        </RouterLink>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6">
          <RouterLink to="/" class="text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Home
          </RouterLink>
          <RouterLink to="/catalog" class="text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Catalog
          </RouterLink>
          <RouterLink v-if="user" to="/dashboard" class="text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Dashboard
          </RouterLink>
          <RouterLink v-if="user?.role === 'admin'" to="/admin" class="text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Admin
          </RouterLink>
        </nav>

        <!-- Desktop Search -->
        <form @submit.prevent="handleSearch" class="hidden md:flex items-center space-x-2">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="🔍 Find books by title, author, or vibe..."
              class="w-64 pl-10 pr-4 py-2 rounded-2xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:border-blue-500 focus:outline-none transition-colors"
            />
            <Search class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
          </div>
        </form>

        <!-- Right Actions -->
        <div class="flex items-center space-x-4">
          <!-- Theme Toggle -->
          <button @click="toggleTheme" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <component :is="isDark ? Sun : Moon" class="w-5 h-5" />
          </button>

          <!-- Authenticated -->
          <template v-if="user">
            <button class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-110">
              <Bell class="w-5 h-5" />
            </button>
            <div class="flex items-center space-x-2 hover:scale-105 transition-transform duration-300">
              <span class="text-2xl">{{ user.avatar }}</span>
              <span class="hidden md:block text-sm font-medium">{{ user.name }}</span>
            </div>
            <button @click="logout" class="hidden md:block px-4 py-2 text-sm bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-all duration-300 hover:scale-105">
              Logout
            </button>
          </template>

          <!-- Guest -->
          <template v-else>
            <RouterLink to="/login" class="hidden md:inline-block px-4 py-2 text-sm bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition-all hover:scale-105">
              🚪 Log In
            </RouterLink>
            <RouterLink to="/register" class="hidden md:inline-block px-4 py-2 text-sm border-2 border-blue-500 text-blue-500 rounded-2xl hover:bg-blue-500 hover:text-white transition-all hover:scale-105">
              📝 Join Us
            </RouterLink>
          </template>

          <!-- Mobile Menu Toggle -->
          <button @click="isMenuOpen = !isMenuOpen" class="md:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <component :is="isMenuOpen ? X : Menu" class="w-5 h-5" />
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="isMenuOpen" class="md:hidden mt-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
        <form @submit.prevent="handleSearch" class="mb-4">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="🔍 Find books..."
              class="w-full pl-10 pr-4 py-2 rounded-2xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:border-blue-500 focus:outline-none"
            />
            <Search class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
          </div>
        </form>
        <nav class="space-y-2">
          <RouterLink to="/" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Home
          </RouterLink>
          <RouterLink to="/catalog" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Catalog
          </RouterLink>
          <RouterLink v-if="user" to="/dashboard" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Dashboard
          </RouterLink>
          <RouterLink v-if="user?.role === 'admin'" to="/admin" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors">
            Admin
          </RouterLink>
        </nav>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { Search, Moon, Sun, Bell, Menu, X } from 'lucide-vue-next';

const router = useRouter();
const isDark = ref(false);
const isMenuOpen = ref(false);
const searchQuery = ref('');

// Fake user mock
const user = ref({
  id: '1',
  name: 'Alex Chen',
  avatar: '🧑‍🎓',
  role: 'user'
});

const logout = () => {
  user.value = null;
};

const toggleTheme = () => {
  isDark.value = !isDark.value;
  document.documentElement.classList.toggle('dark', isDark.value);
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
};

onMounted(() => {
  const saved = localStorage.getItem('theme');
  isDark.value = saved === 'dark';
  document.documentElement.classList.toggle('dark', isDark.value);
});

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    router.push(`/catalog?search=${encodeURIComponent(searchQuery.value)}`);
    isMenuOpen.value = false;
  }
};
</script>
