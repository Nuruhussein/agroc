<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale);

export default {
  components: { AppLayout, Head, Line },
  props: {
    totalProducts: Number,
    latestProduce: Object,
    priceTrend: String,
    chartData: Object,
    breadcrumbs: Array,
  },
  computed: {
    chartDataConfig() {
      return {
        labels: this.chartData.labels,
        datasets: [
          {
            label: 'Average Price',
            data: this.chartData.data,
            borderColor: 'rgb(139, 92, 246)',
            backgroundColor: 'rgba(139, 92, 246, 0.2)',
            fill: true,
            tension: 0.4,
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
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'top',
            labels: {
              color: '#1f2937',
            },
          },
          title: {
            display: true,
            text: 'Daily Average Produce Prices (Last 7 Days)',
            color: '#1f2937',
            font: {
              size: 16,
            },
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
          x: {
            ticks: {
              color: '#1f2937',
            },
            grid: {
              display: false,
            },
          },
          y: {
            ticks: {
              color: '#1f2937',
              callback: (value) => `$${value}`,
            },
            grid: {
              color: '#e5e7eb',
            },
            title: {
              display: true,
              text: 'Price ($)',
              color: '#1f2937',
            },
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
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
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

        <!-- Card 2: Latest Produce Listing -->
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
      </div>
      <!-- Chart Section -->

      <div class="relative h-96 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Trends Overview</h3>
        <div class="h-80">
          <Line :data="chartDataConfig" :options="chartOptions" />
        </div>
      </div>
       <!-- <div class="relative h-96 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Trends Overview</h3>
        <div class="h-80">
          <Line :data="chartDataConfig" :options="chartOptions" />
        </div>
      </div> -->
    </div>
    
  </AppLayout>
</template>