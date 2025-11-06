<script setup lang="ts">
import Header from '@/components/admin/Header.vue';
import Sidebar from '@/components/admin/Sidebar.vue';
import { ref } from 'vue';

const sidebarOpen = ref(true);
const profileMenuOpen = ref(false);

const toggleSidebar = () => (sidebarOpen.value = !sidebarOpen.value);
const toggleProfileMenu = () =>
    (profileMenuOpen.value = !profileMenuOpen.value);

defineProps<{
    title?: string;
    subTitle?: string;
}>();
</script>

<template>
    <div class="flex h-screen bg-gray-50 text-gray-800">
        <Sidebar :sidebar-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />

        <div class="flex flex-1 flex-col">
            <Header
                :sidebar-open="sidebarOpen"
                :profile-menu-open="profileMenuOpen"
                :title="title"
                :sub-title="subTitle"
                @toggle-profile-menu="toggleProfileMenu"
            />

            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
