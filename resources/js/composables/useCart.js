// src/composables/useCart.js
import { ref, computed, inject } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export function useCart() {
  // Access Inertia props
  const { props } = usePage();
  const user = computed(() => props.auth?.user);
  const initialCartItems = props.cartItems || [];
  const initialCartCount = props.cartCount || 0;

  // Cart state
  const cartItems = ref(initialCartItems);
  const cartCount = ref(initialCartCount);
  const isAdding = ref({}); // Track adding state per product
  const addedProductId = ref(null);

  // Computed cart count for reactivity
  const computedCartCount = computed(() => cartItems.value.length);

  // Add to cart method
  const addToCart = (product) => {
    if (!user.value) {
      router.visit(route('login'));
      return;
    }

    isAdding.value[product.id] = true;

    router.post(
      route('cart.store'),
      {
        produce_id: product.id,
        quantity: 1,
      },
      {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
          // Update cart state with new item
          const newItem = {
            id: Date.now(), // Temporary ID until backend sync
            produce_id: product.id,
            name: product.name,
            price: product.price,
            quantity: 1,
            imageSrc: product.imageSrc,
            imageAlt: product.imageAlt,
          };
          cartItems.value.push(newItem);
          cartCount.value++;

          // Show success indicator
          addedProductId.value = product.id;
          setTimeout(() => {
            addedProductId.value = null;
          }, 1000);

          console.log('Cart updated:', cartItems.value);
        },
        onError: (errors) => {
          console.error('Failed to add to cart:', errors);
        },
        onFinish: () => {
          isAdding.value[product.id] = false;
        },
      }
    );
  };

  return {
    cartItems,
    cartCount: computedCartCount,
    isAdding,
    addedProductId,
    addToCart,
  };
}