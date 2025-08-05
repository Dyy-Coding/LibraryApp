<template>
  <header
    class="sticky top-0 z-50 glassmorphism border-b border-gray-200 dark:border-gray-700 shadow-sm backdrop-blur-md"
  >
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <!-- Logo -->
      <RouterLink
        to="/"
        class="flex items-center space-x-2 text-2xl font-extrabold select-none cursor-pointer"
        title="Go to homepage"
      >
        <span class="text-4xl animate-bounce">📚</span>
        <span
          class="bg-gradient-to-r from-blue-500 to-pink-500 bg-clip-text text-transparent"
          >GenZ Library</span
        >
      </RouterLink>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex items-center space-x-6 font-medium tracking-wide">
        <RouterLink
          v-for="item in navItems"
          :key="item.href"
          :to="item.href"
          class="text-gray-700 dark:text-gray-200 hover:text-blue-500 transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
          tabindex="0"
        >
          {{ item.label }}
        </RouterLink>
      </nav>

      <!-- Desktop Search -->
      <form @submit.prevent="handleSearch" class="hidden md:flex items-center space-x-2" role="search" aria-label="Site search">
        <div class="relative">
          <input
            v-model="searchQuery"
            type="search"
            placeholder="🔍 Find books by title, author, or vibe..."
            class="w-64 pl-12 pr-4 py-2 rounded-3xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition duration-300 shadow-sm"
            aria-label="Search books"
            autocomplete="off"
          />
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 select-none pointer-events-none text-lg">
            🔍
          </span>
        </div>
      </form>

      <!-- Right Actions -->
      <div class="flex items-center space-x-4">
        <!-- Theme toggle button -->
        <button
          @click="toggleTheme"
          class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400"
          aria-label="Toggle light/dark theme"
          title="Toggle theme"
        >
          <span class="select-none text-2xl" aria-hidden="true">{{ isDark ? '☀️' : '🌙' }}</span>
        </button>

        <!-- Auth-dependent buttons -->
        <template v-if="user">
          <button
            class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-transform duration-300 hover:scale-110 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400"
            aria-label="Notifications"
            title="Notifications"
          >
            <span class="select-none text-2xl" aria-hidden="true">🔔</span>
          </button>
          <div
            class="flex items-center space-x-3 cursor-pointer hover:scale-105 transition-transform duration-300"
            aria-label="User info"
            tabindex="0"
            title="User profile"
          >
            <span class="text-3xl select-none">{{ user.avatar }}</span>
            <span class="hidden md:block text-sm font-semibold">{{ user.name }}</span>
          </div>
          <button
            @click="logout"
            class="hidden md:block px-5 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded-3xl transition-transform duration-300 hover:scale-105 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-400"
          >
            Logout
          </button>
        </template>
        <template v-else>
          <RouterLink
            to="/login"
            class="hidden md:inline-block px-5 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-3xl transition-transform duration-300 hover:scale-105 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400"
          >
            🚪 Log In
          </RouterLink>
          <RouterLink
            to="/register"
            class="hidden md:inline-block px-5 py-2 text-sm border-2 border-blue-600 text-blue-600 rounded-3xl hover:bg-blue-600 hover:text-white transition-transform duration-300 hover:scale-105 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400"
          >
            📝 Join Us
          </RouterLink>
        </template>

        <!-- Mobile Menu Button -->
        <button
          @click="isMenuOpen = !isMenuOpen"
          class="md:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400"
          aria-label="Toggle mobile menu"
          title="Toggle mobile menu"
        >
          <span class="select-none text-3xl" aria-hidden="true">{{ isMenuOpen ? '❌' : '☰' }}</span>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <transition name="fade-slide">
      <div
        v-if="isMenuOpen"
        class="md:hidden mt-4 px-6 py-5 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-lg"
      >
        <form @submit.prevent="handleSearch" class="mb-5" role="search" aria-label="Mobile site search">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="search"
              placeholder="🔍 Find books..."
              class="w-full pl-12 pr-4 py-2 rounded-3xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition duration-300 shadow-sm"
              aria-label="Search books"
              autocomplete="off"
            />
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 select-none pointer-events-none text-lg">
              🔍
            </span>
          </div>
        </form>
        <nav class="flex flex-col space-y-3 text-lg font-semibold">
          <RouterLink
            v-for="item in navItems"
            :key="item.href"
            :to="item.href"
            class="block py-2 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 transition-colors duration-300"
            @click="isMenuOpen = false"
          >
            {{ item.label }}
          </RouterLink>
        </nav>
      </div>
    </transition>
  </header>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { navItems } from '@/state/navState/navItems';

const isDark = ref(localStorage.getItem('theme') === 'dark');
function toggleTheme() {
  isDark.value = !isDark.value;
  document.documentElement.classList.toggle('dark', isDark.value);
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
}

const router = useRouter();
const searchQuery = ref('');
const isMenuOpen = ref(false);

const user = ref<null | { name: string; avatar: string; role: 'user' | 'admin' }>({
  name: 'Alex Chen',
  avatar: '🧑‍🎓',
  role: 'user',
});

function logout() {
  user.value = null;
  router.push('/');
}

function handleSearch() {
  if (searchQuery.value.trim()) {
    router.push(`/catalog?search=${encodeURIComponent(searchQuery.value.trim())}`);
    isMenuOpen.value = false;
  }
}
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
