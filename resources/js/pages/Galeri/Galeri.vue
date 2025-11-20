<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Image as ImageIcon, X, ZoomIn } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    photos: Object,
});

// Actions
function openLightbox(item: GalleryItem) {
    selectedItem.value = item;
    document.body.style.overflow = 'hidden'; // Prevent scrolling background
}

function closeLightbox() {
    selectedItem.value = null;
    document.body.style.overflow = ''; // Restore scrolling
}
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Galeri Foto">
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Grid Galeri -->
                <div v-if="photos.length > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div
                        v-for="item in photos"
                        :key="item.foto_id"
                        class="group relative cursor-pointer overflow-hidden rounded-lg"
                        @click="selectedImage = item.url_foto"
                    >
                        <img
                            :src="item.url_foto"
                            :alt="'Galeri Foto ' + item.foto_id"
                            loading="lazy"
                            class="h-64 w-full object-cover transition-transform group-hover:scale-110"
                        />
                        <div
                            class="rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-sm"
                        >
                            <ZoomIn class="h-6 w-6" />
                        </div>
                    </div>

                    <!-- Content Overlay (Bottom Text) -->
                    <div
                        class="absolute bottom-0 left-0 w-full translate-y-4 p-4 opacity-0 transition-all delay-100 duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                    ></div>
                </div>
                <div v-else class="text-center text-gray-500">
                    <p>Belum ada foto di galeri.</p>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="galeriData.length === 0" class="py-20 text-center">
                <div
                    class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >
                    <ImageIcon class="h-8 w-8" />
                </div>
                <p class="text-slate-500">Belum ada foto di galeri.</p>
            </div>

            <!-- Modern Lightbox -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selectedItem"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/95 p-4 backdrop-blur-sm sm:p-8"
                    @click="closeLightbox"
                >
                    <!-- Close Button -->
                    <button
                        class="absolute top-6 right-6 z-10 rounded-full bg-white/10 p-2 text-white transition-colors hover:bg-white/20 focus:outline-none"
                        @click.stop="closeLightbox"
                    >
                        <X class="h-8 w-8" />
                    </button>

                    <!-- Image Container -->
                    <div
                        class="relative flex max-h-full w-full max-w-5xl flex-col items-center"
                        @click.stop
                    >
                        <img
                            :src="selectedItem.image"
                            class="max-h-[80vh] w-auto rounded-lg object-contain shadow-2xl"
                        />

                        <!-- Caption Bar -->
                        <div class="mt-4 text-center"></div>
                    </div>
                </div>
            </transition>
        </div>
    </Layout>
</template>
