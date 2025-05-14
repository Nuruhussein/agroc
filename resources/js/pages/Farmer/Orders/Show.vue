<script setup>
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { TruckIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';
import { ref, computed } from 'vue';

console.log('Component mounted'); // Debug component load

// Props from the controller
const props = defineProps({
  order: Object,
  items: Array,
  flash: Object,
  errors: Object,
});

// Reactive status for each item
const itemStatuses = ref(
  props.items.map((item) => ({
    id: item.id,
    delivery_status: item.delivery_status,
  }))
);

// Track errors for each item
const itemErrors = ref({});

// Map delivery status to Tailwind color classes
const statusColors = {
  pending: 'text-yellow-600 bg-yellow-100',
  shipped: 'text-blue-600 bg-blue-100',
  delivered: 'text-green-600 bg-green-100',
};

// Capitalize function
const capitalize = (str) => {
  if (!str) return '';
  return str.charAt(0).toUpperCase() + str.slice(1);
};

// Update delivery status
const updateStatus = (itemId, selectedStatus, index) => {
  console.log('updateStatus called', { itemId, selectedStatus, index });

  if (!selectedStatus) {
    console.log('No status selected');
    itemErrors.value[itemId] = 'Please select a status.';
    return;
  }

  const originalStatus = props.items[index].delivery_status;
  itemErrors.value[itemId] = null;

  console.log('Sending POST request', { itemId, delivery_status: selectedStatus });

  router.post(
    `/farmer/orders/${props.order.id}/items/${itemId}/status`, // Assumes /farmer prefix
    { delivery_status: selectedStatus },
    {
      preserveState: true,
      preserveScroll: true,
      onError: (errors) => {
        console.error('Request failed', errors);
        itemStatuses.value[index].delivery_status = originalStatus;
        itemErrors.value[itemId] = errors.delivery_status || 'Failed to update status.';
      },
      onSuccess: () => {
        console.log('Request succeeded');
        itemErrors.value[itemId] = null;
      },
      onFinish: () => {
        console.log('Request finished');
      },
    }
  );
};

// Display flash message
const flashMessage = computed(() => props.flash?.success || null);

// Combine server and client errors
const getError = (itemId) => itemErrors.value[itemId] || props.errors?.delivery_status;
</script>

<template>
  <Head :title="`Order #${order.id} Details`" />

  <AppLayout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
      <!-- Flash Message -->
      <div
        v-if="flashMessage"
        class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg"
      >
        {{ flashMessage }}
      </div>

      <!-- Order Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
          Order #{{ order.id }} Details
        </h1>
        <div class="mt-4 bg-white shadow-lg rounded-xl p-6 border border-gray-100">
          <div class="flex items-center space-x-4">
            <div
              class="p-3 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white"
            >
              <TruckIcon class="h-6 w-6" />
            </div>
            <div>
              <p class="text-lg font-semibold text-gray-700">
                Status:
                <span
                  :class="statusColors[order.status]"
                  class="px-2 py-1 rounded-full text-sm"
                >
                  {{ capitalize(order.status) }}
                </span>
              </p>
              <p class="text-gray-600">Buyer: {{ order.buyer?.name || 'Unknown' }}</p>
              <p class="text-gray-600">Total Amount: ${{ order.total_amount }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Items -->
      <div class="grid grid-cols-1 gap-6">
        <div
          v-for="(item, index) in items"
          :key="item.id"
          class="bg-white shadow-lg rounded-xl p-6 border border-gray-100"
        >
          <div class="flex items-center space-x-4">
            <div
              class="p-3 rounded-full bg-gradient-to-br from-green-500 to-green-600 text-white"
            >
              <CheckCircleIcon class="h-6 w-6" />
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800">
                {{ item.produce.name }}
              </h3>
              <p class="text-gray-600">Quantity: {{ item.quantity }}</p>
              <p class="text-gray-600">Unit Price: ${{ item.unit_price }}</p>
              <p class="text-gray-600">Total Price: ${{ item.total_price }}</p>
              <p class="text-gray-600">
                Delivery Status:
                <span
                  :class="statusColors[item.delivery_status]"
                  class="px-2 py-1 rounded-full text-sm"
                >
                
                      {{ item.delivery_status }}
                </span>
              </p>
              <!-- Error Message -->
              <p v-if="getError(item.id)" class="text-red-600 text-sm mt-2">
                {{ getError(item.id) }}
              </p>
            </div>
          </div>

          <!-- Update Delivery Status Form -->
          <form
            @submit.prevent="console.log('Form submitted', item.id); updateStatus(item.id, itemStatuses[index].delivery_status, index)"
            class="mt-4 flex items-center space-x-2"
          >
            <label for="status" class="text-sm font-medium text-gray-700 sr-only">
              Delivery Status
            </label>
            <select
              v-model="itemStatuses[index].delivery_status"
              class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="" disabled>Select Status</option>
              <option value="pending">Pending</option>
              <option value="shipped">Shipped</option>
              <option value="delivered">Delivered</option>
            </select>
            <button
              type="submit"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
            >
              <TruckIcon class="h-5 w-5 mr-2" />
              Update
            </button>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>