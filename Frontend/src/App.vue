<template>
  <div :class="{ dark: isDark }" class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Navigation (Header + Mobile Nav) -->
    <Navigation />

    <!-- Main content wrapper -->
    <main class="flex-grow container mx-auto px-4 py-6 md:py-10">
      <router-view />
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Navigation from '@/components/layout/Navegation.vue'; // fixed typo "Navegation" → "Navigation"
import Footer from '@/components/layout/Footer.vue';

const isDark = ref(false);

onMounted(() => {
  const savedTheme = localStorage.getItem('theme');
  isDark.value = savedTheme === 'dark';
  document.documentElement.classList.toggle('dark', isDark.value);
});
</script>

<style>
body {
  transition: background-color 0.3s ease;
}
</style>
