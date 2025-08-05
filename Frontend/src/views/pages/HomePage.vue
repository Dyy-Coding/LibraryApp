<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-pink-50 to-green-50 dark:from-gray-900 dark:via-purple-900 dark:to-gray-900 particle-bg">
      <div class="container mx-auto px-4 py-16 md:py-24 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 stagger-animation">
          <span class="text-5xl md:text-7xl block mb-2 float-animation">📚</span>
          <span class="gradient-text">Welcome to GenZ Library</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto slide-up">
          Read anywhere, anytime. Borrow your next favorite story today.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center scale-in">
          <router-link
            to="/catalog"
            class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-pink-500 text-white rounded-2xl font-semibold text-lg hover:from-blue-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-110 pulse-glow shadow-lg hover:shadow-2xl"
          >
            🔥 Start Exploring
            <ArrowRight class="inline ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </router-link>
          <div class="flex flex-wrap items-center justify-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center space-x-1">
              <Book class="w-4 h-4" />
              <span>10,000+ Books</span>
            </div>
            <div class="flex items-center space-x-1">
              <Users class="w-4 h-4" />
              <span>Active Community</span>
            </div>
            <div class="flex items-center space-x-1">
              <Star class="w-4 h-4" />
              <span>4.9 Rating</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Books -->
    <section class="py-16 bg-white dark:bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
          <h2 class="text-3xl font-bold text-gray-800 dark:text-white">🔥 Featured Books</h2>
          <router-link to="/catalog" class="text-blue-500 hover:text-blue-600 font-semibold flex items-center space-x-1">
            <span>View All</span>
            <ArrowRight class="w-4 h-4" />
          </router-link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(book, index) in featuredBooks" :key="book.id" class="slide-up" :style="{ animationDelay: `${index * 0.1}s` }">
            <BookCard :book="book" />
          </div>
        </div>
      </div>
    </section>

    <!-- Trending Section -->
    <section class="py-16 bg-gradient-to-r from-blue-50 to-pink-50 dark:from-gray-900 dark:to-purple-900 particle-bg">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 slide-up">
            <TrendingUp class="inline w-8 h-8 mr-2 text-pink-500" /> Trending Now
          </h2>
          <p class="text-gray-600 dark:text-gray-300 slide-up">
            Discover what the community is reading right now
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 stagger-animation">
          <div v-for="book in trendingBooks" :key="book.id">
            <BookCard :book="book" variant="trending" />
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white dark:bg-gray-800 particle-bg">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 stagger-animation">
          <div v-for="(stat, index) in stats" :key="index" class="text-center">
            <div class="text-4xl mb-2 float-animation" :style="{ animationDelay: `${index * 0.5}s` }">
              {{ stat.emoji }}
            </div>
            <div class="text-2xl font-bold text-gray-800 dark:text-white mb-1">{{ stat.number }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-500 to-pink-500 particle-bg">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4 slide-up">
          Ready to Start Your Reading Journey?
        </h2>
        <p class="text-xl text-blue-100 mb-8 slide-up">
          Join thousands of readers discovering their next favorite book
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center scale-in">
          <router-link
            to="/catalog"
            class="px-8 py-4 bg-white text-blue-500 rounded-2xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-2xl"
          >
            📖 Browse Books
          </router-link>
          <router-link
            to="/register"
            class="px-8 py-4 border-2 border-white text-white rounded-2xl font-semibold hover:bg-white hover:text-blue-500 transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-2xl"
          >
            📝 Join Free
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { ArrowRight, Book, Users, Star, TrendingUp } from 'lucide-vue-next'
import BookCard from '@/components/spacific/book/BookCards.vue'

const featuredBooks = ref([
  { id: 1, title: 'Atomic Habits', author: 'James Clear' },
  { id: 2, title: 'The Alchemist', author: 'Paulo Coelho' },
  { id: 3, title: '1984', author: 'George Orwell' },
  { id: 4, title: 'To Kill a Mockingbird', author: 'Harper Lee' },
])

const trendingBooks = ref([
  { id: 5, title: 'The Subtle Art of Not Giving a F*ck', author: 'Mark Manson' },
  { id: 6, title: 'Becoming', author: 'Michelle Obama' },
  { id: 7, title: 'Sapiens', author: 'Yuval Noah Harari' },
])

const stats = ref([
  { emoji: '📚', number: '10,000+', label: 'Books Available' },
  { emoji: '👥', number: '25,000+', label: 'Active Readers' },
  { emoji: '⭐', number: '4.9', label: 'Average Rating' },
  { emoji: '🔄', number: '500+', label: 'Daily Borrows' }
])
</script>