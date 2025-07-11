<template>
  <form
    @submit.prevent="$emit('submit')"
    class="flex flex-col gap-2 px-8 pb-2 bg-[#171717] rounded-[25px] transition duration-300 hover:scale-105 hover:border hover:border-black"
  >
    <slot />
  </form>
</template>

<script setup>
defineEmits(['submit'])
</script>
