<script setup>
import Layout from '@/layouts/UserAppLayout.vue';
import { X, Maximize2, Camera, ImageOff, ZoomIn } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    photos: Object,
});

const selectedImage = ref(null);
const breadcrumb = [{ label: 'Profil' }, { label: 'Galeri Perpustakaan' }];

// Menutup lightbox dengan tombol ESC
const handleKeydown = (e) => {
    if (e.key === 'Escape') selectedImage.value = null;
};

onMounted(() => window.addEventListener('keydown', handleKeydown));
onUnmounted(() => window.removeEventListener('keydown', handleKeydown));
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Galeri Foto">
        <div class="min-h-screen bg-[#f3fff3] py-10 font-sans">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="mb-10 text-center space-y-3 animate-fade-in-up">
                    <h1 class="text-3xl font-extrabold text-[#0f3800] tracking-tight flex items-center justify-center gap-3">
                        <Camera class="w-8 h-8 text-[#99cc33]" /> Galeri Aktivitas
                    </h1>
                    <p class="mt-2 text-gray-600 max-w-2xl mx-auto text-base">
                        Dokumentasi kegiatan, fasilitas, dan momen-momen berharga di lingkungan Perpustakaan Politeknik Negeri Bandung.
                    </p>
                    <div class="h-1 w-24 bg-gradient-to-r from-transparent via-[#99cc33] to-transparent mx-auto rounded-full mt-4"></div>
                </div>

                <div v-if="photos.length > 0" class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6 animate-fade-in-up delay-100">
                    <div
                        v-for="(item, index) in photos"
                        :key="item.foto_id"
                        class="group relative break-inside-avoid rounded-2xl overflow-hidden bg-white border border-[#99cc33]/20 shadow-sm hover:shadow-xl transition-all duration-500 cursor-zoom-in transform hover:-translate-y-1"
                        @click="selectedImage = item.url_foto"
                    >
                        <img
                            :src="item.url_foto"
                            :alt="'Dokumentasi ' + index"
                            loading="lazy"
                            class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-110"
                        />

                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f3800]/90 via-[#0f3800]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-0 group-hover:scale-100 transition-transform duration-300 delay-100 bg-white/20 backdrop-blur-sm p-3 rounded-full text-white">
                                <Maximize2 class="w-6 h-6" />
                            </div>

                            <span class="translate-y-4 group-hover:translate-y-0 transition-transform duration-300 text-white font-medium text-sm">
                                Lihat Foto Lebih Jelas
                            </span>
                        </div>
                        
                        <div class="absolute inset-0 border-2 border-[#99cc33] opacity-0 group-hover:opacity-100 rounded-2xl pointer-events-none transition-opacity duration-300"></div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center justify-center py-20 animate-fade-in-up">
                    <div class="w-32 h-32 bg-[#e6ffe6] rounded-full flex items-center justify-center mb-6 border-2 border-[#99cc33]/30 border-dashed">
                        <ImageOff class="w-12 h-12 text-[#99cc33]" />
                    </div>
                    <h3 class="text-xl font-bold text-[#0f3800]">Belum ada foto</h3>
                    <p class="text-gray-500 mt-2">Galeri foto akan segera diperbarui.</p>
                </div>
            </div>

            <Transition name="fade">
                <div
                    v-if="selectedImage"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-8 bg-[#0f3800]/90 backdrop-blur-md"
                    @click="selectedImage = null"
                >
                    <button
                        class="absolute top-6 right-6 p-2 bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors z-50 focus:outline-none"
                        @click.stop="selectedImage = null"
                    >
                        <X class="w-8 h-8" />
                    </button>

                    <div 
                        class="relative max-w-5xl w-full max-h-full flex items-center justify-center"
                        @click.stop
                    >
                        <img
                            :src="selectedImage"
                            alt="Full Preview"
                            class="max-h-[85vh] w-auto max-w-full rounded-lg shadow-2xl border-4 border-white object-contain animate-scale-up"
                        />
                    </div>
                </div>
            </Transition>
        </div>
    </Layout>
</template>

<style scoped>
/* Animasi Fade In Up untuk konten halaman */
.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}

.delay-100 {
    animation-delay: 0.1s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animasi Transisi Modal Vue */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Animasi Gambar saat Modal Muncul */
.animate-scale-up {
    animation: scaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes scaleUp {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>