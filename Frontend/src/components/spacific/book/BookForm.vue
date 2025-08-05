<template>
  <form @submit.prevent="onSubmit" class="space-y-4 max-w-xl mx-auto">
    <div>
      <label class="block text-sm font-medium text-gray-700">Title</label>
      <input
        v-model="form.title"
        type="text"
        class="w-full p-2 border rounded"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">ISBN</label>
      <input
        v-model="form.isbn"
        type="text"
        class="w-full p-2 border rounded"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Author Name</label>
      <input
        v-model="form.author.name"
        type="text"
        class="w-full p-2 border rounded"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Cover Image URL</label>
      <input
        v-model="form.cover_image"
        type="text"
        class="w-full p-2 border rounded"
      />
    </div>

    <button
      type="submit"
      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
    >
      {{ isEditMode ? 'Update Book' : 'Add Book' }}
    </button>
  </form>
</template>

<script setup>
import { reactive, watch, toRefs } from 'vue';

const props = defineProps({
  book: {
    type: Object,
    default: () => ({
      title: '',
      isbn: '',
      cover_image: '',
      author: { name: '' }
    })
  },
  isEditMode: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['submit']);

const form = reactive({ ...props.book });

// Sync when prop updates
watch(() => props.book, (newVal) => {
  Object.assign(form, newVal);
});

const onSubmit = () => {
  emit('submit', { ...form });
};
</script>
