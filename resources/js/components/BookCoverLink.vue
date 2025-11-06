<template>
    <a :href="href" class="group flex-shrink-0"
        ><div class="w-40">
            <img
                alt="Book Cover"
                class="h-56 w-full rounded-lg object-cover shadow-md transition-shadow group-hover:shadow-xl"
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
