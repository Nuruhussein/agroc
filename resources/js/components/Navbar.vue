<template>
  <div>
    <!-- Navbar -->
    <nav
      :class="`bg-white/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 dark:bg-gray-900/80 max-w-screen-2xl mx-auto px-4 sticky top-0 z-50 transition-all duration-300 ${
        isScrolled ? 'py-2' : 'py-3'
      }`"
    >
      <div class="container px-6 mx-auto">
        <div class="flex items-center justify-between">
          <!-- Logo -->
          <div class="flex items-center flex-shrink-0">
            <Link href="/">
              <img
                :class="`h-10 transition-all duration-300 ${isScrolled ? 'h-8' : 'h-10'}`"
                src="https://marketplace.canva.com/EAGHc4fErhI/1/0/1600w/canva-green-and-white-organic-agriculture-logo-FN-ZChdNoIg.jpg"
                alt="Logo"
              />
            </Link>
          </div>

          <!-- Desktop Menu -->
          <div class="hidden lg:flex items-center space-x-8">
            <Link
              href="/#about-us"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              About us
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link>
            <Link
              href="/#services"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              Services
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link>
            <Link
              href="/markateplace"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              Marketplace
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link>
            <Link
              href="/#contact-us"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              Contact us
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link>
            <!-- <Link
              href="/#locations"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              Locations
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link> -->
            <Link
              href="/profiles"
              class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 px-1 py-2 font-medium transition-colors duration-200 relative group"
            >
              Profiles
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"
              ></span>
            </Link>

            <!-- Cart and User Section -->
            <div class="flex items-center space-x-4 ml-4">
              <!-- Cart Icon -->
              <Link
                href="/cart"
                class="relative text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100"
                aria-label="View cart"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                  />
                </svg>
                <span
                  v-if="cartCount"
                  class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                >
                  {{ cartCount }}
                </span>
              </Link>

              <!-- User Dropdown or Login Button -->
              <div>
                <div v-if="auth.user" class="relative">
                  <button
                    @click="isDropdownOpen = !isDropdownOpen"
                    class="flex items-center text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 transition-colors duration-200"
                  >
                    <img
                      :src="
                        auth.user.profile_picture
                          ? `/storage/${auth.user.profile_picture}`
                          : 'https://static.vecteezy.com/system/resources/thumbnails/020/765/399/small_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg'
                      "
                      :alt="`${auth.user.name}'s Profile Picture`"
                      class="h-8 w-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                    />
                    <svg
                      class="w-4 h-4 ml-1 transition-transform duration-200"
                      :class="{ 'rotate-180': isDropdownOpen }"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </button>
                  <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                  >
                    <div
                      v-if="isDropdownOpen"
                      class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700"
                    >
                      <Link
                        v-if="auth.user.role === 'admin' || auth.user.role === 'farmer' || auth.user.role === 'buyer'"
                        href="/dashboard"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700"
                      >
                        Dashboard
                      </Link>
                      <Link
                        href="/logout"
                        method="post"
                        as="button"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700"
                      >
                        Logout
                      </Link>
                    </div>
                  </transition>
                </div>
                <Link
                  v-else
                  href="/login"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                >
                  Login
                </Link>
              </div>
            </div>
          </div>

          <!-- Mobile Menu Button -->
          <div class="flex lg:hidden">
            <button
              @click="isOpen = !isOpen"
              type="button"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none"
              aria-label="Toggle menu"
            >
              <svg
                v-if="!isOpen"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
              <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95"
        >
          <div v-if="isOpen" class="lg:hidden mt-2 space-y-2 pb-3 sm:pb-0">
            <Link
              href="/#about-us"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              About us
            </Link>
            <Link
              href="/#services"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              Services
            </Link>
            <Link
              href="/markateplace"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              Marketplace
            </Link>
            <Link
              href="/#contact-us"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              Contact us
            </Link>
            <!-- <Link
              href="/#locations"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              Locations
            </Link> -->
            <Link
              href="/profiles"
              class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
            >
              Profiles
            </Link>

            <!-- Mobile Login/User Section -->
            <div v-if="auth.user" class="pt-4 pb-2 border-t border-gray-200 dark:border-gray-700">
              <div class="flex items-center px-4 space-x-3">
                <img
                  :src="
                    auth.user.profile_picture
                      ? `/storage/${auth.user.profile_picture}`
                      : 'https://static.vecteezy.com/system/resources/thumbnails/020/765/399/small_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg'
                  "
                  :alt="`${auth.user.name}'s Profile Picture`"
                  class="h-8 w-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                />
                <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                  {{ auth.user.name }}
                </div>
              </div>
              <div class="mt-2 space-y-1">
                <Link
                  v-if="auth.user.role === 'admin' || auth.user.role === 'farmer' || auth.user.role === 'buyer'"
                  href="/dashboard"
                  class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-700 rounded-md"
                >
                  Dashboard
                </Link>
                <Link
                  href="/logout"
                  method="post"
                  as="button"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                  Logout
                </Link>
              </div>
            </div>
            <Link
              v-else
              href="/login"
              class="block w-full px-4 py-2 mt-2 text-base font-medium text-center text-white bg-blue-600 rounded-md hover:bg-blue-700"
            >
              Login
            </Link>
          </div>
        </transition>
      </div>
    </nav>

    <!-- Fixed Cart Icon for Mobile -->
    <div class="lg:hidden fixed bottom-12 right-4 z-50">
      <Link
        href="/cart"
        class="relative bg-white dark:bg-gray-800 p-3 rounded-full shadow-lg hover:shadow-xl transition-shadow duration-200"
        aria-label="View cart"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-8 w-8 text-gray-600 dark:text-gray-300"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
          />
        </svg>
        <span
          v-if="cartCount"
          class="absolute bottom-14 -right-6 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
        >
          {{ cartCount }}
        </span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, inject, computed } from 'vue';

// Inject cart state
const cart = inject('cart');
const cartCount = computed(() => cart.cartCount.value); // Ensure reactivity

const isOpen = ref(false);
const isScrolled = ref(false);
const isDropdownOpen = ref(false);
const auth = usePage().props.auth;

const handleScroll = () => {
  isScrolled.value = window.scrollY > 10;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>