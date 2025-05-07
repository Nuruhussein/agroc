<!-- src/components/home/FeauteredProduct.vue -->
<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
      <div class="flex my-24 justify-between items-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Featured Products</h2>
        <a
          href="/produce"
          class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center"
        >
          View All
          <svg
            class="ml-2 h-5 w-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7-7"
            />
          </svg>
        </a>
      </div>

      <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in products" :key="product.id" class="group relative">
          <div class="aspect-square w-full rounded-md bg-gray-200 overflow-hidden">
            <img
              :src="product.imageSrc"
              :alt="product.imageAlt"
              class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105"
            />

            <!-- Action Buttons Container -->
            <div
              class="absolute inset-0 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            >
              <div class="flex bg-white/90 backdrop-blur-sm px-3 py-2 rounded-full shadow-lg">
                <!-- Add to Cart Button -->
                <div class="relative">
                  <button
                    @click.stop="cart.addToCart(product)"
                    class="p-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-colors duration-200"
                    :disabled="cart.isAdding[product.id]"
                    @mouseenter="showCartTooltip = product.id"
                    @mouseleave="showCartTooltip = null"
                  >
                    <svg
                      v-if="!cart.isAdding[product.id]"
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                      />
                    </svg>
                    <svg
                      v-else
                      class="h-5 w-5 animate-spin"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                    >
                      <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                      ></circle>
                      <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                      ></path>
                    </svg>
                    <span class="sr-only">Add to cart</span>
                  </button>
                  <div
                    v-if="showCartTooltip === product.id"
                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded whitespace-nowrap"
                  >
                    Add to Cart
                    <div
                      class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-0 border-t-4 border-gray-800 border-l-transparent border-r-transparent"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Success Indicator -->
          <div
            v-if="cart.addedProductId === product.id"
            class="absolute inset-0 flex items-center justify-center pointer-events-none"
          >
            <div class="bg-white p-2 rounded-full shadow-lg animate-ping-once">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-green-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"
                />
              </svg>
            </div>
          </div>

          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm font-medium text-gray-900">
                <a :href="product.href">{{ product.name }}</a>
              </h3>
              <p class="mt-1 text-sm text-gray-500">{{ product.category }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue';

// Define props
defineProps({
  products: {
    type: Array,
    default: () => [],
  },
});

// Inject cart state and methods
const cart = inject('cart');

// Local state for tooltips
const showCartTooltip = ref(null);
</script>

<style>
@keyframes ping-once {
  0% {
    transform: scale(0.8);
    opacity: 0.7;
  }
  70% {
    transform: scale(1.2);
    opacity: 1;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.animate-ping-once {
  animation: ping-once 0.5s cubic-bezier(0, 0, 0.2, 1) forwards;
}

/* Smooth transitions for tooltips */
.tooltip-enter-active,
.tooltip-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.tooltip-enter-from,
.tooltip-leave-to {
  opacity: 0;
  transform: translateY(2px);
}
</style>