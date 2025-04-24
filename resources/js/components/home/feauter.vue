<template>
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-4xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-green-600">
            Power Your SaaS Platform
          </h2>
          <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
            Cutting-edge features designed to accelerate your growth and streamline operations.
          </p>
        </div>
  
        <div class="mt-16 grid gap-8 md:grid-cols-3 items-end">
          <!-- First Card (normal position) -->
          <div 
            class="group relative bg-white p-8 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
          >
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-green-600 text-white mb-6 transition-all duration-300 group-hover:scale-110">
                <div class="w-8 h-8" v-html="features[0].icon"></div>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ features[0].title }}</h3>
              <p class="text-gray-600">{{ features[0].desc }}</p>
            </div>
          </div>
  
          <!-- Middle Card (lowered position) -->
          <div 
            class="group relative bg-white p-8 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 transform translate-y-10"
          >
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-green-600 text-white mb-6 transition-all duration-300 group-hover:scale-110">
                <div class="w-8 h-8" v-html="features[1].icon"></div>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ features[1].title }}</h3>
              <p class="text-gray-600">{{ features[1].desc }}</p>
            </div>
          </div>
  
          <!-- Third Card (normal position) -->
          <div 
            class="group relative bg-white p-8 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
          >
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-green-600 text-white mb-6 transition-all duration-300 group-hover:scale-110">
                <div class="w-8 h-8" v-html="features[2].icon"></div>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ features[2].title }}</h3>
              <p class="text-gray-600">{{ features[2].desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'ModernFeatures',
    data() {
      return {
        features: [
          {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>`,
            title: 'Lightning Speed',
            desc: 'Optimized for performance with instant updates and real-time data processing.'
          },
          {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>`,
            title: 'Smart Analytics',
            desc: 'Advanced metrics and insights to help you understand and grow your business.'
          },
          {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>`,
            title: 'Enterprise Security',
            desc: 'Military-grade encryption and compliance to keep your data protected.'
          }
        ]
      }
    }
  }
  </script>