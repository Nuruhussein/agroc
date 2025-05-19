<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { User, Mail, Phone, MapPin, Package, ShoppingCart } from 'lucide-vue-next';

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const breadcrumbs = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Users', href: '/admin/users' },
  { title: 'View User', href: '' },
];

console.log('User data:', props.user); // Debug log
</script>

<template>
  <Head :title="user.name || 'User Details'" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
          <Link
            :href="'/admin/users'"
            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-4"
          >
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to users
          </Link>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ user.name || 'Unnamed User' }}</h1>
          <p class="mt-2 text-sm text-gray-500">User details and related information</p>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
          <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <User class="h-5 w-5 text-blue-500" />
            User Information
          </h3>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <User class="h-5 w-5" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Name</h4>
                  <p class="mt-1 text-base font-medium text-gray-900">{{ user.name || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <Mail class="h-5 w-5" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Email</h4>
                  <p class="mt-1 text-base font-medium text-gray-900">{{ user.email || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <Phone class="h-5 w-5" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                  <p class="mt-1 text-base font-medium text-gray-900">{{ user.phone || 'N/A' }}</p>
                </div>
              </div>
            </div>
            <!-- Right Column -->
            <div class="space-y-6">
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <MapPin class="h-5 w-5" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Region</h4>
                  <p class="mt-1 text-base font-medium text-gray-900">{{ user.region || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <User class="h-5 w-5" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Role</h4>
                  <p class="mt-1 text-base font-medium text-gray-900 capitalize">{{ user.role || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                  <p class="mt-1 text-base font-medium text-gray-900">
                    {{ new Date(user.created_at).toLocaleDateString() }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Related Data -->
          <!-- <div class="mt-6">
            <div class="border-t border-gray-200 pt-6">
              <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-4">
                <Package class="h-5 w-5 text-blue-500" />
                Produce
              </h4>
              <div v-if="user.produce && user.produce.length" class="space-y-4">
                <div v-for="produce in user.produce" :key="produce.id" class="p-4 bg-gray-50 rounded-lg">
                  <p class="text-sm font-medium text-gray-900">{{ produce.name }}</p>
                  <p class="text-sm text-gray-500">Category: {{ produce.category?.name || 'N/A' }}</p>
                  <p class="text-sm text-gray-500">Price: ${{ Number(produce.price).toFixed(2) }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-gray-500">No produce available.</p>
            </div>
            <div class="border-t border-gray-200 pt-6">
              <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-4">
                <ShoppingCart class="h-5 w-5 text-blue-500" />
                Orders
              </h4>
              <div v-if="user.orders && user.orders.length" class="space-y-4">
                <div v-for="order in user.orders" :key="order.id" class="p-4 bg-gray-50 rounded-lg">
                  <p class="text-sm font-medium text-gray-900">Order #{{ order.id }}</p>
                  <p class="text-sm text-gray-500">Total: ${{ Number(order.total).toFixed(2) }}</p>
                  <p class="text-sm text-gray-500">Date: {{ new Date(order.created_at).toLocaleDateString() }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-gray-500">No orders available.</p>
            </div>
          </div> -->
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
          <Link
            :href="'/admin/users'"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
          >
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to all users
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.bg-gradient-to-r {
  transition: background 0.3s ease;
}
</style>