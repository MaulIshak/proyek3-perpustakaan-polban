<script setup lang="ts">
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
    </UserAppLayout>
</template>
