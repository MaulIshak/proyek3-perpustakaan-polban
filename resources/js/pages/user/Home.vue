<script setup lang="js">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import HeroSection from '@/components/HeroSection.vue';
import PengumumanCard from '@/components/PengumumanCard.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { ref } from 'vue';

const breadcrumbs = [{ label: 'Home', link: '/' }];
const pengumumanList = [
    {
        id: 1,
        title: 'Libur Perpustakaan pada Hari Raya Imlek 2025',
        content:
            '<p>UPT Perpustakaan POLBAN akan tutup pada tanggal 29 Januari 2025 dalam rangka perayaan Imlek.</p>',
        date: '2025-01-20',
    },
    {
        id: 2,
        title: 'Perubahan Jam Operasional Perpustakaan Selama Ujian Akhir Semester',
        content:
            '<p>Selama periode ujian akhir semester, jam operasional perpustakaan akan diperpanjang hingga pukul 22.00 WIB.</p>',
        date: '2025-01-15',
    },
    {
        id: 2,
        title: 'Perubahan Jam Operasional Perpustakaan Selama Ujian Akhir Semester',
        content:
            '<p>Selama periode ujian akhir semester, jam operasional perpustakaan akan diperpanjang hingga pukul 22.00 WIB.</p>',
        date: '2025-01-15',
    },
];

// Tab aktif
const activeTab = ref('berita');
</script>

<template>
    <UserAppLayout
        :page="false"
        title="HOME"
        subtitle=""
        :breadcrumb="breadcrumbs"
    >
        <!-- HERO -->
  

        <!-- SECTION TAB -->
        <section
            class="flex min-h-[60vh] flex-col items-center justify-center bg-gray-50 px-4 py-12 sm:px-10"
        >
            <div class="w-full">
                <!-- TABS -->
                <div
                    class="tabs-container flex gap-3 overflow-x-auto pb-2 sm:gap-5"
                >
                    <button
                        v-for="tab in [
                            {
                                key: 'berita',
                                label: 'Berita Terbaru',
                                icon: '',
                            },
                            {
                                key: 'pengumuman',
                                label: 'Pengumuman Terbaru',
                                icon: '',
                            },
                            {
                                key: 'buku',
                                label: 'Koleksi Terbaru',
                                icon: 'Book',
                            },
                        ]"
                        :key="tab.key"
                        @click="activeTab = tab.key"
                        :class="[
                            'tab text-md flex-shrink-0 px-4 py-2 sm:px-6 sm:text-lg',
                            activeTab === tab.key ? 'active' : '',
                        ]"
                    >
                        {{ tab.label }}
                    </button>
                </div>

                <!-- TAB CONTENT -->
                <div class="tab-content rounded-b-2xl">
                    <BeritaHighlight v-if="activeTab === 'berita'" />
                    <BookCovers v-else-if="activeTab === 'buku'" />
                    <div v-else-if="activeTab == 'pengumuman'" class="py-16">
                        <div class="mb-8 flex items-center justify-between">
                            <div class="inline-block">
                                <h2
                                    class="relative text-3xl font-bold text-[var(--dark-green)]"
                                >
                                    Pengumuman Terbaru
                                </h2>
                                <span
                                    class="mt-1 block h-1 w-16 rounded-full bg-[var(--primary-green)]"
                                ></span>
                            </div>
                            <a
                                class="flex w-35 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                                href="/berita"
                                data-discover="true"
                                >Lihat Semua<svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path></svg
                            ></a>
                        </div>
                        <PengumumanCard
                            v-for="pengumuman in pengumumanList"
                            :key="pengumuman.id"
                            :title="pengumuman.title"
                            :content="pengumuman.content"
                            :date="pengumuman.date"
                        />
                    </div>
                    <div
                        class="mx-auto mt-10 mb-8 max-w-7xl px-4 sm:px-6 lg:px-8"
                    ></div>
                </div>
            </div>
        </section>
    </UserAppLayout>
</template>

<style scoped>
.tabs-container {
    display: flex;
    position: relative;
    z-index: 10;
    scrollbar-width: none;
}
.tabs-container::-webkit-scrollbar {
    display: none;
}

.tab {
    position: relative;
    background: #99cc33;
    color: #f3fff3;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}

.tab:hover {
    background: #99cc33;
}

.tab.active {
    background: white;
    color: #99cc33;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 20;
}

.tab-content {
    min-height: 300px;
    border-top: 2px solid #99cc33;
}
</style>
