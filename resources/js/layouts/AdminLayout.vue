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

const sidebarWidth = computed(() => (sidebarOpen.value ? 256 : 80));
</script>

<template>
    <div class="relative flex h-screen flex-col overflow-hidden bg-gray-50 text-gray-800">

        <div class="relative z-20 shrink-0">
            <Header
                :sidebar-open="sidebarOpen"
                :profile-menu-open="profileMenuOpen"
                :title="title"
                :sub-title="subTitle"
                @toggle-profile-menu="toggleProfileMenu"
            />
        </div>

        <Sidebar
            :sidebar-open="sidebarOpen"
            @toggle-sidebar="toggleSidebar"
            class="absolute top-11 left-0 z-50 transition-all duration-300"
            :style="{
                width: sidebarOpen ? '256px' : '80px',
                marginTop: '20px',
            }"
        />

        <button
            @click="toggleSidebar"
            class="absolute top-4 left-4 z-50 rounded-md bg-[var(--dark-green)]/80 p-2 text-white shadow-md transition hover:bg-[var(--primary-green)]"
        >
            <svg v-if="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div
            class="absolute top-0 z-30 flex h-40 flex-col justify-end pb-8 pl-8 pr-8 transition-all duration-300 pointer-events-none"
            :style="{ marginLeft: sidebarWidth + 'px', width: `calc(100% - ${sidebarWidth}px)` }"
        >
            <div class="pointer-events-auto">
                <h1 class="text-3xl font-bold text-white">{{ title }}</h1>
                <p class="text-gray-200">{{ subTitle }}</p>
            </div>
        </div>

        <main
            class="relative z-10 flex-1 overflow-y-auto p-6 pb-16 transition-all duration-300"
            :style="{ marginLeft: sidebarWidth + 'px' }"
        >
            <slot />
        </main>

        <ConfirmModal />
    </div>
</template>
