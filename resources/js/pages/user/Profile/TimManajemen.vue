<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
// Asumsikan HeroSection juga diperlukan jika ada di layout/halaman Anda.
// import HeroSection from '@/Components/HeroSection.vue'; 

defineProps({
    title: String
});
</script>

<template>
    <Layout>
        <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 max-w-4xl">
            <h1 class="text-3xl font-extrabold "> {{ title }}</h1>
        </div>
    </Layout>
</template>