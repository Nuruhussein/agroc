<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
// Use Lucide icon instead of Heroicons
import { Eye } from 'lucide-vue-next';

const props = defineProps({
  orders: Array,
});

const { auth } = usePage().props;

// Map order status to Tailwind color classes for dynamic styling
const statusColors = {
  pending: 'text-yellow-600 bg-yellow-100',
  processing: 'text-blue-600 bg-blue-100',
  completed: 'text-green-600 bg-green-100',
  cancelled: 'text-red-600 bg-red-100',
};
</script>

<template>
  <Head title="Manage Orders" />

  <AppLayout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
      <h1 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">
        Manage Orders
      </h1>

      <!-- No Orders Message -->
      <div v-if="orders.length === 0" class="text-center py-12">
        <p class="text-lg text-gray-600">No orders found for your produce.</p>
      </div>

      <!-- Orders List -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white shadow-lg rounded-xl p-6 border border-gray-100 transform transition-all duration-300 hover:scale-105 hover:shadow-xl"
        >
          <div class="flex items-center space-x-4">
            <div
              class="p-3 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white"
            >
              <Eye class="h-6 w-6" />
            </div>
            <div class="flex-1">
              <h2 class="text-lg font-semibold text-gray-800">
                Order #{{ order.id }}
              </h2>
                <p
                class="mt-1 text-sm font-medium px-2 py-1 rounded-full inline-block"
                :class="statusColors[order.total_quantity === order.delivered_quantity ? 'delivered' : 'pending'] || 'text-gray-600 bg-gray-100'"
                >
                Status: {{ order.total_quantity === order.delivered_quantity ? 'Delivered' : 'Pending' }}
                </p>

              <p class="text-sm text-gray-600">Buyer: {{ order.buyer?.name || 'Unknown' }}</p>
              <p class="text-sm text-gray-600">Total Items: {{ order.total_quantity }}</p>
              <p class="text-sm text-gray-600">Delivered: {{ order.delivered_quantity }}</p>
            </div>
          </div>
          <!-- Action Button -->
          <div class="mt-4">
            <Link
              :href="`/farmer/orders/${order.id}`"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
            >
              <Eye class="h-5 w-5 mr-2" />
              View Order
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>