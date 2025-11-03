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
</script>

<template>
    <Layout>
        <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 max-w-6xl">
            <header class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">
                    {{ title }}
                </h1>
                <p class="text-gray-600">
                    {{ subtitle }}
                </p>
            </header>

            <div class="space-y-12">
                
                <div 
                    v-for="(facility, index) in facilities" 
                    :key="index" 
                    class="bg-white rounded-xl shadow-lg overflow-hidden"
                >
                    <div 
                        class="md:grid md:grid-cols-2 md:gap-0"
                        :class="{ 'md:grid-flow-col-dense': index % 2 !== 0 }"
                    >
                        <div 
                            class="md:order-1" 
                            :class="{ 'md:order-2': index % 2 !== 0 }"
                        >
                            <img 
                                :src="facility.image" 
                                :alt="'Gambar ' + facility.subjudul" 
                                class="w-full h-full object-cover max-h-96 md:max-h-full" 
                            />
                        </div>

                        <div 
                            class="p-6 sm:p-8 flex flex-col justify-center md:order-2"
                            :class="{ 'md:order-1': index % 2 !== 0 }"
                        >
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