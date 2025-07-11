<script setup>
import { onMounted } from 'vue'
import { useAuthorStore } from '@/state/authorState/author'

const store = useAuthorStore()

onMounted(() => {
  store.fetchAuthors()
})
</script>

<template>
  <div class="p-6">
    <!-- Loading State -->
    <div v-if="store.loading" class="text-center text-lg font-bold text-purple-500 animate-pulse">
      Loading authors...
    </div>

    <!-- Error State -->
    <div v-else-if="store.error" class="text-center text-red-600 font-medium bg-red-50 p-3 rounded-md">
      {{ store.error }}
    </div>

    <!-- Data Table -->
    <div v-else class="overflow-x-auto bg-white shadow-xl rounded-2xl p-5 border border-gray-200">
      <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-white uppercase bg-gradient-to-r from-fuchsia-500 to-indigo-500 rounded-t-xl">
          <tr>
            <th class="px-6 py-3 rounded-tl-2xl">👤 Author</th>
            <th class="px-6 py-3">🎂 DOB</th>
            <th class="px-6 py-3">🌎 Nationality</th>
            <th class="px-6 py-3 text-center">📚 Books</th>
            <th class="px-6 py-3 rounded-tr-2xl">📖 Book Details</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="author in store.authors.data"
            :key="author.id"
            class="border-b hover:bg-fuchsia-50 transition-all duration-200"
          >
            <td class="px-6 py-4 font-semibold text-gray-900">
              {{ author.name }}
            </td>
            <td class="px-6 py-4">{{ author.dateofbirth }}</td>
            <td class="px-6 py-4">{{ author.nationality }}</td>
            <td class="px-6 py-4 text-center font-bold text-indigo-600">
              {{ author.numberOfWrittenBook }}
            </td>
            <td class="px-6 py-4">
              <div
                v-for="book in author.books"
                :key="book.id"
                class="flex items-center gap-4 mb-2"
              >
                <img
                  :src="book.cover_image"
                  alt="Book Cover"
                  class="w-12 h-12 rounded-lg border border-gray-200 shadow-sm"
                />
                <div>
                  <p class="text-gray-900 font-medium">{{ book.title }}</p>
                  <p class="text-xs text-gray-500 italic">
                    {{ book.publication_year }} • {{ book.category }}
                  </p>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-6 flex items-center justify-center text-sm text-gray-600 gap-2">
        <span>Page {{ store.authors.meta?.current_page }} of {{ store.authors.meta?.last_page }}</span>
        <!-- Optional Pagination Buttons -->
        <!--
        <button class="ml-2 px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600">
          Previous
        </button>
        <button class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600">
          Next
        </button>
        -->
      </div>
    </div>
  </div>
</template>
