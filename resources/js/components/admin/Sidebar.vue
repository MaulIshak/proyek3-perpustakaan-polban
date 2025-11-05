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
        <nav class="flex-1 space-y-4 overflow-y-auto p-3 text-sm font-medium">
            <!-- Group 1: Umum -->
            <div>
                <h2
                    v-if="sidebarOpen"
                    class="mb-2 px-2 text-xs font-semibold text-gray-400 uppercase"
                >
                    Umum
                </h2>
                <SidebarLink
                    icon="LayoutDashboard"
                    label="Dashboard"
                    to="/admin/dashboard"
                    :sidebar-open="sidebarOpen"
                />
            </div>

            <!-- Group 2: Konten & Informasi Publik -->
            <div>
                <h2
                    v-if="sidebarOpen"
                    class="mb-2 px-2 text-xs font-semibold text-wrap whitespace-nowrap text-gray-400 uppercase"
                >
                    Konten & Informasi Publik
                </h2>
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
                    icon="BookOpenCheck"
                    label="Rencana Strategis"
                    to="/admin/renstra"
                    :sidebar-open="sidebarOpen"
                />
                <SidebarLink
                    icon="Users"
                    label="Tim Manajemen"
                    to="/admin/tim-manajemen"
                    :sidebar-open="sidebarOpen"
                />
            </div>

            <!-- Group 3: Layanan Perpustakaan -->
            <div>
                <h2
                    v-if="sidebarOpen"
                    class="mb-2 px-2 text-xs font-semibold text-gray-400 uppercase"
                >
                    Layanan Perpustakaan
                </h2>
                <SidebarLink
                    icon="Book"
                    label="Usulan Buku"
                    to="/admin/usulan-buku"
                    :sidebar-open="sidebarOpen"
                />
                <SidebarLink
                    icon="BookMarked"
                    label="Booking Buku"
                    to="/admin/booking-buku"
                    :sidebar-open="sidebarOpen"
                />
            </div>

            <!-- Group 4: Sumber Daya Digital -->
            <div>
                <h2
                    v-if="sidebarOpen"
                    class="mb-2 px-2 text-xs font-semibold text-gray-400 uppercase"
                >
                    Sumber Daya Digital
                </h2>
                <SidebarLink
                    icon="BookImage"
                    label="Cover Buku"
                    to="/admin/cover-buku"
                    :sidebar-open="sidebarOpen"
                />
                <SidebarLink
                    icon="LibraryBig"
                    label="E-Journal"
                    to="/admin/e-journal"
                    :sidebar-open="sidebarOpen"
                />
            </div>
        </nav>
    </aside>
</template>
