<template>
  <Head title="Add Produce" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-2xl font-bold text-gray-900">Add New Produce</h1>
          <p class="mt-2 text-sm text-gray-600">Fill in the details of your farm produce</p>
        </div>
      </div>

      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 sm:p-8">
          <form @submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Name Field -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  placeholder="Organic Tomatoes"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.name }"
                  required
                />
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
              </div>

              <!-- Category Field -->
              <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select
                  id="category"
                  v-model="form.category"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.category }"
                  required
                >
                  <option value="" disabled selected>Select category</option>
                  <option value="Vegetables">Vegetables</option>
                  <option value="Fruits">Fruits</option>
                  <option value="Grains">Grains</option>
                  <option value="Dairy">Dairy</option>
                  <option value="Meat">Meat</option>
                </select>
                <p v-if="form.errors.category" class="mt-2 text-sm text-red-600">{{ form.errors.category }}</p>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Price Field -->
              <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                <div class="relative rounded-md shadow-sm">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">$</span>
                  </div>
                  <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                    :class="{ 'border-red-500': form.errors.price }"
                    required
                  />
                </div>
                <p v-if="form.errors.price" class="mt-2 text-sm text-red-600">{{ form.errors.price }}</p>
              </div>

              <!-- Quantity Field -->
              <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input
                  id="quantity"
                  v-model="form.quantity"
                  type="number"
                  min="1"
                  placeholder="e.g., 100"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.quantity }"
                  required
                />
                <p v-if="form.errors.quantity" class="mt-2 text-sm text-red-600">{{ form.errors.quantity }}</p>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-x-4 pt-6 border-t border-gray-200">
              <a
                :href="route('produce.index')"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                Cancel
              </a>
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                :disabled="form.processing"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
              >
                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ form.processing ? 'Saving...' : 'Save Produce' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Produce', href: '/produce' },
  { title: 'Add Produce', href: '' },
];

const form = useForm({
  name: '',
  category: '',
  price: '',
  quantity: '',
});

const submit = () => {
  form.transform((data) => ({
    ...data,
    price: data.price ? parseFloat(data.price) : null,
    quantity: data.quantity ? parseInt(data.quantity, 10) : null,
  })).post(route('produce.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};
</script>