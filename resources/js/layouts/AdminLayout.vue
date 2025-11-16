<script setup lang="ts">
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import Header from '@/components/admin/Header.vue';
import Sidebar from '@/components/admin/Sidebar.vue';
import { computed, ref } from 'vue';

const sidebarOpen = ref(true);
const profileMenuOpen = ref(false);

const toggleSidebar = () => (sidebarOpen.value = !sidebarOpen.value);
const toggleProfileMenu = () =>
    (profileMenuOpen.value = !profileMenuOpen.value);

defineProps<{
    title?: string;
    subTitle?: string;
}>();

// Lebar sidebar untuk animasi dan pergeseran konten
const sidebarWidth = computed(() => (sidebarOpen.value ? 256 : 80)); // px
</script>

<template>
    <div class="relative h-screen overflow-hidden bg-gray-50 text-gray-800">
        <!-- HEADER (full width, background tetap) -->
        <div class="relative z-0">
            <Header
                :sidebar-open="sidebarOpen"
                :profile-menu-open="profileMenuOpen"
                :title="title"
                :sub-title="subTitle"
                @toggle-profile-menu="toggleProfileMenu"
                class=""
            />
        </div>

        <!-- SIDEBAR (mengambang, menutupi sebagian header) -->
        <Sidebar
            :sidebar-open="sidebarOpen"
            @toggle-sidebar="toggleSidebar"
            class="absolute top-11 left-0 z-30 transition-all duration-300"
            :style="{
                width: sidebarOpen ? '256px' : '80px',

                marginTop: '20px',
            }"
        />

        <!-- TOMBOL TOGGLE DI ATAS SIDEBAR (area header bagian atas) -->
        <button
            @click="toggleSidebar"
            class="absolute top-4 left-4 z-40 rounded-md bg-[var(--dark-green)]/80 p-2 text-white shadow-md transition hover:bg-[var(--primary-green)]"
        >
            <svg
                v-if="!sidebarOpen"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>

        <!-- KONTEN (bergeser ketika sidebar expand) -->
        <main
            class="relative z-10 mt-[-60px] h-[calc(100%-60px)] overflow-y-auto p-6 transition-all duration-300"
            :style="{ marginLeft: sidebarWidth + 'px' }"
        >
            <div class="relative bottom-8">
                <h1 class="text-3xl font-bold text-white">{{ title }}</h1>
                <p class="text-gray-200">{{ subTitle }}</p>
            </div>
            <slot />
        </main>
        <ConfirmModal />
    </div>
</template>
