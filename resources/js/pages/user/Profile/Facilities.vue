<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import RemahanRoti from '@/layouts/RemahanRoti.vue';

// Definisikan tipe Props yang baru sesuai struktur Controller
defineProps<{
    title: string;
    subtitle: string;
    facilities: {
        subjudul: string;
        description: string;
        image: string;
    }[];
}>();

const breadcrumb = [
    { label: 'Profile' },
    { label: 'Fasilitas' }
];

</script>

<template>
    <Layout>
        <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 max-w-6xl">
            <RemahanRoti :itemRoti="breadcrumb" />
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">
                    {{ title }}
                </h1>
                <p class="text-gray-600">
                    {{ subtitle }}
                </p>
            </header>

            <div class="space-y-16">

                <div v-for="(facility, index) in facilities" :key="index" class="group">
                    <div class="flex flex-col md:flex-row items-center bg-white rounded-xl shadow-lg overflow-hidden">
                        
                        <div :class="['w-full md:w-1/2', { 'md:order-last': index % 2 !== 0 }]">
                            <img :src="facility.image" :alt="'Gambar ' + facility.subjudul" class="w-full h-96 object-cover"/>
                        </div>

                        <div :class="['w-full md:w-1/2 p-8', { 'md:order-first': index % 2 !== 0 }]">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                                {{ facility.subjudul }}
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ facility.description }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Layout>
</template>