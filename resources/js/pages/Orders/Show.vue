<template>
  <Head title="Order Details" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Order #{{ order?.id }}</h1>
          <p class="mt-2 text-sm text-gray-500">View and manage your order details</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <Link
            :href="route('orders.index')"
            class="inline-flex items-center gap-x-1.5 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-gray-600 transition-colors duration-200"
          >
            <svg class="-ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Orders
          </Link>
        </div>
      </div>

      <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-8 sm:p-10">
          <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-10 sm:gap-y-10">
            <!-- Left Column -->
            <div>
              <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-x-2">
                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M3 18h18M3 6h18" />
                </svg>
                Order Information
              </h2>
              <div class="space-y-4">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Order ID</dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order?.id }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Buyer</dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order?.buyer?.name || 'N/A' }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Status</dt>
                  <dd class="mt-2">
                    <span
                      :class="{
                        'bg-green-100 text-green-800': order?.status === 'completed',
                        'bg-yellow-100 text-yellow-800': order?.status === 'pending',
                        'bg-red-100 text-red-800': order?.status === 'canceled',
                      }"
                      class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
                    >
                      {{ statusLabel }}
                    </span>
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Delivery Status</dt>
                  <dd class="mt-2">
                 <span
  :class="{
    'bg-green-100 text-green-800': order?.delivered_quantity === order?.total_quantity,
    'bg-yellow-100 text-yellow-800': order?.delivered_quantity > 0 && order?.delivered_quantity < order?.total_quantity,
    'bg-gray-100 text-gray-800': order?.delivered_quantity === 0,
  }"
  class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
>
  {{ deliveredSummary }}
</span>

                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
                  <dd class="mt-2 text-lg text-gray-900">{{ order?.shipping_address || 'N/A' }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Billing Address</dt>
                  <dd class="mt-2 text-lg text-gray-900">{{ order?.billing_address || 'N/A' }}</dd>
                </div>
              </div>
            </div>

            <!-- Right Column - Items -->
            <div>
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Items</h2>
              <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                <li
                  v-for="item in order?.items || []"
                  :key="item.id"
                  class="py-4 px-6"
                >
                  <div class="flex justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-900">{{ item.produce?.name || 'Unknown Produce' }}</p>
                      <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
                      <p class="text-sm text-gray-500">Unit Price: ${{ item.unit_price }}</p>
                      <p class="text-sm text-gray-500">Seller: {{ item.produce?.user?.name || 'N/A' }}</p>
                  <p
  class="text-sm font-medium px-2 py-1 rounded inline-block"
  :class="{
    'bg-green-100 text-green-800': item.delivery_status === 'delivered',
    'bg-yellow-100 text-yellow-800': item.delivery_status === 'shipped',
    'bg-gray-100 text-gray-800': item.delivery_status === 'pending' || !item.delivery_status,
    'bg-red-100 text-red-800': item.delivery_status === 'failed',
  }"
>
  Delivery: {{ item.delivery_status ? item.delivery_status.charAt(0).toUpperCase() + item.delivery_status.slice(1) : 'Pending' }}
</p>


                    </div>
                    <p class="text-sm font-semibold text-gray-900">Total: ${{ item.total_price }}</p>
                  </div>
                </li>
              </ul>
              <div class="mt-4 flex justify-end">
                <p class="text-lg font-semibold text-gray-900">Order Total: ${{ order?.total_amount }}</p>
              </div>
            </div>
          </div>

          <div v-if="order?.status === 'pending'" class="mt-10 flex justify-start">
            <button
              @click="cancelOrder(order.id)"
              class="inline-flex items-center gap-x-1.5 rounded-md bg-gradient-to-r from-red-600 to-red-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:from-red-700 hover:to-red-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all duration-200"
            >
              <svg class="-ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Cancel Order
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  order: Object,
});

// Breadcrumbs
const breadcrumbs = [
  { title: 'Orders', href: '/orders' },
  { title: `Order #${props.order?.id || ''}`, href: '' },
];

// Computed Labels
const statusLabel = computed(() => {
  const status = props.order?.status || '';
  return status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Unknown';
});

// const deliveryStatusLabel = computed(() => {
//   const status = props.order?.delivery_status || '';
//   return status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Unknown';
// });
const deliveredSummary = computed(() => {
  const items = props.order?.items || [];

  const total = items.length;
  const delivered = items.filter(i => i.delivery_status === 'delivered').length;

  return `${delivered} of ${total} delivered`;
});

// Cancel function
const cancelOrder = (id) => {
  if (confirm('Are you sure you want to cancel this order?')) {
    router.delete(route('orders.destroy', id), {
      preserveState: true,
      onSuccess: () => router.visit(route('orders.index')),
    });
  }
};
</script>

<!-- Key Changes:Display Order Items: The template now iterates through order.items and displays the produce name, quantity, unit price, and total price for each item.Order Total: The template calculates and displays the order.total_amount.Breadcrumbs: The breadcrumbs now include the order ID.Delivery Status Label: Added  deliveryStatusLabel computed property to correctly format the delivery status.Layout: Improved the layout and styling for better readability.This updated component will display the order details, including the list of items in the order.  Make sure your Order model in Laravel correctly defines the relationship with OrderItem and Produce models. -->