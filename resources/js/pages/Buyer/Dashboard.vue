<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Package, PackageCheck, Clock, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
  totalOrders: Number,
  deliveredItems: Number,
  pendingOrders: Number,
});
</script>

<template>
  <Head title="Buyer Dashboard" />

  <AppLayout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Buyer Dashboard</h1>
        <p class="text-gray-500 mt-2">Overview of your orders and deliveries</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Orders Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-blue-800">Total Orders</h2>
              <p class="mt-2 text-4xl font-bold text-blue-900">{{ totalOrders }}</p>
            </div>
            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
              <Package :size="28" />
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
            <span>View all orders</span>
            <ArrowRight :size="16" class="ml-1" />
          </div>
        </div>

        <!-- Delivered Items Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-green-800">Delivered Items</h2>
              <p class="mt-2 text-4xl font-bold text-green-900">{{ deliveredItems }}</p>
            </div>
            <div class="p-3 rounded-lg bg-green-100 text-green-600">
              <PackageCheck :size="28" />
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm text-green-600 font-medium">
            <span>Track deliveries</span>
            <ArrowRight :size="16" class="ml-1" />
          </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-amber-800">Pending Orders</h2>
              <p class="mt-2 text-4xl font-bold text-amber-900">{{ pendingOrders }}</p>
            </div>
            <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
              <Clock :size="28" />
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm text-amber-600 font-medium">
            <span>Check status</span>
            <ArrowRight :size="16" class="ml-1" />
          </div>
        </div>
      </div>

      <!-- Additional Content Section -->
      <!-- <div class="mt-12 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
        <div class="text-gray-500">
          <p>Your dashboard will show recent order activity here.</p> -->
          <!-- You can add actual recent activity components here -->
        <!-- </div> -->
      
      <!-- </div> -->
    </div>
  </AppLayout>
</template>