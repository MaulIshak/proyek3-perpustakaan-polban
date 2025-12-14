<script setup lang="ts">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import PengumumanCard from '@/components/PengumumanCard.vue';
import ScrollReveal from '@/components/ScrollReveal.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { BookOpen, Megaphone, Newspaper } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs = [{ label: 'Home', link: '/' }];

const props = defineProps({
    book_covers: { type: Array<any>, default: [] },
    latest_news: { type: Array<any>, default: [] },
    latest_announcements: { type: Array<any>, default: [] },
});

const tabs = [
    {
        key: 'berita',
        labelTop: 'Berita',
        labelBottom: 'Terbaru',
        fullLabel: 'Berita Terbaru',
        icon: Newspaper,
    },
    {
        key: 'pengumuman',
        labelTop: 'Pengumuman',
        labelBottom: 'Terbaru',
        fullLabel: 'Pengumuman',
        icon: Megaphone,
    },
    {
        key: 'buku',
        labelTop: 'Koleksi',
        labelBottom: 'Terbaru',
        fullLabel: 'Koleksi Terbaru',
        icon: BookOpen,
    },
];

const activeTab = ref('berita');
</script>

<template>
    <UserAppLayout
        :page="false"
        title="HOME"
        subtitle=""
        :breadcrumb="breadcrumbs"
    >
        <section
            class="relative min-h-[85vh] overflow-hidden px-4 pt-6 pb-24 sm:px-6 lg:px-8"
        >
            <div class="relative z-10 container mx-auto max-w-7xl">
                <ScrollReveal animation="fade-up" :delay="100">
                    <div class="mb-10">
                        <div
                            class="grid grid-cols-3 gap-2 md:flex md:flex-wrap md:justify-center md:gap-3"
                        >
                            <button
                                v-for="tab in tabs"
                                :key="tab.key"
                                @click="activeTab = tab.key"
                                class="group relative overflow-hidden transition-all duration-300"
                                :class="[
                                    // === STYLE MOBILE (Kotak Vertikal) ===
                                    'flex h-20 flex-col items-center justify-center rounded-xl border px-1 py-3 shadow-sm',

                                    // === STYLE DESKTOP (Pil Horizontal - Override Mobile) ===
                                    'md:h-auto md:flex-row md:gap-2 md:rounded-full md:px-6 md:py-3 md:shadow-sm',

                                    // === LOGIKA WARNA (Active / Inactive) ===
                                    activeTab === tab.key
                                        ? 'border-[#99cc33] bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/30' // Aktif: Hijau Solid
                                        : 'border-slate-200 bg-white text-slate-500 hover:border-[#99cc33] hover:text-[#99cc33]', // Tidak Aktif
                                ]"
                            >
                                <component
                                    :is="tab.icon"
                                    class="mb-1 h-5 w-5 md:mb-0 md:h-5 md:w-5"
                                />

                                <div class="text-center leading-[1.1]">
                                    <div
                                        class="block text-[11px] font-bold md:hidden"
                                    >
                                        {{ tab.labelTop }}
                                        <div
                                            v-if="tab.labelBottom"
                                            class="block"
                                        >
                                            {{ tab.labelBottom }}
                                        </div>
                                    </div>

                                    <div class="hidden font-bold md:block">
                                        {{ tab.fullLabel }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </ScrollReveal>

                <div class="min-h-[400px]">
                    <transition name="fade-slide" mode="out-in">
                        <div v-if="activeTab === 'berita'" key="berita">
                            <ScrollReveal animation="fade-up" :duration="500">
                                <BeritaHighlight :articles="latest_news" />
                            </ScrollReveal>
                        </div>

                        <div
                            v-else-if="activeTab === 'pengumuman'"
                            key="pengumuman"
                            class="mx-auto max-w-5xl"
                        >
                            <ScrollReveal
                                animation="fade-in"
                                class="mb-6 flex items-center justify-between border-b border-slate-100 pb-4"
                            >
                <div>
                    <div class="mb-2 flex items-center gap-3">
                        <div
                            class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                        >
                            <Newspaper class="h-6 w-6" />
                        </div>
                        <h2
                            class="text-3xl font-black tracking-tight text-slate-900"
                        >
                            Pengumuman Terbaru
                        </h2>
                    </div>
                    <div
                        class="ml-1 h-1.5 w-24 rounded-full bg-[#99cc33] shadow-sm shadow-[#99cc33]/50"
                    ></div>
                </div>
                            </ScrollReveal>
                            <div class="grid gap-4">
                                <template
                                    v-for="(
                                        pengumuman, index
                                    ) in latest_announcements"
                                    :key="pengumuman.article_id"
                                >
                                    <ScrollReveal
                                        animation="fade-up"
                                        :delay="index * 100"
                                    >
                                        <PengumumanCard
                                            :id="pengumuman.article_id"
                                            :title="pengumuman.judul"
                                            :content="pengumuman.content"
                                            :date="pengumuman.created_date"
                                            class="transition-shadow duration-300 hover:shadow-lg"
                                        />
                                    </ScrollReveal>
                                </template>
                            </div>
                        </div>

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
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(15px);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-15px);
}
</style>
