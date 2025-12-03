<script setup lang="ts">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import PengumumanCard from '@/components/PengumumanCard.vue';
import ScrollReveal from '@/components/ScrollReveal.vue'; // Import komponen baru
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { ArrowRight, BookOpen, Megaphone, Newspaper } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs = [{ label: 'Home', link: '/' }];

const props = defineProps({
    book_covers: {
        type: Array<{
            id: Number;
            title: string;
            image_path: string;
            created_at: Date;
            updated_at: Date;
        }>,
        default: [],
    },
    latest_news: {
        type: Array<{
            article_id: string;
            url_thumbnail: string | null;
            judul: string;
            content: string;
            created_date: string;
        }>,
        default: [],
    },
    latest_announcements: {
        type: Array<{
            article_id: string;
            judul: string;
            content: string;
            created_date: string;
        }>,
        default: [],
    },
});

// Konfigurasi Tab
const tabs = [
    { key: 'berita', label: 'Berita Terbaru', icon: Newspaper },
    { key: 'pengumuman', label: 'Pengumuman', icon: Megaphone },
    { key: 'buku', label: 'Koleksi Terbaru', icon: BookOpen },
];

// State
const activeTab = ref('berita');
</script>

<template>
    <UserAppLayout
        :page="false"
        title="HOME"
        subtitle=""
        :breadcrumb="breadcrumbs"
    >
        <!-- 2. Main Content Section -->
        <section
            class="relative min-h-[80vh] overflow-hidden px-4 pt-6 pb-16 sm:px-6 lg:px-8"
        >
            <div class="relative z-10 container mx-auto max-w-7xl">

                <!-- Tabs Navigation dengan Scroll Reveal -->
                <ScrollReveal animation="fade-up" :delay="100">
                    <div class="mb-12 flex flex-wrap justify-center gap-3">
                        <button
                            v-for="tab in tabs"
                            :key="tab.key"
                            @click="activeTab = tab.key"
                            class="flex items-center gap-2 rounded-full border px-6 py-3 font-bold shadow-sm transition-all duration-300"
                            :class="
                                activeTab === tab.key
                                    ? 'scale-105 border-[#99cc33] bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/30'
                                    : 'border-slate-200 bg-white text-slate-600 hover:border-[#99cc33]/50 hover:bg-[#99cc33]/5 hover:text-[#99cc33]'
                            "
                        >
                            <component :is="tab.icon" class="h-5 w-5" />
                            {{ tab.label }}
                        </button>
                    </div>
                </ScrollReveal>

                <!-- Tab Content Area with Transition -->
                <div class="min-h-[400px]">
                    <transition name="fade-slide" mode="out-in">
                        <!-- CONTENT: BERITA -->
                        <div v-if="activeTab === 'berita'" key="berita">
                            <ScrollReveal animation="fade-up" :duration="500">
                                <BeritaHighlight :articles="latest_news" />
                            </ScrollReveal>
                        </div>

                        <!-- CONTENT: PENGUMUMAN -->
                        <div
                            v-else-if="activeTab === 'pengumuman'"
                            key="pengumuman"
                            class="mx-auto max-w-5xl"
                        >
                            <ScrollReveal animation="fade-in" class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                                <div>
                                    <h2
                                        class="mb-2 text-3xl font-black tracking-tight text-slate-800"
                                    >
                                        Pengumuman Terbaru
                                    </h2>
                                    <div
                                        class="h-1.5 w-20 rounded-full bg-[#99cc33]"
                                    ></div>
                                </div>

                                <a
                                    href="/pengumuman"
                                    class="group flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:border-[#99cc33] hover:text-[#99cc33]"
                                >
                                    Lihat Semua
                                    <ArrowRight
                                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                                    />
                                </a>
                            </ScrollReveal>

                            <div class="grid gap-6">
                                <template v-for="(pengumuman, index) in latest_announcements" :key="pengumuman.article_id">
                                    <ScrollReveal animation="slide-left" :delay="index * 100">
                                        <PengumumanCard
                                            :id="pengumuman.article_id"
                                            :title="pengumuman.judul"
                                            :content="pengumuman.content"
                                            :date="pengumuman.created_date"
                                            class="transform border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                                        />
                                    </ScrollReveal>
                                </template>
                            </div>
                        </div>

                        <!-- CONTENT: BUKU -->
                        <div v-else-if="activeTab === 'buku'" key="buku">
                            <ScrollReveal animation="zoom-in" :duration="600">
                                <BookCovers :data="book_covers" />
                            </ScrollReveal>
                        </div>
                    </transition>
                </div>
            </div>
        </section>
    </UserAppLayout>
</template>

<style scoped>
/* Animasi transisi custom yang lebih modern */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease-out;
}

.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>
