<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

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

const breadcrumb = [{ label: 'Profile' }, { label: 'Fasilitas' }];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <!-- <RemahanRoti :itemRoti="breadcrumb" />
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">
                    {{ title }}
                </h1>
                <p class="text-gray-600">
                    {{ subtitle }}
                </p>
            </header> -->

            <div class="space-y-16">
                <div
                    v-for="(facility, index) in facilities"
                    :key="index"
                    class="group"
                >
                    <div
                        class="flex flex-col items-center overflow-hidden rounded-xl bg-white shadow-lg md:flex-row"
                    >
                        <div
                            :class="[
                                'w-full md:w-1/2',
                                { 'md:order-last': index % 2 !== 0 },
                            ]"
                        >
                            <img
                                :src="facility.image"
                                :alt="'Gambar ' + facility.subjudul"
                                class="h-96 w-full object-cover"
                            />
                        </div>

                        <div
                            :class="[
                                'w-full p-8 md:w-1/2',
                                { 'md:order-first': index % 2 !== 0 },
                            ]"
                        >
                            <h3
                                class="mb-3 text-2xl font-semibold text-gray-900"
                            >
                                {{ facility.subjudul }}
                            </h3>
                            <p class="leading-relaxed text-gray-700">
                                {{ facility.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
