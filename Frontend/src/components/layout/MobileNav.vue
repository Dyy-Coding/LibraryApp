<script setup lang="ts">
import { navItems } from '@/state/navState/navItems'; // adjust path
import { useRoute, RouterLink } from 'vue-router';
import { ref, watch } from 'vue';

const route = useRoute();
const activeIndex = ref(0);

// Update activeIndex on route change
watch(
  () => route.path,
  (newPath) => {
    const idx = navItems.findIndex(item => item.href === newPath);
    activeIndex.value = idx === -1 ? 0 : idx;
  },
  { immediate: true }
);
</script>

<template>
  <nav class="md:hidden fixed bottom-0 left-0 right-0 glassmorphism border-t border-gray-200 dark:border-gray-700 z-50 backdrop-blur-lg">
    <div class="flex justify-around items-center py-2 relative">
      <div
        class="absolute top-0 h-1 bg-gradient-to-r from-blue-500 to-pink-500 rounded-full transition-all duration-300 ease-out"
        :style="{
          width: `${100 / navItems.length}%`,
          left: `${(activeIndex * 100) / navItems.length}%`
        }"
      ></div>

      <RouterLink
        v-for="(item, index) in navItems"
        :key="item.href"
        :to="item.href"
        class="flex flex-col items-center py-2 px-4 rounded-2xl transition-all duration-300 transform"
        :class="activeIndex === index
          ? 'bg-gradient-to-r from-blue-500 to-pink-500 text-white scale-110 shadow-lg'
          : 'text-gray-600 dark:text-gray-400 hover:text-blue-500 hover:scale-105'"
        @click="activeIndex = index"
      >
        <!-- You can add icons here if needed -->
        <span class="text-xs font-medium">{{ item.label }}</span>
      </RouterLink>
    </div>
  </nav>
</template>
