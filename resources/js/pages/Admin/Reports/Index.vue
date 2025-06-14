<script setup>
import { Head, router, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    reports: Object,
});

const showModal = ref(false);
const selectedReport = ref(null);

const openModal = (report) => {
    selectedReport.value = report;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const updateStatus = (reportId, status) => {
    router.patch(`/admin/reports/${reportId}/status`, { status }, {
        preserveState: true,
        onSuccess: () => {
            console.log('Status updated');
        },
        onError: (errors) => {
            console.error('Failed to update status', errors);
        },
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleString();
};
</script>

<template>
    <Head title="Reports" />

    <AppLayout>
        <div class="px-4 py-8 max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Reported Items</h1>

            <!-- Success Message -->
            <div v-if="$page.props.flash.success" class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ $page.props.flash.success }}
            </div>

            <!-- Reports Table -->
            <div v-if="reports.data.length" class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-900">Report ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Item</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Buyer</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Farmer</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Reason</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Reported At</th>
                            <th class="px-4 py-3 font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="report in reports.data" :key="report.id" class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ report.id }}</td>
                            <td class="px-4 py-3">{{ report.produce_name }}</td>
                            <td class="px-4 py-3">
                                {{ report.buyer_name }}<br>
                                <span class="text-gray-500 text-xs">{{ report.buyer_email }}</span>
                            </td>
                            <td class="px-4 py-3">
                                {{ report.farmer_name }}<br>
                                <span class="text-gray-500 text-xs">{{ report.farmer_email }}</span>
                            </td>
                            <td class="px-4 py-3">{{ report.reason }}</td>
                            <td class="px-4 py-3">
                                <span :class="{
                                    'text-yellow-600 bg-yellow-100': report.status === 'pending',
                                    'text-blue-600 bg-blue-100': report.status === 'reviewed',
                                    'text-green-600 bg-green-100': report.status === 'resolved'
                                }" class="px-2 py-1 rounded-full text-xs">
                                    {{ report.status.charAt(0).toUpperCase() + report.status.slice(1) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ formatDate(report.created_at) }}</td>
                            <td class="px-4 py-3 flex space-x-2">
                                <button
                                    @click="openModal(report)"
                                    class="text-indigo-600 hover:text-indigo-800 text-sm"
                                >
                                    View Details
                                </button>
                                <button
                                    v-if="report.status === 'pending'"
                                    @click="updateStatus(report.id, 'reviewed')"
                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                >
                                    Review
                                </button>
                                <button
                                    v-if="report.status !== 'resolved'"
                                    @click="updateStatus(report.id, 'resolved')"
                                    class="text-green-600 hover:text-green-800 text-sm"
                                >
                                    Resolve
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div v-if="reports.links" class="p-4 flex justify-end">
                    <span
                        v-for="link in reports.links"
                        :key="link.url || link.label"
                        class="mx-1 px-3 py-1 rounded-lg"
                        :class="{
                            'bg-purple-600 text-white': link.active,
                            'text-gray-600 hover:bg-gray-100 cursor-pointer': !link.active && link.url,
                            'text-gray-400': !link.url
                        }"
                        @click="link.url && router.get(link.url)"
                        v-html="link.label"
                    />
                </div>
            </div>

            <!-- No Reports -->
            <div v-else class="text-center text-gray-600 mt-6">
                No reports found.
            </div>
        </div>

        <!-- Report Details Modal -->
        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    Report Details #{{ selectedReport?.id }}
                </h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-700">Transaction Details</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Produce Name</p>
                                <p class="text-sm font-medium">{{ selectedReport?.produce_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Transaction Date</p>
                                <p class="text-sm font-medium">{{ selectedReport?.transaction_date ? formatDate(selectedReport.transaction_date) : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-medium text-gray-700">Parties Involved</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Buyer</p>
                                <p class="text-sm font-medium">{{ selectedReport?.buyer_name }}</p>
                                <p class="text-sm text-gray-500">{{ selectedReport?.buyer_email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Farmer</p>
                                <p class="text-sm font-medium">{{ selectedReport?.farmer_name }}</p>
                                <p class="text-sm text-gray-500">{{ selectedReport?.farmer_email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-medium text-gray-700">Report Information</h3>
                        <div class="mt-2 space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Reason</p>
                                <p class="text-sm font-medium">{{ selectedReport?.reason }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-sm font-medium">{{ selectedReport?.description || 'No additional details provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span :class="{
                                    'text-yellow-600 bg-yellow-100': selectedReport?.status === 'pending',
                                    'text-blue-600 bg-blue-100': selectedReport?.status === 'reviewed',
                                    'text-green-600 bg-green-100': selectedReport?.status === 'resolved'
                                }" class="px-2 py-1 rounded-full text-xs">
                                    {{ selectedReport?.status?.charAt(0).toUpperCase() + selectedReport?.status?.slice(1) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Reported At</p>
                                <p class="text-sm font-medium">{{ selectedReport?.created_at ? formatDate(selectedReport.created_at) : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 flex justify-end space-x-3">
                        <button
                            @click="closeModal"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800"
                        >
                            Close
                        </button>
                        <button
                            v-if="selectedReport?.status === 'pending'"
                            @click="[updateStatus(selectedReport.id, 'reviewed'), closeModal()]"
                            class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Mark as Reviewed
                        </button>
                        <button
                            v-if="selectedReport?.status !== 'resolved'"
                            @click="[updateStatus(selectedReport.id, 'resolved'), closeModal()]"
                            class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700"
                        >
                            Mark as Resolved
                        </button>
                    </div>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>