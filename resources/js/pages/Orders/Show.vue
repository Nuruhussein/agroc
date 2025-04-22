<template>
    <Head title="Order Details" />
  
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
          <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Order #{{ order.id }}</h1>
            <p class="mt-2 text-sm text-gray-500">View and manage your order details</p>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <Link
              :href="route('orders.index')"
              class="inline-flex items-center gap-x-1.5 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline  focus-visible:outline-offset-2 focus-visible:outline-gray-600 transition-colors duration-200"
            >
              <svg class="-ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Back to Orders
            </Link>
          </div>
        </div>
  
        <!-- Order Details Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
          <div class="px-6 py-8 sm:p-10">
            <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-10 sm:gap-y-10">
              <!-- Produce Name -->
              <div>
                <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
                  </svg>
                  Produce
                </dt>
                <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.produce.name }}</dd>
              </div>
              <!-- Quantity -->
              <div>
                <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                  </svg>
                  Quantity
                </dt>
                <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.quantity }}</dd>
              </div>
              <!-- Status -->
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
                      'bg-green-100 text-green-800 hover:bg-green-200': order.status === 'completed',
                      'bg-yellow-100 text-yellow-800 hover:bg-yellow-200': order.status === 'pending',
                      'bg-red-100 text-red-800 hover:bg-red-200': order.status === 'canceled',
                    }"
                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium transition-colors duration-200"
                  >
                    {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                  </span>
                </dd>
              </div>
              <!-- Delivery Status -->
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
                      'bg-green-100 text-green-800 hover:bg-green-200': order.delivery_status === 'delivered',
                      'bg-yellow-100 text-yellow-800 hover:bg-yellow-200': order.delivery_status === 'shipped',
                      'bg-gray-100 text-gray-800 hover:bg-gray-200': order.delivery_status === 'pending',
                    }"
                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium transition-colors duration-200"
                  >
                    {{ deliveryStatusLabel }}
                  </span>
                </dd>
              </div>
              <!-- Seller -->
              <div>
                <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Seller
                </dt>
                <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.produce.user.name }}</dd>
              </div>
              <!-- Order ID -->
              <div>
                <dt class="text-sm font-medium text-gray-500 flex items-center gap-x-2">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10m0 0v10m0-10l-7 7" />
                  </svg>
                  Order ID
                </dt>
                <dd class="mt-2 text-lg font-semibold text-gray-900">{{ order.id }}</dd>
              </div>
            </div>
  
            <!-- Actions -->
            <div v-if="order.status === 'pending'" class="mt-10 flex justify-start">
              <button
                @click="cancelOrder(order.id)"
                class="inline-flex items-center gap-x-1.5 rounded-md bg-gradient-to-r from-red-600 to-red-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:from-red-700 hover:to-red-800  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all duration-200"
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
  import { Head, Link, router, usePage } from '@inertiajs/vue3';
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
          console.log('Order canceled:', id);
          router.visit(route('orders.index')); // Redirect to orders index
        },
        onError: (errors) => {
          console.error('Failed to cancel order:', errors);
        },
      });
    }
  };
  // Removed duplicate and invalid code
  </script>