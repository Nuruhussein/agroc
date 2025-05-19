<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
  Pencil, 
  ArrowLeft,
  Leaf,
  Tag,
  DollarSign,
  Percent,
  Package,
  MapPin,
  FileText,
  Image as ImageIcon,
  User
} from 'lucide-vue-next';

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Produce', href: '/produce' },
    { title: 'View Produce', href: '' },
];

defineProps({
    produce: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="produce.name || 'Produce Details'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <Link 
                        :href="route('produce.index')"
                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-4"
                    >
                        <ArrowLeft class="h-4 w-4 mr-2" />
                        Back to produce
                    </Link>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ produce.name || 'Unnamed Produce' }}</h1>
                        <span 
                            v-if="produce.organic"
                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800"
                        >
                            <Leaf class="h-3 w-3" />
                            Organic
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Produce details and information</p>
                </div>
                <div>
                    <Link
                        :href="route('produce.edit', produce.id)"
                        class="inline-flex items-center rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-amber-600 hover:to-amber-700 transition-all"
                    >
                        <Pencil class="h-5 w-5 mr-2" />
                        Edit Produce
                    </Link>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <Package class="h-5 w-5 text-amber-500" />
                        Produce Information
                    </h3>
                </div>

                <!-- Main Content -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                                    <User class="h-5 w-5" />
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Farmer</h4>
                                    <p class="mt-1 text-base font-medium text-gray-900">
                                        {{ produce.user?.name || 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                                    <Tag class="h-5 w-5" />
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Category</h4>
                                    <p class="mt-1 text-base font-medium text-gray-900">
                                        {{ produce.category?.name || 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        <DollarSign class="h-4 w-4" />
                                        Current Price
                                    </h4>
                                    <p class="mt-1 text-xl font-bold text-gray-900">
                                        ${{ produce.price ? Number(produce.price).toFixed(2) : 'N/A' }}
                                    </p>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        <DollarSign class="h-4 w-4" />
                                        Original Price
                                    </h4>
                                    <p class="mt-1 text-lg font-medium text-gray-500 line-through">
                                        ${{ produce.original_price ? Number(produce.original_price).toFixed(2) : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        <Percent class="h-4 w-4" />
                                        Discount
                                    </h4>
                                    <p class="mt-1 text-lg font-bold text-rose-600">
                                        {{ produce.discount ? `${produce.discount}%` : 'None' }}
                                    </p>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        <Package class="h-4 w-4" />
                                        Quantity
                                    </h4>
                                    <p class="mt-1 text-lg font-medium text-gray-900">
                                        {{ produce.quantity || 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                    <MapPin class="h-4 w-4" />
                                    Farm Location
                                </h4>
                                <p class="mt-1 text-base font-medium text-gray-900">
                                    {{ produce.farm_name ? `${produce.farm_name} • ${produce.location || 'N/A'}` : produce.location || 'N/A' }}
                                </p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1 mb-2">
                                    <FileText class="h-4 w-4" />
                                    Description
                                </h4>
                                <p class="text-base text-gray-700">
                                    {{ produce.description || 'No description provided.' }}
                                </p>
                            </div>

                            <div v-if="produce.image_path" class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1 mb-2">
                                    <ImageIcon class="h-4 w-4" />
                                    Product Image
                                </h4>
                                <div class="mt-2 overflow-hidden rounded-lg border border-gray-200">
                                    <img 
                                        :src="`/storage/${produce.image_path}`" 
                                        :alt="produce.name || 'Produce Image'" 
                                        class="w-full h-auto object-cover transition-all hover:scale-105"
                                    />
                                </div>
                            </div>
                            <div v-else class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-500 flex items-center gap-1 mb-2">
                                    <ImageIcon class="h-4 w-4" />
                                    Product Image
                                </h4>
                                <p class="text-base text-gray-700">No image available.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    <Link
                        :href="route('produce.index')"
                        class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 transition-all"
                    >
                        <ArrowLeft class="h-5 w-5 mr-2" />
                        Back to all produce
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Custom transition effects */
.hover\:scale-105:hover {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}

/* Smooth gradient transitions */
.bg-gradient-to-r {
  transition: background 0.3s ease;
}
</style>