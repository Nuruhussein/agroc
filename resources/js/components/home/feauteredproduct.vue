<template>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div class="flex my-24 justify-between items-center">
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">Featured Products</h2>
          <a
            href="#"
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
                d="M9 5l7 7-7 7"
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
              <div class="absolute inset-0 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="flex space-x-2 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-full shadow-lg">
                  <!-- See Details Button -->
                  <div class="relative">
                    <button
                      @click="viewDetails(product)"
                      class="p-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-colors duration-200"
                      @mouseenter="showDetailsTooltip = product.id"
                      @mouseleave="showDetailsTooltip = null"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span class="sr-only">View details</span>
                    </button>
                    <div 
                      v-if="showDetailsTooltip === product.id"
                      class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded whitespace-nowrap"
                    >
                      View Details
                      <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-0 border-t-4 border-gray-800 border-l-transparent border-r-transparent"></div>
                    </div>
                  </div>
                  
                  <!-- Add to Cart Button -->
                  <div class="relative">
                    <button
                      @click="addToCart(product)"
                      class="p-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-colors duration-200"
                      @mouseenter="showCartTooltip = product.id"
                      @mouseleave="showCartTooltip = null"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      <span class="sr-only">Add to cart</span>
                    </button>
                    <div 
                      v-if="showCartTooltip === product.id"
                      class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded whitespace-nowrap"
                    >
                      Add to Cart
                      <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-0 border-t-4 border-gray-800 border-l-transparent border-r-transparent"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Success Indicator -->
            <div 
              v-if="addedProductId === product.id"
              class="absolute inset-0 flex items-center justify-center pointer-events-none"
            >
              <div class="bg-white p-2 rounded-full shadow-lg animate-ping-once">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </div>
  
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm font-medium text-gray-900">
                  <a :href="product.href">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ product.name }}
                  </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
              </div>
              <p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const products = [
    {
      id: 1,
      name: 'Basic Tee',
      href: '#',
      imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-01-related-product-01.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: '$35',
      color: 'Black',
    },
    {
      id: 2,
      name: 'Slim Fit Jeans',
      href: '#',
      imageSrc: 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246',
      imageAlt: "Men's slim fit jeans in dark blue.",
      price: '$65',
      color: 'Dark Blue',
    },
    {
      id: 3,
      name: 'Classic Sneakers',
      href: '#',
      imageSrc: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
      imageAlt: 'White classic sneakers.',
      price: '$80',
      color: 'White',
    },
    {
      id: 4,
      name: 'Leather Jacket',
      href: '#',
      imageSrc: 'https://images.unsplash.com/photo-1551028719-6f10e6b90b5b',
      imageAlt: "Men's black leather jacket.",
      price: '$120',
      color: 'Black',
    },
  ];
  
  const cart = ref([]);
  const addedProductId = ref(null);
  const showDetailsTooltip = ref(null);
  const showCartTooltip = ref(null);
  
  const addToCart = (product) => {
    cart.value.push(product);
    addedProductId.value = product.id;
    setTimeout(() => {
      addedProductId.value = null;
    }, 1000);
  };
  
  const viewDetails = (product) => {
    // Implement your details view logic here
    console.log('Viewing details for:', product.name);
  };
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