 <template>
  <button
    :type="type"
    :class="[
      'px-6 py-2 rounded text-white transition duration-300',
      variant === 'primary' ? 'bg-[#252525] hover:bg-black' :
      variant === 'danger' ? 'bg-[#252525] hover:bg-red-600' :
      'bg-[#252525] hover:bg-gray-700'
    ]"
  >
    <slot />
  </button>
</template>

<script setup>
defineProps({
  type: {
    type: String,
    default: 'button'
  },
  variant: {
    type: String,
    default: 'primary'
  }
})
</script>
