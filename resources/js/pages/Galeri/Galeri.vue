<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Image as ImageIcon, X, ZoomIn } from 'lucide-vue-next';
import { ref } from 'vue';

// Definisi Tipe untuk Item Galeri
interface GalleryItem {
    id: number;
    image: string;
}

// Data Galeri
const galeriData: GalleryItem[] = [
    { id: 1, image: '/hero-bg.jpg' },
    { id: 2, image: '/hero-bg.jpg' },
    { id: 3, image: '/hero-bg.jpg' },
    { id: 4, image: '/hero-bg.jpg' },
    { id: 5, image: '/hero-bg.jpg' },
    { id: 6, image: '/hero-bg.jpg' },
    { id: 7, image: '/hero-bg.jpg' },
    { id: 8, image: '/hero-bg.jpg' },
];

// State
const selectedItem = ref<GalleryItem | null>(null);
const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profil' },
    { label: 'Galeri' },
];

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
        <!-- Background Decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header Section
            <div class="mx-auto mb-12 max-w-3xl text-center">
                <h1
                    class="mb-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"
                >
                    Galeri Kegiatan
                </h1>
                <p class="text-lg text-slate-600">
                    Dokumentasi kegiatan, fasilitas, dan momen berharga di
                    Perpustakaan POLBAN.
                </p>
                <div class="mt-6 flex justify-center">
                    <div
                        class="h-1.5 w-20 rounded-full bg-[#99cc33] shadow-sm shadow-[#99cc33]/50"
                    ></div>
                </div>
            </div> -->

            <!-- Grid Galeri -->
            <!-- Menggunakan columns-xs untuk efek Masonry sederhana atau grid standard yang rapi -->
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <div
                    v-for="item in galeriData"
                    :key="item.id"
                    class="group relative aspect-[4/3] cursor-pointer overflow-hidden rounded-2xl bg-slate-200 shadow-md transition-all duration-500 hover:shadow-xl hover:shadow-[#99cc33]/20"
                    @click="openLightbox(item)"
                >
                    <!-- Image -->
                    <img
                        :src="item.image"
                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy"
                    />

                    <!-- Overlay Gradient -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>

                    <!-- Content Overlay (Center Icon) -->
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity delay-75 duration-300 group-hover:opacity-100"
                    >
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
