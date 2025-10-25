<script setup lang="ts">
import HeroSection from '@/components/HeroSection.vue';
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <Layout>
        <HeroSection />
    </Layout>
</template>
