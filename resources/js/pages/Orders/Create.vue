<template>
      <Head title="My Orders" />

<AppLayout :breadcrumbs="breadcrumbs">
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-lg w-full bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Place Your Order</h2>
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Produce Selection -->
          <div>
            <label for="produce_id" class="block text-sm font-medium text-gray-700">Select Produce</label>
            <div class="relative mt-1">
              <select
                id="produce_id"
                v-model="form.produce_id"
                class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg bg-gray-50 transition duration-150 ease-in-out"
                :class="{ 'border-red-300': form.errors.produce_id }"
              >
                <option disabled value="">Select a produce...</option>
                <option
                  v-for="item in produce"
                  :key="item.id"
                  :value="item.id"
                  :disabled="item.quantity <= 0"
                >
                  {{ item.name }} - ${{ Number(item.price).toFixed(2) }} ({{ item.quantity > 0 ? `${item.quantity} available` : 'Out of stock' }})
                </option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <p v-if="form.errors.produce_id" class="mt-2 text-sm text-red-600">{{ form.errors.produce_id }}</p>
          </div>
  
          <!-- Quantity Input -->
          <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <div class="relative mt-1">
              <input
                id="quantity"
                type="number"
                min="1"
                v-model.number="form.quantity"
                class="block w-full pl-3 pr-12 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg bg-gray-50 transition duration-150 ease-in-out"
                :class="{ 'border-red-300': form.errors.quantity }"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="text-gray-500 sm:text-sm">units</span>
              </div>
            </div>
            <p v-if="form.errors.quantity" class="mt-2 text-sm text-red-600">{{ form.errors.quantity }}</p>
          </div>
  
          <!-- Submit Button -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ form.processing ? 'Processing...' : 'Place Order' }}
            </button>
          </div>
        </form>
      </div>
    </div>
</AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/layouts/AppLayout.vue';
 
  import { Head,useForm } from '@inertiajs/vue3';
  import { defineProps } from 'vue';
  
  const props = defineProps({
    produce: Array,
  });
  
  const form = useForm({
    produce_id: '',
    quantity: 1,
  });
  
  const submit = () => {
    form.post(route('orders.store'), {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    });
  };
  </script>
  
  <style scoped>
  /* Custom scrollbar for select dropdown */
  select::-webkit-scrollbar {
    width: 8px;
  }
  
  select::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }
  
  select::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
  }
  
  select::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }
  </style>