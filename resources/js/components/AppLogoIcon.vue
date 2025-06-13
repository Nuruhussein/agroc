<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
 <img 
                   src="https://marketplace.canva.com/EAGHc4fErhI/1/0/1600w/canva-green-and-white-organic-agriculture-logo-FN-ZChdNoIg.jpg"

    alt="Logo"
    class="h-10 rounded-b-3xl  w-auto"
    v-bind="$attrs"
    :class="className"
/>
</template>
