<script setup lang="ts">
import Header from '@/components/admin/Header.vue';
import Sidebar from '@/components/admin/Sidebar.vue';
import { ref } from 'vue';

const sidebarOpen = ref(true);
const profileMenuOpen = ref(false);

const toggleSidebar = () => (sidebarOpen.value = !sidebarOpen.value);
const toggleProfileMenu = () =>
    (profileMenuOpen.value = !profileMenuOpen.value);
</script>

<template>
    <div class="flex h-screen bg-gray-50 text-gray-800">
        <Sidebar :sidebar-open="sidebarOpen" />

        <div class="flex flex-1 flex-col">
            <Header
                :sidebar-open="sidebarOpen"
                :profile-menu-open="profileMenuOpen"
                @toggle-sidebar="toggleSidebar"
                @toggle-profile-menu="toggleProfileMenu"
            />

            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
