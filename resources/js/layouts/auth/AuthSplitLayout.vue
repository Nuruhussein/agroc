<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name || "FarmTrack"; // Default app name
const quote = page.props.quote || { 
  message: "Empowering farmers with real-time market prices and direct buyer connections",
  author: "FarmTrack Mission"
};

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <!-- Left side with agricultural background -->
        <div class="relative hidden h-full flex-col bg-muted p-10 text-white dark:border-r lg:flex" 
             style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://www.gruber-genetti.it/cache/img-magazin-2019-smart-farming-teil-1-4-0web-1400.jpg'); background-size: cover; background-position: center;">
            <Link :href="route('home')" class="relative z-20 flex items-center text-lg font-medium">
                <AppLogoIcon class="mr-2 size-8 fill-current text-white" />
                {{ name }}
            </Link>
            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <p class="text-lg">&ldquo;{{ quote.message }}&rdquo;</p>
                    <footer class="text-sm text-neutral-300">{{ quote.author }}</footer>
                </blockquote>
            </div>
        </div>

        <!-- Right side with form content -->
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-sm text-muted-foreground" v-if="description">
                        {{ description || 'Connect directly with buyers and get fair prices for your produce' }}
                    </p>
                </div>
                <slot />
                
                <!-- Additional agricultural-themed links -->
                <div class="text-center text-sm text-muted-foreground">
                    <p>By continuing, you agree to our <a href="/terms" class="underline">Terms</a> and <a href="/privacy" class="underline">Privacy Policy</a></p>
                    <p class="mt-2">Need help? <a href="/contact" class="text-green-600 hover:underline">Contact our farm support team</a></p>
                </div>
            </div>
        </div>
    </div>
</template>