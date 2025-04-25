<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
        validator: (product) => [
            'id',
            'name',
            'category',
            'farm_name',
            'description',
            'price',
            'image_path',
            'organic',
            'discount',
            'original_price'
        ].every(key => key in product)
    }
});

const emit = defineEmits(['place-order']);
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 h-full flex flex-col border border-gray-100 overflow-hidden group">
        <!-- Product Image -->
        <div class="relative aspect-square overflow-hidden">
            <img 
                :src="product.image_path" 
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex gap-2">
                <span 
                    v-if="product.organic"
                    class="px-2.5 py-1 text-xs font-semibold tracking-wide bg-emerald-500/90 text-white rounded-full flex items-center backdrop-blur-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Organic
                </span>
                <span 
                    v-if="product.discount > 0"
                    class="px-2.5 py-1 text-xs font-semibold tracking-wide bg-rose-500/90 text-white rounded-full backdrop-blur-sm"
                >
                    {{ product.discount }}% OFF
                </span>
            </div>
        </div>
        
        <!-- Product Content -->
        <div class="p-4 flex-grow flex flex-col">
            <!-- Category -->
            <span class="text-xs font-medium text-emerald-500 uppercase tracking-wider mb-1">
                {{ product.category?.name || product.category || 'N/A' }}
            </span>
            
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight">
                {{ product.name }}
            </h3>
            
            <!-- Farm Info -->
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-sm text-gray-500">{{ product.farm_name }}</span>
            </div>
            
            <!-- Description -->
            <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
                {{ product.description }}
            </p>
            
            <!-- Price and Action -->
            <div class="mt-auto flex items-center justify-between">
                <div class="flex items-baseline">
                    <span class="text-lg font-bold text-gray-900">
                        ${{ Number(product.price).toFixed(2) }}
                    </span>
                    <span 
                        v-if="product.original_price && product.original_price > product.price"
                        class="text-sm text-gray-400 line-through ml-2"
                    >
                        ${{ Number(product.original_price).toFixed(2) }}
                    </span>
                </div>
                
                <button 
        @click="emit('place-order', product)"
        class="flex items-center justify-center p-2 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors group-hover:bg-emerald-100"
        aria-label="Place order"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>


