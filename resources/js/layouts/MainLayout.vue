<!-- src/layouts/MainLayout.vue -->
<script setup>
import { provide } from 'vue';
import { useCart } from '@/composables/useCart';

// Initialize cart composable
const cart = useCart();

// Provide cart to child components
provide('cart', cart);

// Access Inertia props for flash messages
import { usePage } from '@inertiajs/vue3';
const { props } = usePage();
</script>

<template>
  <div>
    <!-- Flash Messages -->
    <div
      v-if="props.flash?.success"
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
    >
      {{ props.flash.success }}
    </div>
    <div
      v-if="props.flash?.error"
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
    >
      {{ props.flash.error }}
    </div>
    <!-- Render the Inertia page content -->
    <slot />
  </div>
</template>