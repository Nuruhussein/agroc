<template>
  <Head title="My Orders" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 sm:px-6 lg:px-8 py-8">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
          <p class="mt-2 text-sm text-gray-600">View and manage your orders</p>
        </div>
      </div>

      <div class="mb-6 bg-white shadow rounded-lg p-4">
        <div class="sm:flex sm:items-center">
          <div class="w-full sm:max-w-xs">
            <label for="search" class="sr-only">Search orders</label>
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
                placeholder="Search by produce, seller, or status..."
                class="block w-full rounded-md border-gray-300 pl-10 pr-3 py-2 text-sm focus:border-green-500 focus:ring-green-500 sm:text-sm transition-all duration-200"
              />
              <button
                v-if="search"
                @click="search = ''"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
              >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">buyer</th>

                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produce</th> -->
                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th> -->
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery</th>
                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th> -->
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.order_number }}</td>
                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ order.buyer.name }}
                </td>
                <!-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <span v-if="order.items && order.items[0] && order.items[0].produce">
                    {{ order.items[0].produce.name }}
                  </span>
                  <span v-else>
                    N/A
                  </span>
                </td> -->
                <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span v-if="order.items && order.items[0]">
                    {{ order.items[0].quantity }}
                  </span>
                  <span v-else>
                    N/A
                  </span>
                </td> -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span
                    :class="{
                      'bg-green-100 text-green-800': order.status === 'completed',
                      'bg-yellow-100 text-yellow-800': order.status === 'pending',
                      'bg-red-100 text-red-800': order.status === 'canceled',
                    }"
                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                  >
                    {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                  </span>
                </td>
               <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
  <span
    :class="{
      'bg-green-100 text-green-800': order.delivered_quantity === order.total_quantity,
      'bg-yellow-100 text-yellow-800': order.delivered_quantity > 0 && order.delivered_quantity < order.total_quantity,
      'bg-gray-100 text-gray-800': order.delivered_quantity === 0,
    }"
    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
  >
    {{ order.delivered_quantity }} of {{ order.total_quantity }} delivered
  </span>
</td>

                <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span v-if="order.items && order.items[0] && order.items[0].produce && order.items[0].produce.user">
                    {{ order.items[0].produce.user.name }}
                  </span>
                  <span v-else>
                    N/A
                  </span>
                </td> -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${{ order.total_amount }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-3">
                    <Link
                      :href="route('orders.show', order.id)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      View
                    </Link>
                    <button
                      v-if="order.status === 'pending'"
                      @click="cancelOrder(order.id)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Cancel
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div v-if="!orders.length" class="text-center py-12 bg-white shadow rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
        <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
  orders: {
    type: Array,
    default: () => [],
  },
  filters: {
    type: Object,
    default: () => ({ search: '' }),
  },
});

const breadcrumbs = [
  { title: 'Orders', href: '/orders' },
];

// Reactive search query
const search = ref(props.filters.search || '');

// Debounced search function
const performSearch = debounce(() => {
  router.get(
    route('orders.index'),
    { search: search.value },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
      onSuccess: () => {
      },
      onError: (errors) => {
        console.error('Search request failed:', errors);
      },
    }
  );
}, 500);

// Watch for changes to the search input
watch(search, () => {
  performSearch();
});

// Watch for changes to props.filters.search to sync with backend
watch(
  () => props.filters.search,
  (newSearch) => {
    if (newSearch !== search.value) {
      search.value = newSearch || '';
    }
  }
);

// Function to handle order cancellation
const cancelOrder = (id) => {
  if (confirm('Are you sure you want to cancel this order?')) {
    router.delete(route('orders.destroy', id), {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        router.reload({ preserveState: true, preserveScroll: true }); // Refresh data
      },
      onError: (errors) => {
        console.error('Failed to cancel order:', errors);
      },
    });
  }
};

onMounted(() => {
  // Debug orders data
  console.log('Mounted with orders:', props.orders);
});
</script>