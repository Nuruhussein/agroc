<!-- src/components/ProductCard.vue -->
<script setup>
import { ref, inject } from 'vue';

// Inject cart composable
const cart = inject('cart');

// Define props
defineProps({
  product: {
    type: Object,
    required: true,
    validator: (product) =>
      [
        'id',
        'name',
        'category',
        'farm_name',
        'description',
        'price',
        'image_path',
        'organic',
        'discount',
        'original_price',
      ].every((key) => key in product),
  },
});

// Local state for tooltip
const showCartTooltip = ref(false);
</script>

<template>
  <div
    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 h-full flex flex-col border border-gray-100 overflow-hidden group"
  >
    <!-- Product Image -->
    <div class="relative aspect-square overflow-hidden">
      <img
        v-if="product.image_path"
                 :src="`/storage/${product.image_path}`" 

        :alt="product.name"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
      />
      <!-- Badges -->
      <div class="absolute top-3 left-3 flex gap-2">
        <span
          v-if="product.organic"
          class="px-2.5 py-1 text-xs font-semibold tracking-wide bg-emerald-500/90 text-white rounded-full flex items-center backdrop-blur-sm"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-3 w-3 mr-1"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            />
          </svg>
          Organic
        </span>
        <span
          v-if="product.discount > 0"
          class="px-2.5 py-1 text-xs font-semibold tracking-wide bg-rose-500/90 text-white rounded-full backdrop-blur-sm"
        >
          {{ product.discount }}% OFF
        </span>
      </div>
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
              @mouseenter="showCartTooltip = true"
              @mouseleave="showCartTooltip = false"
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
              v-if="showCartTooltip"
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
    </div>

    <!-- Product Content -->
    <div class="p-4 flex-grow flex flex-col">
      <!-- Category -->
      <span class="text-xs font-medium text-emerald-500 uppercase tracking-wider mb-1">
        {{ product.category?.name || product.category || 'N/A' }}
      </span>

      <!-- Title -->
      <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight">
        {{ product.name }}
      </h3>

      <!-- Farm Info -->
      <div class="flex items-center mb-3">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4 text-gray-400 mr-1.5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
          />
        </svg>
        <span class="text-sm text-gray-500">{{ product.farm_name }}</span>
      </div>

      <!-- Description -->
      <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
        {{ product.description }}
      </p>

      <!-- Price -->
      <div class="mt-auto flex items-baseline">
        <span class="text-lg font-bold text-gray-900">
          ${{ Number(product.price).toFixed(2) }}
        </span>
        <span
          v-if="product.original_price && product.original_price > product.price"
          class="text-sm text-gray-400 line-through ml-2"
        >
          ${{ Number(product.original_price).toFixed(2) }}
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

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
</style>