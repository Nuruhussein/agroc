<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/home/footer.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { User } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({
  layout: MainLayout,
});
const props = defineProps({
  farmers: Object,
  filters: Object,
  regions: Array,
});

// Initialize filter form with current filters
const filterForm = useForm({
  search: props.filters.search || '',
  region: props.filters.region || '',
  produce_min: props.filters.produce_min || '',
  produce_max: props.filters.produce_max || '',
});

// Apply filters with debounce
const applyFilters = () => {
  router.get(
    '/profiles',
    {
      search: filterForm.search,
      region: filterForm.region,
      produce_min: filterForm.produce_min,
      produce_max: filterForm.produce_max,
    },
    {
      preserveState: true,
      preserveScroll: true,
      only: ['farmers', 'filters'],
    }
  );
};

// Watch for filter changes and apply with debounce
const debounce = (fn, delay) => {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => fn(...args), delay);
  };
};
watch(
  () => [filterForm.search, filterForm.region, filterForm.produce_min, filterForm.produce_max],
  debounce(applyFilters, 300)
);

// Pagination handler
const changePage = (url) => {
  if (url) {
    router.visit(url, {
      preserveState: true,
      preserveScroll: true,
    });
  }
};

// Clear filters
const clearFilters = () => {
  filterForm.reset();
  applyFilters();
};
</script>

<template>
  <Head title="Farmer Profiles" />
  <Navbar />
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Farmer Profiles</h1>
      <p class="mt-2 text-sm text-gray-600">Discover our talented farmers and their fresh produce.</p>
    </div>

    <!-- Layout: Sidebar + Grid -->
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Sidebar Filters -->
      <div class="lg:w-72 bg-white rounded-2xl shadow-lg p-6 sticky top-4">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Filters</h2>
        <form class="space-y-6">
          <!-- Search Input -->
          <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input
              id="search"
              v-model="filterForm.search"
              type="text"
              placeholder="Search by name or region..."
              class="mt-2 block w-full rounded-md border-gray-300 h-12 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
              :class="{ 'border-red-500': filterForm.errors.search }"
            />
            <p v-if="filterForm.errors.search" class="mt-2 text-sm text-red-600">{{ filterForm.errors.search }}</p>
          </div>
          <!-- Region Filter -->
          <div>
            <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
            <select
              id="region"
              v-model="filterForm.region"
              class="mt-2 block w-full rounded-md border-gray-300 h-12 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
              :class="{ 'border-red-500': filterForm.errors.region }"
            >
              <option value="">All Regions</option>
              <option v-for="region in regions" :key="region" :value="region">{{ region }}</option>
            </select>
            <p v-if="filterForm.errors.region" class="mt-2 text-sm text-red-600">{{ filterForm.errors.region }}</p>
          </div>
          <!-- Produce Count Range -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Produce Count</label>
            <div class="mt-2 flex gap-3">
              <input
                v-model.number="filterForm.produce_min"
                type="number"
                placeholder="Min"
                min="0"
                class="block w-full rounded-md border-gray-300 h-12 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
                :class="{ 'border-red-500': filterForm.errors.produce_min }"
              />
              <input
                v-model.number="filterForm.produce_max"
                type="number"
                placeholder="Max"
                min="0"
                class="block w-full rounded-md border-gray-300 h-12 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
                :class="{ 'border-red-500': filterForm.errors.produce_max }"
              />
            </div>
            <p v-if="filterForm.errors.produce_min" class="mt-2 text-sm text-red-600">{{ filterForm.errors.produce_min }}</p>
            <p v-if="filterForm.errors.produce_max" class="mt-2 text-sm text-red-600">{{ filterForm.errors.produce_max }}</p>
          </div>
          <!-- Clear Filters Button -->
          <button
            type="button"
            @click="clearFilters"
            class="w-full h-12 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200 text-base font-semibold"
          >
            Clear Filters
          </button>
        </form>
      </div>

      <!-- Farmers Grid -->
      <div class="flex-1">
        <div v-if="farmers.data.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <Link
            v-for="farmer in farmers.data"
            :key="farmer.id"
            :href="`/markateplace/user/${farmer.id}`"
            class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group"
          >
            <div class="relative">
              <img
                :src="farmer.profile_picture ? `/storage/${farmer.profile_picture}` : '/images/default-profile-picture.jpg'"
                :alt="`${farmer.name}'s Profile Picture`"
                class="w-full h-64 object-cover rounded-t-3xl"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div class="absolute top-4 right-4 bg-indigo-600 text-white text-sm font-semibold px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-sm">
                {{ farmer.produce_count }} Produce
              </div>
              <div class="absolute bottom-6 left-6 text-white">
                <h3 class="text-2xl font-bold drop-shadow-md">{{ farmer.name }}</h3>
                <p class="text-base font-medium drop-shadow-md">{{ farmer.region || 'Unknown Region' }}</p>
              </div>
              <!-- Profile Picture Overlay -->
              <div
                class="absolute top-4 left-4 w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg opacity-100 group-hover:opacity-0 transition-opacity duration-300"
              >
                <img
                  :src="farmer.profile_picture ? `/storage/${farmer.profile_picture}` : '/images/default-profile-picture.jpg'"
                  :alt="`${farmer.name}'s Avatar`"
                  class="w-full h-full object-cover"
                />
              </div>
            </div>
            <div class="p-5 bg-gradient-to-r from-indigo-50 to-blue-50">
              <div class="flex items-center gap-3">
                <User class="h-6 w-6 text-indigo-600" />
                <span class="text-base font-semibold text-gray-900">Farmer</span>
              </div>
            </div>
          </Link>
        </div>
        <div v-else class="text-center text-gray-600 py-12">
          <p class="text-lg">No farmers found.</p>
        </div>

        <!-- Pagination Controls -->
        <div v-if="farmers.data.length" class="mt-8 flex justify-between items-center">
          <div class="text-sm text-gray-600">
            Showing {{ farmers.from }} to {{ farmers.to }} of {{ farmers.total }} farmers
          </div>
          <div class="flex space-x-2">
            <button
              @click="changePage(farmers.prev_page_url)"
              :disabled="!farmers.prev_page_url"
              class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 text-base"
            >
              Previous
            </button>
            <button
              @click="changePage(farmers.next_page_url)"
              :disabled="!farmers.next_page_url"
              class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 text-base"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
.rounded-2xl {
  border-radius: 1rem;
}
.rounded-3xl {
  border-radius: 1.5rem;
}
.shadow-lg {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.shadow-2xl {
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}
.transition-all {
  transition: all 0.3s ease;
}
.transition-opacity {
  transition: opacity 0.3s ease;
}
.transition-colors {
  transition: color 0.2s ease, background-color 0.2s ease;
}
.sticky {
  position: sticky;
  top: 1rem;
}
.bg-gradient-to-r {
  background: linear-gradient(to right, #e0e7ff, #f0f9ff);
}
.drop-shadow-md {
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5));
}
</style>