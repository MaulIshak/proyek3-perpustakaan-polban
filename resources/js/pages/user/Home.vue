<script setup lang="ts">
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
            class="flex min-h-[60vh] flex-col items-center justify-center bg-gray-50 px-10 py-12"
        >
            <div class="w-full px-10">
                <!-- TABS -->
                <div class="tabs-container flex">
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
                            { key: 'buku', label: 'Koleksi Terbaru', icon: '' },
                        ]"
                        :key="tab.key"
                        @click="activeTab = tab.key"
                        :class="['tab', activeTab === tab.key ? 'active' : '']"
                    >
                        <span class="mr-2">{{ tab.icon }}</span>
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
}

.tab {
    position: relative;
    padding: 1rem 2rem;
    background: #99cc33;
    color: #f3fff3;
    font-weight: 500;
    cursor: pointer;
    clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
    transition: all 0.3s ease;
    margin-right: -10px;
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
