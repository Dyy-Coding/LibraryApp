<template>
  <div class="container mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">📚 Book Collection</h1>

    <div v-if="bookStore.loading" class="text-blue-500">Loading...</div>
    <div v-else-if="bookStore.error" class="text-red-500">{{ bookStore.error }}</div>
    <BookList v-else :books="bookStore.books" />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useBooksStore } from '@/state/bookState/books';
import BookList from '@/components/spacific/book/BookList.vue';

const bookStore = useBooksStore();

onMounted(() => {
  bookStore.fetchBooks();
});
</script>
