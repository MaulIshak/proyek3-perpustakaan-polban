<script setup lang="js">
import BeritaHighlight from '@/components/BeritaHighlight.vue';
import BookCovers from '@/components/BookCovers.vue';
import HeroSection from '@/components/HeroSection.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { ref } from 'vue';

const breadcrumbs = [{ label: 'Home', link: '/' }];

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
        <HeroSection />

        <!-- SECTION TAB -->
   <section
    class="flex min-h-[60vh] flex-col items-center justify-center bg-gray-50 px-4 sm:px-10 py-12"
>
    <div class="w-full">
        <!-- TABS -->
        <div class="tabs-container flex gap-3 sm:gap-5 overflow-x-auto pb-2">
            <button
                v-for="tab in [
                    { key: 'berita', label: 'Berita Terbaru', icon: '' },
                    { key: 'pengumuman', label: 'Pengumuman Terbaru', icon: '' },
                    { key: 'buku', label: 'Koleksi Terbaru', icon: 'Book' },
                ]"
                :key="tab.key"
                @click="activeTab = tab.key"
                :class="[
                    'tab flex-shrink-0 px-4 sm:px-6 py-2 text-sm sm:text-base',
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
