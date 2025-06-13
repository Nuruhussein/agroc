<!-- src/components/ProduceDetails.vue -->
<script setup>
import Footer from '@/components/home/footer.vue';
import Navbar from '@/components/Navbar.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, inject } from 'vue';
import { 
  Leaf,
  Tag,
  DollarSign,
  Percent,
  Package,
  MapPin,
  Image as ImageIcon,
  User,
  ShoppingCart,
  MessageCircle
} from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({
  layout: MainLayout,
});

defineProps({
  produce: {
    type: Object,
    required: true,
    validator: (produce) =>
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
      ].every((key) => key in produce),
  },
});

// Inject cart composable
const cart = inject('cart');

// Add-to-cart handler
const handleAddToCart = async (produce) => {
  if (!cart || !cart.addToCart) return;

  await cart.addToCart(produce);
  router.visit('/cart');
};
</script>

<template>
  <Head :title="produce.name || 'Produce Details'" />
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Back Button -->
      <Link
        :href="route('markateplace')"
        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-indigo-600 mb-6 transition-colors"
      >
        <svg
          class="h-5 w-5 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
        Back to markateplace
      </Link>

      <!-- Single Card Container -->
      <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100/50">
        <!-- Header Section: Image and Basic Info -->
        <div class="md:flex">
          <!-- Image -->
          <div class="md:w-1/2">
            <div v-if="produce.image_path" class="relative h-80 md:h-96">
              <img
                :src="`/storage/${produce.image_path}`"
                :alt="produce.name || 'Produce Image'"
                class="w-full h-full object-cover rounded-t-3xl md:rounded-l-3xl md:rounded-t-none transition-transform duration-500 hover:scale-105"
              />
            </div>
            <div v-else class="h-80 md:h-96 flex items-center justify-center bg-gray-100 rounded-t-3xl md:rounded-l-3xl md:rounded-t-none">
              <ImageIcon class="h-16 w-16 text-gray-400" />
              <span class="ml-2 text-gray-500">No Image Available</span>
            </div>
          </div>
          <!-- Basic Info -->
          <div class="p-8 md:w-1/2 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-3 mb-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ produce.name || 'Unnamed Produce' }}</h1>
                <span
                  v-if="produce.organic"
                  class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/90 text-white backdrop-blur-sm"
                >
                  <Leaf class="h-4 w-4" />
                  Organic
                </span>
              </div>
              <p class="text-lg font-semibold text-gray-900 mb-2">
                ${{ produce.price ? Number(produce.price).toFixed(2) : 'N/A' }}
                <span v-if="produce.original_price && produce.discount" class="text-sm text-gray-400 line-through ml-2">
                  ${{ Number(produce.original_price).toFixed(2) }}
                </span>
                <span v-if="produce.discount" class="ml-2 text-sm font-semibold text-rose-500">
                  {{ produce.discount }}% Off
                </span>
              </p>
              <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">{{ produce.description || 'No description provided.' }}</p>
            </div>
            <div class="space-y-4">
              <!-- Add to Cart Button -->
              <button
                @click.prevent="handleAddToCart(produce)"
                class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-200 disabled:opacity-50"
                :disabled="cart.isAdding[produce.id]"
              >
                <ShoppingCart class="h-5 w-5" />
                <span v-if="!cart.isAdding[produce.id]">Add to Cart</span>
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
              </button>
              <!-- Chat Button -->
              <Link
                v-if="produce.user?.id"
                :href="`/chat/${produce.user.id}`"
                class="inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-white text-gray-700 font-semibold border border-gray-200 hover:bg-gray-50 transition-colors"
              >
                <MessageCircle class="h-5 w-5 mr-2" />
                Chat with Farmer
                <span class="sr-only">Chat with {{ produce.user?.name || 'Farmer' }}</span>
              </Link>
              <button
                v-else
                disabled
                class="inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-gray-200 text-gray-500 font-semibold cursor-not-allowed"
              >
                <MessageCircle class="h-5 w-5 mr-2" />
                Chat Unavailable
              </button>
            </div>
          </div>
        </div>

        <!-- Additional Info Section -->
        <div class="border-t border-gray-100/50">
          <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- About This Produce -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <Package class="h-5 w-5 text-indigo-500" />
                About This Produce
              </h3>
              <div class="space-y-4">
                <div class="flex items-center gap-3">
                  <img
                    :src="produce.user?.profile_picture ? `/storage/${produce.user.profile_picture}` : '/images/default-profile-picture.jpg'"
                    alt="Profile Picture"
                    class="w-10 h-10 rounded-full object-cover border-2 border-indigo-200"
                  />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Farmer</h4>
                    <p class="text-base font-medium text-gray-900">{{ produce.user?.name || 'N/A' }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <Tag class="h-5 w-5 text-indigo-500" />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Category</h4>
                    <p class="text-base font-medium text-gray-900">{{ produce.category?.name || produce.category || 'N/A' }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <MapPin class="h-5 w-5 text-indigo-500" />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Farm Location</h4>
                    <p class="text-base font-medium text-gray-900">
                      {{ produce.farm_name ? `${produce.farm_name} • ${produce.location || 'N/A'}` : produce.location || 'N/A' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pricing & Availability -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <DollarSign class="h-5 w-5 text-indigo-500" />
                Pricing & Availability
              </h3>
              <div class="space-y-4">
                <div class="flex items-center gap-3">
                  <DollarSign class="h-5 w-5 text-indigo-500" />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Current Price</h4>
                    <p class="text-lg font-bold text-gray-900">${{ produce.price ? Number(produce.price).toFixed(2) : 'N/A' }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <Percent class="h-5 w-5 text-indigo-500" />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Discount</h4>
                    <p class="text-lg font-semibold text-rose-600">{{ produce.discount ? `${produce.discount}%` : 'None' }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <Package class="h-5 w-5 text-indigo-500" />
                  <div>
                    <h4 class="text-sm font-medium text-gray-500">Available</h4>
                    <p class="text-lg font-semibold text-gray-900">{{ produce.quantity || 'N/A' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
.line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.transition-colors {
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

img {
  transition: transform 0.4s ease-in-out;
}

.rounded-3xl {
  border-radius: 12px;
}

.h-96 {
  height: 24rem;
}

@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}

.shadow-xl {
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

.border-gray-100{
  border-color: rgba(243, 244, 246, 0.5);
}
</style>