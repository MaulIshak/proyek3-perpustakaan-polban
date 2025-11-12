<template>
    <a :href="href" class="group flex-shrink-0"
        ><div class="w-40">
            <img
                alt="Book Cover"
                class="h-56 w-full rounded-lg object-cover shadow-md transition-all duration-300 group-hover:shadow-md hover:brightness-120"
                :src="src"
            /></div
    ></a>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

defineProps<{
    href: string;
    src: string;
}>();
</script>
