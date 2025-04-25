<!-- src/components/Statistics.vue -->
<template>
  <section class="text-gray-600 mx-20 my-10 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
      <div class="flex flex-wrap -mx-4 mt-auto mb-auto lg:w-1/2 sm:w-2/3 content-start sm:pr-10">
        <div class="w-full sm:p-4 px-4 mb-6">
          <h1 class="title-font font-bold text-3xl md:text-4xl mb-4 text-gray-900 tracking-tight">
            Moon hashtag pop-up try-hard offal truffaut
          </h1>
          <div class="leading-relaxed text-lg text-gray-600">
            Pour-over craft beer pug drinking vinegar live-edge gastropub, keytar neutra sustainable fingerstache kickstarter.
          </div>
        </div>

        <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
          <h2 class="title-font font-bold text-3xl text-gray-900 mb-1">
            <CountTo :endVal="2700" :duration="2000" />
          </h2>
          <p class="leading-relaxed text-gray-500 font-medium">Users</p>
        </div>

        <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
          <h2 class="title-font font-bold text-3xl text-gray-900 mb-1">
            <CountTo :endVal="1800" :duration="2000" />
          </h2>
          <p class="leading-relaxed text-gray-500 font-medium">Subscribes</p>
        </div>

        <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
          <h2 class="title-font font-bold text-3xl text-gray-900 mb-1">
            <CountTo :endVal="35" :duration="1500" />
          </h2>
          <p class="leading-relaxed text-gray-500 font-medium">Downloads</p>
        </div>

        <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
          <h2 class="title-font font-bold text-3xl text-gray-900 mb-1">
            <CountTo :endVal="4" :duration="1000" />
          </h2>
          <p class="leading-relaxed text-gray-500 font-medium">Products</p>
        </div>
      </div>

      <div class="lg:w-1/2 sm:w-1/3 w-full rounded-lg overflow-hidden mt-6 sm:mt-0">
        <img
          class="hofull h-80 transition-all duration-500 hover:scale-105"
          src="https://www.jurisiti.com/wp-content/uploads/2025/03/agr.jpeg"
          alt="stats"
        >
      </div>
    </div>
  </section>
</template>

<script>
import { defineComponent } from 'vue';

// CountTo component with continuous looping
const CountTo = defineComponent({
  props: {
    endVal: {
      type: Number,
      required: true,
    },
    duration: {
      type: Number,
      default: 2000,
    },
  },
  data() {
    return {
      currentVal: 0,
      isAnimating: true,
    };
  },
  mounted() {
    this.animateValue();
  },
  methods: {
    animateValue() {
      if (!this.isAnimating) return;

      const start = 0;
      const end = this.endVal;
      const duration = this.duration;
      const startTime = performance.now();

      const animate = (timestamp) => {
        if (!this.isAnimating) return;

        const progress = (timestamp - startTime) / duration;
        if (progress >= 1) {
          this.currentVal = end;
          // Reset and restart animation
          this.currentVal = 0;
          setTimeout(() => {
            this.animateValue(); // Restart animation after a brief pause
          }, 500); // 500ms pause for smoother looping
          return;
        }

        this.currentVal = Math.floor(progress * (end - start) + start);
        requestAnimationFrame(animate);
      };

      requestAnimationFrame(animate);
    },
  },
  beforeUnmount() {
    this.isAnimating = false; // Clean up animation on component unmount
  },
  render() {
    return this.currentVal.toLocaleString();
  },
});

export default {
  name: 'Statistics',
  components: {
    CountTo,
  },
};
</script>

<style scoped>
/* Modern font smoothing */
.title-font {
  font-feature-settings: 'kern';
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Subtle hover effect for the image */
img:hover {
  transform: scale(1.03);
  transition: transform 0.5s cubic-bezier(0.25, 0.45, 0.45, 0.95);
}

/* Responsive text sizes */
@media (max-width: 640px) {
  h1 {
    font-size: 2rem;
    line-height: 2.25rem;
  }

  .leading-relaxed {
    font-size: 1rem;
  }
}
</style>