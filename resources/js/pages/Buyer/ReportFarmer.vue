<script setup>
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    orderItem: Object,
});

const form = ref({
    reason: '',
});

const errors = ref({});

const submit = () => {
    router.post(`/buyer/report/${props.orderItem.id}`, form.value, {
        preserveState: true,
        onError: (err) => {
            errors.value = err;
        },
    });
};
</script>

<template>
    <Head title="Report Farmer" />

    <AppLayout>
        <div class="px-4 py-8 max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Report Farmer</h1>
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <p class="text-gray-600 mb-4">
                    Please provide details for reporting <strong>{{ orderItem.farmer_name }}</strong> regarding
                    <strong>{{ orderItem.produce_name }}</strong>.
                </p>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Report</label>
                        <textarea
                            id="reason"
                            v-model="form.reason"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500"
                            rows="6"
                            required
                        ></textarea>
                        <p v-if="errors.reason" class="text-red-600 text-sm mt-1">{{ errors.reason }}</p>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition"
                    >
                        Submit Report
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>