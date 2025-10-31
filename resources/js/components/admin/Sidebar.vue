<script setup lang="ts">
import SidebarLink from './SidebarLink.vue';

defineProps({
    sidebarOpen: Boolean,
});
</script>

<template>
    <aside
        :class="[
            'flex flex-col bg-white shadow-sm transition-all duration-300',
            sidebarOpen ? 'w-64' : 'w-20',
        ]"
    >
        <!-- Logo -->
        <div class="flex min-h-20 items-center gap-3 border-b p-4">
            <img
                src="/logo-polban.webp"
                alt="Logo"
                class="h-10 w-10 rounded-lg bg-emerald-500 p-1"
            />
            <div v-if="sidebarOpen">
                <h1
                    class="text-md font-bold whitespace-nowrap text-emerald-500"
                >
                    Perpustakaan POLBAN
                </h1>
                <h3 class="text-sm text-gray-500">Admin Panel</h3>
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 space-y-1 p-3 text-sm font-medium">
            <SidebarLink
                icon="LayoutDashboard"
                label="Dashboard"
                to="/admin/dashboard"
                :sidebar-open="sidebarOpen"
            />
            <SidebarLink
                icon="LayoutPanelTop"
                label="Page Builder"
                to="/admin/page-builder"
                :sidebar-open="sidebarOpen"
            />
            <SidebarLink
                icon="Newspaper"
                label="Berita"
                to="/admin/berita"
                :sidebar-open="sidebarOpen"
            />
            <SidebarLink
                icon="Megaphone"
                label="Pengumuman"
                to="/admin/pengumuman"
                :sidebar-open="sidebarOpen"
            />
            <SidebarLink
                icon="Image"
                label="Galeri"
                to="/admin/galeri"
                :sidebar-open="sidebarOpen"
            />
            <SidebarLink
                icon="Book"
                label="Usulan Buku"
                to="/admin/usulan-buku"
                :sidebar-open="sidebarOpen"
            />
        </nav>
    </aside>
</template>
