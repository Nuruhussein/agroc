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
            <div class="flex items-center space-x-2">
              <button
                @click="cart.updateQuantity(item, -1)"
                :disabled="cart.isUpdating[item.produce_id] || item.quantity <= 1"
                class="px-2 py-1 text-sm bg-gray-200 rounded"
              >
                {{ cart.isUpdating[item.produce_id] ? '...' : '-' }}
              </button>
              <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
              <button
                @click="cart.updateQuantity(item, 1)"
                :disabled="cart.isUpdating[item.produce_id]"
                class="px-2 py-1 text-sm bg-gray-200 rounded"
              >
                {{ cart.isUpdating[item.produce_id] ? '...' : '+' }}
              </button>
            </div>
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
import { inject, computed } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import Navbar from '@/components/Navbar.vue';
import footerr from '@/components/home/footerr.vue';

defineOptions({
  layout: MainLayout,
});
const cart = inject('cart');
const cartItems = computed(() => cart.cartItems.value);

console.log('Cart:', cart);
console.log('Cart items:', cartItems.value);
</script>