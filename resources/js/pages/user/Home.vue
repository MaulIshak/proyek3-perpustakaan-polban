<script setup lang="ts">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import HeroSection from '@/components/HeroSection.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <UserAppLayout>
        <HeroSection />
        <BeritaHighlight />
        <BookCovers />
    </UserAppLayout>
</template>

<style></style>
