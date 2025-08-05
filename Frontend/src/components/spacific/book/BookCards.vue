<template>
  <div class="bg-white rounded-2xl shadow p-4 hover:shadow-lg transition">
    <img :src="book.image_url" :alt="book.title" class="w-full h-48 object-cover rounded-xl mb-4" />
    <h2 class="text-lg font-semibold mb-1">{{ book.title }}</h2>
    <p class="text-sm text-gray-600">ISBN: {{ book.isbn }}</p>
    <p class="text-sm text-gray-700 mt-1">Author: {{ book.author?.name }}</p>
    <slot />
  </div>
</template>

<script setup>
defineProps({
  book: {
    type: Object,
    required: true
  }
});
</script>
