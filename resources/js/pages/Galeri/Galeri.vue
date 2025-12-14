<script setup lang="ts">
import ScrollReveal from '@/components/ScrollReveal.vue';
import PaginationLink from '@/components/PaginationLink.vue'; // Import komponen pagination
import Layout from '@/layouts/UserAppLayout.vue';
import { Image as ImageIcon, X, ZoomIn } from 'lucide-vue-next';
import { ref } from 'vue';

// Definisi Tipe Data Foto (Updated untuk Pagination)
interface PhotoItem {
    foto_id: string | number;
    url_foto: string;
}

// Interface untuk Props Pagination Laravel
interface PaginationProps {
    data: PhotoItem[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    current_page: number;
    from: number;
    to: number;
    total: number;
}

const props = defineProps<{
    photos: PaginationProps; // Ubah dari array biasa ke object pagination
}>();

// State untuk Lightbox
const selectedImage = ref<string | null>(null);
const breadcrumb = [{ label: 'Home', link: '/' }, { label: 'Galeri' }];

// Actions
function openLightbox(url: string) {
    selectedImage.value = url;
    document.body.style.overflow = 'hidden'; 
}

function closeLightbox() {
    selectedImage.value = null;
    document.body.style.overflow = ''; 
}
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Galeri Foto">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"></div>
        </div>

        <div class="relative container mx-auto min-h-[60vh] px-4 py-10 sm:px-6 lg:px-8">
            <ScrollReveal animation="fade-up" :duration="500">
                <div
                    v-if="photos.data && photos.data.length > 0"
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <div
                        v-for="item in photos.data"
                        :key="item.foto_id"
                        class="group relative aspect-[4/3] cursor-pointer overflow-hidden rounded-2xl bg-slate-200 shadow-md transition-all duration-500 hover:shadow-xl hover:shadow-[#99cc33]/20"
                        @click="openLightbox(item.url_foto)"
                    >
                        <img
                            :src="item.url_foto"
                            :alt="'Galeri Foto ' + item.foto_id"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            loading="lazy"
                        />

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity delay-75 duration-300 group-hover:opacity-100">
                            <div class="rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-sm">
                                <ZoomIn class="h-6 w-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="flex flex-col items-center justify-center py-24 text-center"
                >
                    <div class="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <ImageIcon class="h-10 w-10" />
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-slate-700">
                        Belum Ada Foto
                    </h3>
                    <p class="max-w-md text-slate-500">
                        Saat ini belum ada foto yang diunggah ke dalam galeri.
                        Silakan kembali lagi nanti.
                    </p>
                </div>
            </ScrollReveal> 

            <div v-if="photos.data.length > 0 && photos.total > photos.data.length" class="mt-12 flex flex-col items-center justify-center gap-4 border-t border-slate-200 pt-8 sm:flex-row sm:justify-between">
                <div class="text-sm font-medium text-slate-500 bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm">
                    Menampilkan <span class="font-bold text-[#99cc33]">{{ photos.from }}</span> - <span class="font-bold text-[#99cc33]">{{ photos.to }}</span> dari <span class="font-bold text-slate-800">{{ photos.total }}</span> foto
                </div>

                <nav class="isolate inline-flex -space-x-px rounded-xl shadow-sm bg-white p-1 border border-slate-100">
                    <PaginationLink
                        v-for="(link, index) in photos.links"
                        :key="index"
                        :link="link"
                    />
                </nav>
            </div>

            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selectedImage"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/95 p-4 backdrop-blur-sm sm:p-8"
                    @click="closeLightbox"
                >
                    <button
                        class="absolute top-6 right-6 z-10 rounded-full bg-white/10 p-2 text-white transition-colors hover:bg-white/20 focus:outline-none"
                        @click.stop="closeLightbox"
                    >
                        <X class="h-8 w-8" />
                    </button>

                    <div
                        class="relative flex max-h-full w-full max-w-5xl flex-col items-center justify-center"
                        @click.stop
                    >
                        <img
                            :src="selectedImage"
                            alt="Preview Galeri"
                            class="max-h-[85vh] w-auto rounded-lg object-contain shadow-2xl"
                        />
                    </div>
                </div>
            </transition>
        </div>
    </Layout>
</template>