<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <BookCard
      v-for="book in books"
      :key="book.id"
      :book="book"
    >
      <RouterLink
        :to="`/books/${book.id}`"
        class="text-blue-500 mt-2 inline-block hover:underline"
      >
        View Details
      </RouterLink>
    </BookCard>
  </div>
</template>

<script setup>
import BookCard from './BookCard.vue';

defineProps({
  books: {
    type: Array,
    required: true
  }
});
</script>
