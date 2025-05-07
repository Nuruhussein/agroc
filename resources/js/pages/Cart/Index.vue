<!-- src/pages/Cart/Index.vue -->
<template>
  <Navbar />
  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">Your Cart</h2>
      <div v-if="cartItems.length" class="mt-8">
        <div v-for="item in cartItems" :key="item.id" class="flex items-center py-4 border-b">
          <img
            :src="item.imageSrc"
            :alt="item.imageAlt"
            class="w-24 h-24 object-cover rounded-md"
          />
          <div class="ml-4 flex-1">
            <h3 class="text-lg font-medium text-gray-900">{{ item.name }}</h3>
            <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
            <p class="text-sm font-medium text-gray-900">{{ item.price }}</p>
          </div>
        </div>
      </div>
      <div v-else class="mt-8 text-center">
        <p class="text-gray-500">Your cart is empty.</p>
      </div>
    </div>
  </div>
  <footerr />
</template>

<script setup>
import { inject, computed, watch } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import Navbar from '@/components/Navbar.vue';
import footerr from '@/components/home/footerr.vue';

const cart = inject('cart');
const cartItems = computed(() => cart.cartItems.value); // Access .value for Ref

// watch(cartItems, (newItems) => {
//   console.log('Cart items updated:', newItems);
// }, { immediate: true, deep: true });

// console.log('Cart:', cart);
// console.log('Cart items:', cartItems.value);

defineOptions({
  layout: MainLayout,
});
</script>