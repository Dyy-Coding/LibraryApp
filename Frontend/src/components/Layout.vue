<template>
  <div class="min-h-screen">
    <Header />
    <main class="pb-20 md:pb-0">
      <slot />
    </main>
    <MobileNav />
  </div>
</template>

<script setup lang="ts">
// Import your Vue components
import Header from '@/components/layout/Navegation.vue';
import MobileNav from '@/components/layout/Footer.vue';
</script>
