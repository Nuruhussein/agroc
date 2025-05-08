<template>
  <Head title="Order Details" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Order #{{ order.id }}</h1>
          <p class="mt-2 text-sm text-gray-500">View and manage your order details</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <Link
            :href="route('orders.index')"
            class="inline-flex items-center gap-x-1.5 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline  focus-visible:outline-offset-2 focus-visible:outline-gray-600 transition-colors duration-200"
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
            <div>
              <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-x-2">
                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M3 18h18M3 6h18" />
                </svg>
                Order Information
              </h2>
              <div class="space-y-4">
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h10a2 2 0 012 2v4a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zM7 11h10v8a2 2 0 01-2 2H7a2 2 0 01-2-2v-8zM4 15a3 3 0 003-3h10a3 3 0 003 3H4z" />
                    </svg>
                    Order ID
                  </dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.id }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Buyer
                  </dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.buyer.name }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status
                  </dt>
                  <dd class="mt-2">
                    <span
                      :class="{
                        'bg-green-100 text-green-800': order.status === 'completed',
                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                        'bg-red-100 text-red-800': order.status === 'canceled',
                      }"
                      class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
                    >
                      {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                    </span>
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    Delivery Status
                  </dt>
                  <dd class="mt-2">
                    <span
                      :class="{
                        'bg-green-100 text-green-800': order.delivery_status === 'delivered',
                        'bg-yellow-100 text-yellow-800': order.delivery_status === 'shipped',
                        'bg-gray-100 text-gray-800': order.delivery_status === 'pending',
                      }"
                      class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
                    >
                      {{ deliveryStatusLabel }}
                    </span>
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                    </svg>
                    Shipping Address
                  </dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.shipping_address }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                    </svg>
                    Billing Address
                  </dt>
                  <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.billing_address }}</dd>
                </div>
              </div>
            </div>

            <div>
              <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-x-2">
                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Items
              </h2>
              <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                <li v-for="item in order.items" :key="item.id" class="py-4 px-6">
                  <div class="flex items-center justify-between">
                    <div class="flex-1 flex items-center">
                      <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ item.produce.name }}</p>
                        <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
                        <p class="text-sm text-gray-500">Unit Price: ${{ item.unit_price }}</p>
                      </div>
                    </div>
                    <div class="ml-4">
                      <p class="text-sm font-semibold text-gray-900">Total: ${{ item.total_price }}</p>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="mt-4 flex justify-end">
                <p class="text-lg font-semibold text-gray-900">
                  Order Total: ${{ order.total_amount }}
                </p>
              </div>
            </div>
          </div>

          <div v-if="order.status === 'pending'" class="mt-10 flex justify-start">
            <button
              @click="cancelOrder(order.id)"
              class="inline-flex items-center gap-x-1.5 rounded-md bg-gradient-to-r from-red-600 to-red-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:from-red-700 hover:to-red-800  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all duration-200"
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

const breadcrumbs = [
  { title: 'Orders', href: '/orders' },
  { title: `Order #${props.order.id}`, href: '' },
];

// Computed property for formatted delivery status label
const deliveryStatusLabel = computed(() => {
  const status = props.order.delivery_status;
  return status.charAt(0).toUpperCase() + status.slice(1);
});

// Function to handle order cancellation
const cancelOrder = (id) => {
  if (confirm('Are you sure you want to cancel this order?')) {
    router.delete(route('orders.destroy', id), {
      preserveState: true,
      onSuccess: () => {
        router.visit(route('orders.index')); // Redirect to orders index
      },
      onError: (errors) => {
      },
    });
  }
};
</script>
<!-- Key Changes:Display Order Items: The template now iterates through order.items and displays the produce name, quantity, unit price, and total price for each item.Order Total: The template calculates and displays the order.total_amount.Breadcrumbs: The breadcrumbs now include the order ID.Delivery Status Label: Added  deliveryStatusLabel computed property to correctly format the delivery status.Layout: Improved the layout and styling for better readability.This updated component will display the order details, including the list of items in the order.  Make sure your Order model in Laravel correctly defines the relationship with OrderItem and Produce models. -->