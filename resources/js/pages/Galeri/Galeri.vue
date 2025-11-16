<script setup>
import Layout from '@/layouts/UserAppLayout.vue';
import { X } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    photos: Array,
});

// Gambar yang sedang dipilih
const selectedImage = ref(null);
const breadcrumb = [{ label: 'Profil' }, { label: 'Tentang Perpustakaan' }];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Galeri Foto">
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Grid Galeri -->
                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <div
                        v-for="item in photos"
                        :key="item.foto_id"
                        class="group relative cursor-pointer overflow-hidden rounded-lg"
                        @click="selectedImage = item.url_foto"
                    >
                        <img
                            :src="item.url_foto"
                            :alt="item.caption"
                            class="h-64 w-full object-cover transition-transform group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors group-hover:bg-black/40"
                        >
                            <span
                                class="font-medium text-white opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                Klik untuk memperbesar
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lightbox -->
            <div
                v-if="selectedImage"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                @click="selectedImage = null"
            >
                <button
                    class="absolute top-4 right-4 text-white hover:text-gray-300"
                    @click.stop="selectedImage = null"
                >
                    <X class="h-8 w-8" />
                </button>
                <img
                    :src="selectedImage"
                    alt="Preview"
                    class="max-h-full max-w-full object-contain"
                    @click.stop
                />
            </div>
        </div>
    </Layout>
</template>
