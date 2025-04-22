<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Pencil, ArrowLeft } from 'lucide-vue-next';

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Produce', href: '/produce' },
    { title: 'View Produce', href: '' },
];

defineProps({
    produce: {
        type: Object,
        required: true,
        default: () => ({
            id: 0,
            name: '',
            category: { name: '' },
            price: 0,
            quantity: 0,
            user: { name: '' },
        }),
    },
});
</script>

<template>
    <Head :title="produce.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 sm:px-6 lg:px-8 py-8">
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">{{ produce.name }}</h1>
                    <p class="mt-2 text-sm text-gray-600">Produce details</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <Link
                        :href="route('produce.edit', produce.id)"
                        class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600"
                    >
                        <Pencil class="-ml-0.5 mr-1.5 h-5 w-5" />
                        Edit
                    </Link>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Produce Information</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    {{ produce.category.name }}
                                </span>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ Number(produce.price).toFixed(2) }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ produce.quantity }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Farmer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ produce.user.name }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50">
                    <Link
                        :href="route('produce.index')"
                        class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                    >
                        <ArrowLeft class="-ml-0.5 mr-1.5 h-5 w-5" />
                        Back to all produce
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>