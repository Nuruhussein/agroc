<script setup>
import { ref, provide, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import Landing from '@/components/home/landing.vue';
import Feature from '@/components/home/feauter.vue';
import FeaturedProduct from '@/components/home/feauteredproduct.vue';
import Statistics from '@/components/home/statistics.vue';
import Price from '@/components/home/price.vue';
import Cta from '@/components/home/cta.vue';
import Footerr from '@/components/home/footer.vue';
import MainLayout from '@/layouts/MainLayout.vue';

// Access Inertia props
const { props } = usePage();
const featuredProducts = props.featuredProducts || [];
const marketPrices = props.marketPrices || [];

// Debug props
console.log('All props:', props);
console.log('featuredProducts:', featuredProducts);
console.log('marketPrices:', marketPrices);
</script>

<template>
    <div>
        <Navbar />
        <Landing />
        <Feature />
        <FeaturedProduct :products="featuredProducts" />
        <Statistics />
        <Price />
        <Cta />
        <Footerr />
    </div>
</template>

<script>
export default {
    layout: MainLayout,
};
</script>