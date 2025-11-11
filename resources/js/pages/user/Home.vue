<script setup lang="ts">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import HeroSection from '@/components/HeroSection.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: String,
    description: String,
});

const breadcrumbs = [
    { label: 'Home', link: '/' },
];
</script>

<template>
    <UserAppLayout :page="false" title="HOME" subtitle="" :breadcrumb="breadcrumbs">
        <HeroSection />
        <BeritaHighlight />
        <BookCovers />
    </UserAppLayout>
</template>
