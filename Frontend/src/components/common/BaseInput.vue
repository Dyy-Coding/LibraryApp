<template>
  <div
    class="flex items-center gap-2 px-4 py-3 rounded-[25px] bg-[#171717] shadow-[inset_2px_5px_10px_rgb(5,5,5)] text-white"
  >
    <slot name="icon" />
    <input
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="w-full bg-transparent border-none outline-none text-gray-300 placeholder-gray-500"
    />
  </div>
</template>

<script setup>
defineProps({
  placeholder: String,
  type: {
    type: String,
    default: 'text',
  },
  modelValue: String,
})
defineEmits(['update:modelValue'])
</script>
