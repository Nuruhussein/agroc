<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { debounce } from 'lodash-es';
import Navbar from '@/components/Navbar.vue';
import footerr from '@/components/home/footerr.vue';
import ProductCard from '@/components/ProductCard.vue';
import { Search, Filter } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
defineOptions({
  layout: MainLayout,
});
const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

// Initialize filters from props
const filters = ref({
    search: props.filters.search || '',
    category: props.filters.category || 'All',
    organic: props.filters.organic || false
});

// Loading state
const isLoading = ref(false);

// Debounced search (500ms)
const performSearch = debounce(() => {
    updateFilters();
}, 500);

// Watch for filter changes
watch([() => filters.value.category, () => filters.value.organic], () => {
    updateFilters();
});

const updateFilters = () => {
    isLoading.value = true;
    
    const params = {};
    if (filters.value.search.trim()) params.search = filters.value.search.trim();
    if (filters.value.category !== 'All') params.category = filters.value.category;
    if (filters.value.organic) params.organic = true;
    
    router.get(route('markateplace'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onFinish: () => {
            isLoading.value = false;
        }
    });
};

const resetFilters = () => {
    filters.value = {
        search: '',
        category: 'All',
        organic: false
    };
    updateFilters();
};

const placeOrder = (product) => {
    router.post(route('orders.store'), {
        produce_id: product.id,
        quantity: 1 // Default quantity of 1
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Show success notification
            // You can use a toast library or any other notification system
            alert('Order placed successfully!');
        },
        onError: (errors) => {
            // Show error notification
            alert('Failed to place order. Please try again.');
        }
    });
};
</script>

<template>
    <Head title="Marketplace" />
    <Navbar />

    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-emerald-600 to-emerald-500 py-16 md:py-20 overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-emerald-300 rounded-full mix-blend-overlay blur-3xl"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Farm Fresh Marketplace</h1>
                    <p class="text-lg md:text-xl text-emerald-100 max-w-3xl mx-auto">
                        Discover the freshest local produce directly from farmers in your community
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Filters Section -->
        <section class="sticky top-0 z-10 bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between gap-4 items-start md:items-center">
                    <!-- Category Filters -->
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm font-medium text-gray-500 mr-2">Categories:</span>
                        <button
                            v-for="category in categories"
                            :key="category"
                            @click="filters.category = category"
                            :class="[
                                'px-3 py-1.5 rounded-lg text-sm font-medium transition-all',
                                filters.category === category
                                    ? 'bg-emerald-600 text-white shadow-sm'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                            ]"
                            :disabled="isLoading"
                        >
                            {{ category }}
                        </button>
                    </div>
                    
                    <!-- Search and Organic Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <div class="relative flex-grow max-w-md">
                            <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" />
                            <input
                                type="text"
                                placeholder="Search products..."
                                v-model="filters.search"
                                @input="performSearch"
                                :disabled="isLoading"
                                class="pl-10 pr-4 py-2.5 w-full rounded-lg border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm disabled:opacity-75"
                            />
                        </div>
                        <button
                            @click="filters.organic = !filters.organic"
                            :class="[
                                'flex items-center px-4 py-2.5 rounded-lg border transition-all text-sm',
                                filters.organic
                                    ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                    : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'
                            ]"
                            :disabled="isLoading"
                        >
                            <Filter class="mr-2 h-4 w-4" />
                            <span>Organic Only</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Product Grid -->
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="isLoading" class="text-center py-12">
                    <div class="inline-flex items-center px-4 py-2 text-emerald-600">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading products...
                    </div>
                </div>

                <template v-else>
                    <div v-if="products.data.length > 0">
                        <p class="text-sm text-gray-500 mb-6">
                            Showing {{ products.data.length }} {{ products.data.length === 1 ? 'product' : 'products' }}
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <ProductCard
        v-for="product in products.data"
        :key="product.id"
        :product="product"
        class="transition-transform hover:scale-[1.02]"
        @place-order="placeOrder"
    />
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8 flex justify-center">
                            <nav class="flex items-center gap-1">
                                <Link
                                    v-for="(link, index) in products.links"
                                    :key="index"
                                    :href="link.url || '#'"
                                    :class="[
                                        'px-3 py-1 rounded-md text-sm font-medium',
                                        link.active
                                            ? 'bg-emerald-600 text-white'
                                            : 'text-gray-700 hover:bg-gray-100',
                                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                    ]"
                                    v-html="link.label"
                                    preserve-state
                                />
                            </nav>
                        </div>
                    </div>
                    
                    <!-- Empty State -->
                    <div v-else class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto mb-6 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-6">Try adjusting your filters or search for something different</p>
                            <button
                                @click="resetFilters"
                                class="px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium"
                            >
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </main>
    </div>
    <footerr />
</template>