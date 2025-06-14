<template>
    <!-- Price Guide Preview - All in One Component -->
    <section id="price" class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-3xl font-bold text-gray-900">Current Market Prices</h2>
          <a 
            href="#" 
            @click.prevent="viewFullGuide"
            class="text-indigo-600 hover:text-indigo-700 font-medium flex items-center transition-colors"
          >
            View Full Guide
            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </div>
        
        <!-- Pricing Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Price Card - Repeated for each item -->
          <div 
            v-for="(item, index) in marketPrices" 
            :key="index" 
            class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300"
          >
            <div class="p-6">
              <!-- Card Header -->
              <div class="flex justify-between items-start">
                <h3 class="text-xl font-semibold text-gray-900">{{ item.commodity }}</h3>
                <span 
                  class="px-2 py-1 rounded-full text-xs font-medium"
                  :class="trendColor(item.trend)"
                >
                  {{ item.change }}
                </span>
              </div>
              
              <!-- Price Display -->
              <p class="mt-2 text-2xl font-bold text-gray-900">{{ item.price }}</p>
              
              <!-- Location Info -->
              <div class="mt-4 flex items-center text-sm text-gray-500">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ item.region }}
              </div>
              
              <!-- Last Updated -->
              <div class="mt-3 text-xs text-gray-400">
                Updated {{ item.updated }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();

// Get market prices from props
const marketPrices = computed(() => props.marketPrices || []);

// Determine trend color
const trendColor = (trend) => {
  return trend === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
};

// Handle view full guide click
const viewFullGuide = () => {
  // In a real app, you would navigate to the full guide page
  console.log('Navigating to full price guide');
  // router.get('/pricing'); // If using Inertia router
};
</script>

<style scoped>
/* Custom transitions */
.price-card {
  transition: all 0.3s ease;
}

.price-card:hover {
  transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .price-header {
    font-size: 2rem;
  }
}
</style>