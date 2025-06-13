<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Profile Header -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-400 to-blue-500 h-32"></div>
        <div class="px-6 py-4 -mt-16 relative">
          <div class="flex items-center">
            <img 
              :src="user.profile_picture || 'https://ui-avatars.com/api/?name='+user.name+'&background=random'" 
              class="h-24 w-24 rounded-full border-4 border-white object-cover"
              alt="Profile"
            >
            <div class="ml-6">
              <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
              <p class="text-gray-600">{{ user.role }}</p>
              <p class="text-gray-600">{{ user.region }}</p>
              <div class="flex mt-2 space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                  {{ user.email }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                  {{ user.phone }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div v-for="stat in stats" :key="stat.label" class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <component :is="stat.icon" class="h-6 w-6 text-white" />
              </div>
              <div class="ml-5 w-0 flex-1">
                <dt class="text-sm font-medium text-gray-500 truncate">
                  {{ stat.label }}
                </dt>
                <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">
                    {{ stat.value }}
                  </div>
                </dd>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Produce -->
      <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Produce</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div v-for="item in recent_produce" :key="item.id" class="bg-white rounded-lg shadow overflow-hidden">
            <img :src="item.image_path || 'https://via.placeholder.com/300'" class="w-full h-48 object-cover" alt="Produce">
            <div class="p-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
              <p class="text-gray-600 mt-1">{{ item.description }}</p>
              <div class="mt-4 flex justify-between items-center">
                <span class="text-lg font-bold text-green-600">${{ item.price }}</span>
                <span v-if="item.original_price" class="text-sm line-through text-gray-500">${{ item.original_price }}</span>
                <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">{{ item.quantity }} {{ item.unit }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="recent_produce.length === 0" class="mt-8 text-center bg-white p-8 rounded-lg shadow">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">No produce listed yet</h3>
        <p class="mt-1 text-gray-500">Get started by adding your first produce item.</p>
        <div class="mt-6">
          <Link href="/produce/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <PlusIcon class="-ml-1 mr-2 h-5 w-5" />
            Add Produce
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { PlusIcon, ShoppingBagIcon, StarIcon, ChatAltIcon, CubeIcon } from '@heroicons/vue/outline'

const props = defineProps({
  user: Object,
  stats: Object,
  recent_produce: Array,
})

const stats = [
  { label: 'Total Produce', value: props.stats.produce_count, icon: CubeIcon },
  { label: 'Orders', value: props.stats.orders_count, icon: ShoppingBagIcon },
  { label: 'Avg Rating', value: props.stats.rating_avg.toFixed(1), icon: StarIcon },
  { label: 'Messages', value: props.stats.messages_count, icon: ChatAltIcon },
]
</script>

<style scoped>
/* Add any custom styles here */
</style>