<template>
  <Navbar />
  <div class="bg-white min-h-screen">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">Your Cart</h2>
      
      <div v-if="cartItems.length" class="mt-8">
        <div v-for="item in cartItems" :key="item.produce_id" class="flex items-center py-4 border-b">
          <img :src="item.imageSrc" :alt="item.imageAlt || item.name" class="w-24 h-24 object-cover rounded-full" />
          <div class="ml-4 flex-1">
            <h3 class="text-lg font-medium text-gray-900">{{ item.name }}</h3>
            <div class="flex items-center space-x-2 mt-2">
              <button
                @click="updateQuantity(item, -1)"
                :disabled="isUpdating[item.produce_id] || item.quantity <= 1"
                class="px-2 py-1 text-sm bg-gray-200 rounded"
              >
                -
              </button>
              <span class="text-sm text-gray-500">{{ item.quantity }}</span>
              <button
                @click="updateQuantity(item, 1)"
                :disabled="isUpdating[item.produce_id]"
                class="px-2 py-1 text-sm bg-gray-200 rounded"
              >
                +
              </button>
            </div>
            <p class="text-sm font-medium text-gray-900 mt-2">
              ${{ (item.price * item.quantity) }}
            </p>
          </div>
        </div>

        <div class="mt-8 border-t pt-6">
          <div class="flex justify-between mb-4">
            <span class="text-lg font-medium">Subtotal</span>
            <span class="text-lg font-medium">${{ cartTotal.toFixed(2) }}</span>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium mb-4">Shipping Information</h3>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Shipping Address</label>
                <input v-model="shippingAddress" type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Billing Address</label>
                <input v-model="billingAddress" type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
              </div>
            </div>
          </div>

          <button
            @click="placeOrder"
            :disabled="isPlacingOrder || !cartItems.length"
            class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-md font-medium transition-colors"
          >
            {{ isPlacingOrder ? 'Placing Order...' : 'Place Order' }}
          </button>
        </div>
      </div>
      <div v-else class="mt-8 text-center">
      <p class="text-gray-500">Your cart is empty.</p>
      <Link
        href="/markateplace"  
        class="mt-4 inline-block text-green-600 hover:text-green-800 font-medium"
      >
        Continue Shopping
      </Link>
    </div>
    </div>
  </div>
  <Footerr />
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
defineOptions({
  layout: MainLayout
});


import Footerr from '@/components/home/footer.vue';

const props = defineProps({
  cartItems: {
    type: Array,
    default: () => []
  }
});

const shippingAddress = ref('');
const billingAddress = ref('');
const isPlacingOrder = ref(false);
const isUpdating = ref({});

const cartTotal = computed(() => {
  return props.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
});

const updateQuantity = async (item, change) => {
  isUpdating.value[item.produce_id] = true;
  
  try {
    await router.post(route('cart.update'), {
      produce_id: item.produce_id,
      change
    }, {
      preserveScroll: true
    });
  } finally {
    isUpdating.value[item.produce_id] = false;
  }
};

const placeOrder = async () => {
  if (!shippingAddress.value || !billingAddress.value) {
    alert('Please fill in all address fields');
    return;
  }

  isPlacingOrder.value = true;
  const orderData = {
    items: props.cartItems.map(item => ({
      produce_id: item.produce_id,
      quantity: item.quantity,
      // price: item.price // You might want to send price for backend validation/recording
    })),
    shipping_address: shippingAddress.value,
    billing_address: billingAddress.value,
    clear_cart: true // This flag can be used by the backend
  };

  // Log the data here
  console.log('Data being sent to orders.store:', JSON.parse(JSON.stringify(orderData))); // Using JSON.parse(JSON.stringify()) for a deep copy log of plain objects
  try {
    // Assuming 'orders.store' is a named route.
    // If not, use the direct URL string, e.g., '/orders'
    await router.post(route('orders.store'), orderData, { // Or use '/orders' directly
      onSuccess: () => {
        // This callback is for when Inertia receives a successful response (e.g., 2xx, 3xx redirect)
        // Often, the backend will redirect to an order success page or back to the cart (which would be empty).
        // If your backend sends back new props (e.g. an empty cart), Inertia handles that.
        // You might clear form fields here if not navigating away:
        // shippingAddress.value = '';
        // billingAddress.value = '';
        alert('Order placed successfully!'); // Or use a more sophisticated notification
        Window.location.href = '/markateplace'; // Redirect to marketplace or order confirmation page

      },
      onError: (errors) => {
        console.error('Order placement failed with validation errors:', errors);
        // Handle validation errors (e.g., display them to the user)
        // `errors` will contain the validation errors object from Laravel if it's a 422 response
        let errorMessages = "Failed to place order. Please check the following:\n";
        for (const field in errors) {
            errorMessages += `${field}: ${errors[field]}\n`;
        }
        alert(errorMessages);
      }
    });
  } catch (error) {
    // This catch block is for network errors or exceptions not handled by Inertia's onError.
    // Inertia's router.post itself usually doesn't throw for HTTP errors like 4xx/5xx,
    // those are handled by onError. This catch is more for programming errors or network failures.
    console.error('Network or other error during order placement:', error);
    alert('An unexpected error occurred while placing your order. Please try again.');
  } finally {
    isPlacingOrder.value = false;
  }
};
</script>