<template>
  <section class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6">Category Price Guide</h2>

    <table class="min-w-full bg-white rounded shadow">
      <thead>
        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase">
          <th class="px-4 py-3">Category</th>
          <th class="px-4 py-3">Base Price</th>
          <th class="px-4 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in categories" :key="item.id" class="border-b">
          <td class="px-4 py-3">{{ item.category }}</td>
          <td class="px-4 py-3">
            <input
              v-model.number="item.base_price"
              type="number"
              step="0.01"
              class="border p-1 rounded w-32"
            />
          </td>
          <td class="px-4 py-3">
            <button
              @click="updatePrice(item)"
              class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
            >
              Save
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const categories = ref([...props.categories]);

function updatePrice(item) {
  router.put(`/admin/price-guide/${item.id}`, {
    base_price: item.base_price
  }, {
    onSuccess: () => alert(`Price for ${item.category} updated.`)
  });
}
</script>
