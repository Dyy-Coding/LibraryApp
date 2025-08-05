<template>
  <div class="max-w-2xl mx-auto bg-white rounded-xl p-6 shadow">
    <img :src="book.image_url" :alt="book.title" class="w-full h-64 object-cover rounded-lg mb-4" />
    <h1 class="text-2xl font-bold mb-2">{{ book.title }}</h1>
    <p class="text-gray-700"><strong>ISBN:</strong> {{ book.isbn }}</p>
    <p class="text-gray-700"><strong>Author:</strong> {{ book.author?.name }}</p>
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
