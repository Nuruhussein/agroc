<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Line, Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  BarElement,
  PointElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, LineElement, BarElement, PointElement, CategoryScale, LinearScale);

export default {
  components: { AppLayout, Head, Line, Bar, Link },
  props: {
    role: String,
    totalProducts: Number,
    latestProduce: Object,
    priceTrend: String,
    lineChartData: Object,
    barChartData: Object,
    totalOrders: Number,
    deliveredItems: Number,
    pendingOrders: Number,
    totalOwnProducts: Number,
    latestProduct: Object,
    totalItemsOrdered: Number,
    orders: Object,
    produce: Object,
    breadcrumbs: Array,
  },
  computed: {
    lineChartDataConfig() {
      return {
        labels: this.lineChartData ? this.lineChartData.labels : [],
        datasets: [
          {
            label: 'Average Price',
            data: this.lineChartData ? this.lineChartData.data : [],
            borderColor: 'rgb(139, 92, 246)',
            backgroundColor: 'rgba(139, 92, 246, 0.2)',
            fill: true,
            tension: 0.4,
          },
        ],
      };
    },
    barChartDataConfig() {
      return {
        labels: this.barChartData ? this.barChartData.labels : [],
        datasets: [
          {
            label: 'Total Quantity',
            data: this.barChartData ? this.barChartData.data : [],
            backgroundColor: 'rgb(139, 92, 246)',
            borderColor: 'rgb(139, 92, 246)',
            borderWidth: 1,
            barThickness: 60,
          },
        ],
      };
    },
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    },
  },
  data() {
    return {
      lineChartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, position: 'top', labels: { color: '#1f2937' } },
          title: {
            display: true,
            text: 'Daily Average Prices (Last 7 Days)',
            color: '#1f2937',
            font: { size: 16 },
          },
          tooltip: {
            backgroundColor: '#ffffff',
            titleColor: '#1f2937',
            bodyColor: '#1f2937',
            borderColor: '#d1d5db',
            borderWidth: 1,
          },
        },
        scales: {
          x: { ticks: { color: '#1f2937' }, grid: { display: false } },
          y: {
            ticks: { color: '#1f2937', callback: (value) => `$${value}` },
            grid: { color: '#e5e7eb' },
            title: { display: true, text: 'Price ($)', color: '#1f2937' },
          },
        },
      },
      barChartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, position: 'top', labels: { color: '#1f2937' } },
          title: {
            display: true,
            text: 'Quantity by Category (Last 7 Days)',
            color: '#1f2937',
            font: { size: 16 },
          },
          tooltip: {
            backgroundColor: '#ffffff',
            titleColor: '#1f2937',
            bodyColor: '#1f2937',
            borderColor: 'd1d5db',
            borderWidth: 1,
          },
        },
        scales: {
          x: {
            ticks: { color: '#1f2937' },
            grid: { display: false },
            barPercentage: 0.6,
            categoryPercentage: 0.6,
          },
          y: {
            ticks: { color: '#1f2937', callback: (value) => `${value}` },
            grid: { color: '#e5e7eb' },
            title: { display: true, text: 'Quantity', color: '#1f2937' },
          },
        },
      },
    };
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <!-- Cards Section -->
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <!-- Admin Cards -->
        <template v-if="role === 'admin'">
          <!-- Card 1: Total Products -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-green-600 to-blue-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Total Products</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ totalProducts }}</span> product{{ totalProducts !== 1 ? 's' : '' }} listed.
            </p>
          </div>

          <!-- Card 2: Latest Produce -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3-3h12l3 3m-3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V9m8-3v3m-4 0v3m8-3v3" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Latest Produce</h3>
            </div>
            <p v-if="latestProduce" class="text-gray-600 mb-4">
              <span class="font-bold">{{ latestProduce.name }}</span> ({{ latestProduce.category_name }}) at ${{ latestProduce.price }}/{{ latestProduce.unit }} on {{ formatDate(latestProduce.updated_at) }}.
            </p>
            <p v-else class="text-gray-600 mb-4">No recent produce listings available.</p>
          </div>

          <!-- Card 3: Price Trends -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Price Trends</h3>
            </div>
            <p v-if="priceTrend" class="text-gray-600 mb-4">
              Average price over last 7 days: <span class="font-bold">${{ priceTrend }}</span>.
            </p>
            <p v-else class="text-gray-600 mb-4">No recent price data available.</p>
          </div>
        </template>

        <!-- Buyer Cards -->
        <template v-if="role === 'buyer'">
          <!-- Card 1: Total Orders -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-green-600 to-blue-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V11a2 2 0 012-2z" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Total Orders</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ totalOrders }}</span> order{{ totalOrders !== 1 ? 's' : '' }} placed.
            </p>
          </div>

          <!-- Card 2: Delivered Items -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Delivered Items</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ deliveredItems }}</span> item{{ deliveredItems !== 1 ? 's' : '' }} delivered.
            </p>
          </div>

          <!-- Card 3: Pending Orders -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Pending Orders</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ pendingOrders }}</span> order{{ pendingOrders !== 1 ? 's' : '' }} pending.
            </p>
          </div>
        </template>

        <!-- Farmer Cards -->
        <template v-if="role === 'farmer'">
          <!-- Card 1: Total Own Products -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-green-600 to-blue-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Total Products</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ totalOwnProducts }}</span> product{{ totalOwnProducts !== 1 ? 's' : '' }} listed.
            </p>
          </div>

          <!-- Card 2: Latest Product -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3-3h12l3 3m-3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V9m8-3v3m-4 0v3m8-3v3" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Latest Product</h3>
            </div>
            <p v-if="latestProduct" class="text-gray-600 mb-4">
              <span class="font-bold">{{ latestProduct.name }}</span> ({{ latestProduct.category_name }}) at ${{ latestProduct.price }}/{{ latestProduct.unit }} on {{ formatDate(latestProduct.updated_at) }}.
            </p>
            <p v-else class="text-gray-600 mb-4">No recent products listed.</p>
          </div>

          <!-- Card 3: Total Items Ordered -->
          <div class="relative bg-white p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 to-green-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v18H3V3zm2 2v14h14V5H5z" />
                </svg>
              </div>
              <h3 class="ml-3 text-lg font-semibold text-gray-900">Items Ordered</h3>
            </div>
            <p class="text-gray-600 mb-4">
              <span class="font-bold text-2xl">{{ totalItemsOrdered }}</span> item{{ totalItemsOrdered !== 1 ? 's' : '' }} ordered.
            </p>
          </div>
        </template>
      </div>

      <!-- Tables Section -->
      <!-- Buyer Orders Table -->
      <div v-if="role === 'buyer' && orders.data.length" class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6 shadow-sm mt-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Orders</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 font-semibold text-gray-900">Order Number</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Total ($)</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Status</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Items</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Ordered At</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders.data" :key="order.id" class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ order.order_number }}</td>
                <td class="px-4 py-2">{{ order.total_amount }}</td>
                <td class="px-4 py-2">
                  <span :class="{
                    'text-green-600': order.status === 'delivered',
                    'text-yellow-600': order.status === 'pending',
                    'text-red-600': order.status === 'cancelled'
                  }">
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-4 py-2">{{ order.items_count }}</td>
                <td class="px-4 py-2">{{ formatDate(order.created_at) }}</td>
                <td class="px-4 py-2">
                  <Link :href="`/orders/${order.id}`" class="text-purple-600 hover:text-purple-800">
                    View
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div v-if="orders.links" class="mt-4 flex justify-end">
          <div v-for="link in orders.links" :key="link.url" class="mx-1">
            <Link v-if="link.url" :href="link.url" class="px-3 py-1 rounded-lg" :class="{
              'bg-purple-600 text-white': link.active,
              'text-gray-600 hover:bg-gray-100': !link.active
            }" v-html="link.label" />
            <span v-else class="px-3 py-1 text-gray-400" v-html="link.label" />
          </div>
        </div>
      </div>

      <!-- Farmer Produce Table -->
      <div v-if="role === 'farmer' && produce.data.length" class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6 shadow-sm mt-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Produce</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 font-semibold text-gray-900">Name</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Category</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Price</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Quantity</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Updated At</th>
                <th class="px-4 py-2 font-semibold text-gray-900">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in produce.data" :key="item.id" class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ item.name }}</td>
                <td class="px-4 py-2">{{ item.category_name }}</td>
                <td class="px-4 py-2">${{ item.price }}/{{ item.unit }}</td>
                <td class="px-4 py-2">{{ item.quantity }}</td>
                <td class="px-4 py-2">{{ formatDate(item.updated_at) }}</td>
                <td class="px-4 py-2 flex space-x-2">
                  <Link :href="`/produce/${item.id}`" class="text-purple-600 hover:text-purple-800">View</Link>
                  <Link :href="`/produce/${item.id}/edit`" class="text-green-600 hover:text-green-800">Edit</Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div v-if="produce.links" class="mt-4 flex justify-end">
          <div v-for="link in produce.links" :key="link.url" class="mx-1">
            <Link v-if="link.url" :href="link.url" class="px-3 py-1 rounded-lg" :class="{
              'bg-purple-600 text-white': link.active,
              'text-gray-600 hover:bg-gray-100': !link.active
            }" v-html="link.label" />
            <span v-else class="px-3 py-1 text-gray-400" v-html="link.label" />
          </div>
        </div>
      </div>

      <!-- Admin Charts -->
      <div v-if="role === 'admin'" class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6 shadow-sm mt-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Market Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Line Chart -->
          <div class="h-80">
            <Line :data="lineChartDataConfig" :options="lineChartOptions" />
          </div>
          <!-- Bar Chart -->
          <div class="h-80">
            <Bar :data="barChartDataConfig" :options="barChartOptions" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>