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
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
          <Link
            :href="'/admin/users'"
            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-200"
          >
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to users
          </Link>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header with Profile Picture -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
          <div class="flex items-center gap-6">
            <img
              :src="user.profile_picture ? `/storage/${user.profile_picture}` : '/images/default-profile-picture.jpg'"
              alt="Profile Picture"
              class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md"
            />
            <div>
              <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <User class="h-6 w-6 text-indigo-600" />
                {{ user.name || 'Unnamed User' }}
              </h3>
              <p class="mt-1 text-sm text-gray-500">User details and related information</p>
            </div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="px-8 py-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-6">
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <User class="h-6 w-6" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Name</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900">{{ user.name || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <Mail class="h-6 w-6" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Email</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900">{{ user.email || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <Phone class="h-6 w-6" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Phone</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900">{{ user.phone || 'N/A' }}</p>
                </div>
              </div>
            </div>
            <!-- Right Column -->
            <div class="space-y-6">
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <MapPin class="h-6 w-6" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Region</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900">{{ user.region || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <User class="h-6 w-6" />
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Role</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900 capitalize">{{ user.role || 'N/A' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 bg-indigo-50/50 rounded-xl transition-shadow hover:shadow-sm">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                  <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-sm font-medium text-gray-600">Created At</h4>
                  <p class="mt-1 text-base font-semibold text-gray-900">
                    {{ new Date(user.created_at).toLocaleDateString() }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Related Data (Uncomment if needed) -->
          <!-- <div class="mt-8">
            <div class="border-t border-gray-200 pt-6">
              <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-4">
                <Package class="h-6 w-6 text-indigo-600" />
                Produce
              </h4>
              <div v-if="user.produce && user.produce.length" class="space-y-4">
                <div v-for="produce in user.produce" :key="produce.id" class="p-4 bg-indigo-50/50 rounded-xl">
                  <p class="text-sm font-medium text-gray-900">{{ produce.name }}</p>
                  <p class="text-sm text-gray-600">Category: {{ produce.category?.name || 'N/A' }}</p>
                  <p class="text-sm text-gray-600">Price: ${{ Number(produce.price).toFixed(2) }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-gray-600">No produce available.</p>
            </div>
            <div class="border-t border-gray-200 pt-6">
              <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-4">
                <ShoppingCart class="h-6 w-6 text-indigo-600" />
                Orders
              </h4>
              <div v-if="user.orders && user.orders.length" class="space-y-4">
                <div v-for="order in user.orders" :key="order.id" class="p-4 bg-indigo-50/50 rounded-xl">
                  <p class="text-sm font-medium text-gray-900">Order #{{ order.id }}</p>
                  <p class="text-sm text-gray-600">Total: ${{ Number(order.total).toFixed(2) }}</p>
                  <p class="text-sm text-gray-600">Date: {{ new Date(order.created_at).toLocaleDateString() }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-gray-600">No orders available.</p>
            </div>
          </div> -->
        </div>

        <!-- Footer -->
        <div class="px-8 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
          <Link
            :href="'/admin/users'"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors duration-200"
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
  background: linear-gradient(to right, #e0e7ff, #f0f9ff);
  transition: background 0.3s ease;
}
.rounded-xl {
  border-radius: 1rem;
}
.shadow-lg {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.transition-shadow {
  transition: box-shadow 0.2s ease;
}
.transition-colors {
  transition: color 0.2s ease, background-color 0.2s ease;
}
</style>