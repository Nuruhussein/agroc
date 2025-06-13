<!-- src/Pages/markateplace/UserProfile.vue -->
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import Footerr from '@/components/home/footer.vue';
import ProductCard from '@/components/ProductCard.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { User, MapPin, Phone, Mail } from 'lucide-vue-next';

defineOptions({
  layout: MainLayout,
});

defineProps({
  user: {
    type: Object,
    required: true,
    validator: (user) =>
      ['id', 'name', 'email', 'phone', 'region', 'role', 'profile_picture'].every(
        (key) => key in user
      ),
  },
  products: Object,
});
</script>

<template>
  <Head :title="`${user.name}'s Profile`" />
  <Navbar />

  <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
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
        Back to Marketplace
      </Link>

      <!-- User Profile Card -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100/50 overflow-hidden">
        <!-- Profile Header -->
        <div class="p-8 bg-gradient-to-br from-indigo-500/10 to-emerald-500/10">
          <div class="flex flex-col sm:flex-row items-center gap-6">
            <img
              :src="user.profile_picture ? `/storage/${user.profile_picture}` : '/images/default-profile-picture.jpg'"
              :alt="`${user.name}'s Profile Picture`"
              class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 transition-transform duration-200 hover:scale-105"
            />
            <div class="text-center sm:text-left">
              <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
              <p class="text-sm text-gray-500 capitalize">{{ user.role || 'Farmer' }}</p>
              <p class="text-sm text-gray-600 mt-1">{{ user.farm_name || 'No farm specified' }}</p>
            </div>
          </div>
        </div>

        <!-- User Details -->
        <div class="p-8 border-t border-gray-100/50">
          <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <User class="h-5 w-5 text-indigo-500" />
            About {{ user.name }}
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex items-center gap-3">
              <Mail class="h-5 w-5 text-indigo-500" />
              <div>
                <h4 class="text-sm font-medium text-gray-500">Email</h4>
                <p class="text-base text-gray-900">{{ user.email || 'N/A' }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <Phone class="h-5 w-5 text-indigo-500" />
              <div>
                <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                <p class="text-base text-gray-900">{{ user.phone || 'N/A' }}</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <MapPin class="h-5 w-5 text-indigo-500" />
              <div>
                <h4 class="text-sm font-medium text-gray-500">Region</h4>
                <p class="text-base text-gray-900">{{ user.region || 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Products Section -->
        <div class="p-8 border-t border-gray-100/50">
          <h2 class="text-lg font-semibold text-gray-800 mb-6">Products by {{ user.name }}</h2>
          <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <ProductCard
              v-for="product in products.data"
              :key="product.id"
              :product="product"
              class="transition-transform hover:scale-[1.02]"
            />
          </div>
          <div v-else class="text-center py-12">
            <div class="max-w-md mx-auto">
              <div class="w-20 h-20 mx-auto mb-4 text-gray-300">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-800 mb-2">No products available</h3>
              <p class="text-gray-500">This farmer currently has no products listed.</p>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="products.data.length > 0" class="mt-8 flex justify-center">
            <nav class="flex items-center gap-1">
              <Link
                v-for="(link, index) in products.links"
                :key="index"
                :href="link.url || '#'"
                :class="[
                  'px-3 py-1 rounded-md text-sm font-medium',
                  link.active ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100',
                  !link.url ? 'opacity-50 cursor-not-allowed' : '',
                ]"
                v-html="link.label"
                preserve-state
              />
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footerr />
</template>

<style scoped>
.rounded-2xl {
  border-radius: 1rem;
}

.shadow-xl {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.transition-colors {
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.transition-transform {
  transition: transform 0.3s ease;
}
</style>