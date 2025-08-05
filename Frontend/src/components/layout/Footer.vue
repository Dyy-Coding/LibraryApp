<template>
  <footer class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-6 mt-10 shadow-inner transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
      
      <!-- Left: Logo -->
      <div class="flex items-center gap-2 text-lg font-semibold">
        <i class="fas fa-book-open"></i>
        <span>LibraryVibe</span>
      </div>

      <!-- Center: Navigation -->
      <ul class="flex space-x-4 text-sm">
        <li v-for="item in navItems" :key="item.href">
          <a
            :href="item.href"
            class="hover:text-yellow-300 transition duration-300"
          >
            {{ item.label }}
          </a>
        </li>
      </ul>

      <!-- Right: Social Media -->
      <div class="flex space-x-4">
        <a href="https://facebook.com" target="_blank" class="hover:text-yellow-300">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com" target="_blank" class="hover:text-yellow-300">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://instagram.com" target="_blank" class="hover:text-yellow-300">
          <i class="fab fa-instagram"></i>
        </a>
      </div>
    </div>

    <!-- Bottom Note -->
    <div class="text-center text-xs mt-4 text-gray-200">
      © {{ new Date().getFullYear() }} LibraryVibe. All rights reserved.
    </div>
  </footer>
</template>

<script setup>
import { navItems } from '@/state/navState/navItems'
</script>
