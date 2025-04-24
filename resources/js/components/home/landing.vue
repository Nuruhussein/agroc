<template>
  <section class="relative overflow-hidden py-24 px-4 sm:px-8">
    <!-- Background Video -->
    <video
      class="absolute inset-0 w-full h-full object-cover z-0"
      autoplay
      muted
      loop
      playsinline
    >
      <source src="/assets/eso.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 z-10 bg-gradient-to-br from-gray-900/90 to-indigo-900/70"></div>
    
    <!-- Abstract Shapes -->
    <div class="absolute inset-0 overflow-hidden z-10">
      <div class="absolute -top-20 -left-20 w-80 h-80 bg-indigo-500 rounded-full mix-blend-overlay opacity-20 blur-3xl"></div>
      <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-pink-500 rounded-full mix-blend-overlay opacity-20 blur-3xl"></div>
    </div>
    
    <!-- Content -->
    <div class="max-w-2xl mx-auto text-center relative z-20">
      <div class="py-4">
        <h3 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl bg-clip-text bg-gradient-to-r from-white to-indigo-200">
          Elevate Your Digital Presence
        </h3>
        <p class="mt-4 text-lg text-indigo-100 max-w-2xl mx-auto leading-relaxed">
          Premium templates designed to accelerate your workflow.
        </p>
      </div>
      
      <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
        <a
          href="#"
          class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden text-base font-medium text-indigo-600 transition-all duration-300 bg-white rounded-lg group hover:bg-gray-50 focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-80 shadow-lg hover:shadow-white/30"
        >
          <span class="absolute inset-0 w-full h-full transition-all duration-500 ease-in-out -translate-x-full bg-gradient-to-r from-cyan-400 to-blue-500 opacity-10 group-hover:translate-x-0"></span>
          <span class="relative flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Explore Templates
          </span>
        </a>
        
        <a
          href="#"
          class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden text-base font-medium text-white transition-all duration-300 border border-indigo-400 rounded-lg group hover:bg-indigo-900/30 focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-80 shadow-lg hover:shadow-indigo-500/20"
        >
          <span class="absolute inset-0 w-0 h-full transition-all duration-300 ease-out bg-indigo-600/10 group-hover:w-full"></span>
          <span class="relative flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Get Started
          </span>
        </a>
      </div>
      
      <div class="mt-8 flex items-center justify-center gap-4">
        <div class="flex -space-x-3">
          <img class="w-10 h-10 border-2 border-white rounded-full" src="https://randomuser.me/api/portraits/women/12.jpg" alt="User">
          <img class="w-10 h-10 border-2 border-white rounded-full" src="https://randomuser.me/api/portraits/men/24.jpg" alt="User">
          <img class="w-10 h-10 border-2 border-white rounded-full" src="https://randomuser.me/api/portraits/women/28.jpg" alt="User">
        </div>
        <div class="text-left">
          <p class="text-sm font-medium text-white">10,000+ creators</p>
          <div class="flex items-center mt-0.5">
            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <p class="ml-1 text-xs font-medium text-gray-300">4.9 (2.1k)</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "CompactVideoCTA",
};
</script>