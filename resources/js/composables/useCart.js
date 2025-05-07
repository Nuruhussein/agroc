// src/composables/useCart.js
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export function useCart() {
  const { props } = usePage();
  const user = computed(() => props.auth?.user);
  const cartItems = ref(props.cartItems || []);
  const cartCount = computed(() => cartItems.value.length);
  const isAdding = ref({});
  const isUpdating = ref({});

  const addToCart = (item) => {
    if (!user.value) {
      router.visit(route('login'));
      return;
    }

    isAdding.value[item.id] = true;

    router.post(
      route('cart.store'),
      { produce_id: item.id, quantity: 1 },
      {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
          cartItems.value = page.props.cartItems || cartItems.value;
        },
        onError: (errors) => console.error('Failed to add to cart:', errors),
        onFinish: () => {
          isAdding.value[item.id] = false;
        },
      }
    );
  };

  const updateQuantity = (item, change) => {
    if (!user.value) {
      router.visit(route('login'));
      return;
    }

    isUpdating.value[item.produce_id] = true;

    router.post(
      route('cart.update'),
      { produce_id: item.produce_id, change },
      {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
          cartItems.value = page.props.cartItems || cartItems.value;
        },
        onError: (errors) => console.error('Failed to update quantity:', errors),
        onFinish: () => {
          isUpdating.value[item.produce_id] = false;
        },
      }
    );
  };

  return {
    cartItems,
    cartCount,
    isAdding,
    isUpdating,
    addToCart,
    updateQuantity,
  };
}