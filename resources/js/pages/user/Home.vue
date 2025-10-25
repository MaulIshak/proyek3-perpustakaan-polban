<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <Layout>
        <div class="container mx-auto px-4 py-8">
            <h1 class="mb-4 text-3xl font-bold">
                {{ title }}
            </h1>
            <p class="text-sm text-gray-900">{{ description }}</p>
        </div>
    </Layout>
</template>
