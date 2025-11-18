<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    pdf_url: {
        type: String,
    }
});

const breadcrumb = [{ label: 'Profil' }, { label: 'Rencana Strategi' }];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 sm:p-6 md:p-8 shadow-lg rounded-2xl">
                <div v-if="pdf_url">
                    <iframe :src="pdf_url" class="w-full h-screen"></iframe>
                </div>
                <div v-else>
                    <p class="text-center text-gray-500">Rencana Strategi tidak tersedia.</p>
                </div>
            </div>
        </div>
    </Layout>
</template>
