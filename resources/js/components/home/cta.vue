<template>
    <section class="relative overflow-hidden py-40 px-4 bg-gray-900 sm:px-8">
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
      <!-- Gradient Overlay (changed to black) -->
      <div class="w-full h-full bg-black/85 absolute inset-0 z-10"></div>
      <!-- Original Gradient Circle (kept for aesthetic) -->
      <div
        class="w-full h-full rounded-full bg-gradient-to-r from-[#3a7fb7] to-pink-500 absolute -top-12 -right-14 blur-2xl opacity-10 z-10"
      ></div>
      <!-- Content -->
      <div class="max-w-xl mx-auto text-center relative z-20">
        <div class="py-4">
          <h3 class="text-3xl text-gray-200 font-semibold md:text-4xl">
            Get Unlimited Access To All Templates
          </h3>
          <p class="text-gray-300 leading-relaxed mt-3">
            Nam erat risus, sodales sit amet lobortis ut, finibus eget metus. Cras aliquam ante ut tortor posuere feugiat.
            Duis sodales nisi id porta lacinia.
          </p>
        </div>
        <div class="mt-6 items-center justify-center gap-4 sm:flex">
          <a
            href="javascript:void()"
            class="block w-full mt-2 py-3 px-10 text-gray-700 bg-white rounded-md duration-150 hover:bg-gray-100 sm:w-auto"
          >
            Try It Out
          </a>
          <a
            href="javascript:void()"
            class="block w-full mt-2 py-3 px-10 text-gray-300 bg-gray-700 rounded-md duration-150 hover:bg-gray-800 sm:w-auto"
          >
            Get Started
          </a>
        </div>
      </div>
    </section>
  </template>