<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce'; // Correct import

const breadcrumbs = [
  { title: 'Produce', href: '/produce' },
];

const props = defineProps({
  produce: {
    data: Array,
    links: Object,
    meta: Object,
  },
  filters: {
    search: String,
  },
});

console.log(props.produce.data);

const search = ref(props.filters.search || ''); // Ensure search is initialized correctly

// Debounced search function
const performSearch = debounce(() => {
  console.log('Performing search with:', search.value); // Debug log
  router.get(
    route('produce.index'),
    { search: search.value },
    {
      preserveState: true,
      replace: true,
      onSuccess: () => {
        console.log('Search request completed'); // Debug log
      },
      onError: (errors) => {
        console.error('Search request failed:', errors); // Debug log
      },
    }
  );
}, 500);

// Watch for changes to the search input
watch(search, () => {
  console.log('Search value changed:', search.value); // Debug log
  performSearch();
});

// Watch for changes to props.filters.search to keep search in sync
watch(
  () => props.filters.search,
  (newSearch) => {
    if (newSearch !== search.value) {
      search.value = newSearch || ''; // Sync with backend
      console.log('Synced search with backend:', search.value); // Debug log
    }
  }
);

// Function to handle delete
const deleteProduce = (id) => {
  if (confirm('Are you sure you want to delete this produce?')) {
    router.delete(route('produce.destroy', id), {
      preserveState: true,
      onSuccess: () => {
        console.log('Produce deleted:', id); // Debug log
      },
    });
  }
};
</script>

<template>
  <Head title="Produce" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 sm:px-6 lg:px-8 py-8">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-2xl font-bold text-gray-900">Produce Inventory</h1>
          <p class="mt-2 text-sm text-gray-600">Manage your farm's produce listings</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <Link
            :href="route('produce.create')"
            class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-green-600"
          >
            Add Produce
          </Link>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="mb-6 bg-white shadow rounded-lg p-4">
        <div class="sm:flex sm:items-center">
          <div class="w-full sm:max-w-xs">
            <label for="search" class="sr-only">Search</label>
            <div class="relative rounded-md shadow-sm">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
              </div>
              <input
                id="search"
                v-model="search"
                type="text"
                placeholder="Search by name or category..."
                class="block w-full rounded-md border-gray-300 pl-10 pr-3 py-2 focus:border-green-500 focus:ring-green-500 sm:text-sm"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Farmer</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="item in produce.data" :key="item.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                    {{ item.category.name }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ Number(item.price).toFixed(2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.quantity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.user.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-3">
                    <Link :href="route('produce.show', item.id)" class="text-blue-600 hover:text-blue-900">
                      View
                    </Link>
                    <Link :href="route('produce.edit', item.id)" class="text-yellow-600 hover:text-yellow-900">
                      Edit
                    </Link>
                    <button @click="deleteProduce(item.id)" class="text-red-600 hover:text-red-900">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ produce.from }}</span> to
                <span class="font-medium">{{ produce.to }}</span> of
                <span class="font-medium">{{ produce.total }}</span> results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <Link
                  v-for="(link, index) in produce.links" 
                  :key="index"
                  :href="link.url || '#'"
                  :class="{
                    'bg-green-50 border-green-500 text-green-600 z-10': link.active,
                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active && link.url,
                    'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed': !link.url,
                  }"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  preserve-state
                >
                  <span v-html="link.label"></span>
                </Link>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="!produce.data.length" class="text-center py-12 bg-white shadow rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No produce found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by adding a new produce item.</p>
        <div class="mt-6">
          <Link
            :href="route('produce.create')"
            class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-green-600"
          >
            Add Produce
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
