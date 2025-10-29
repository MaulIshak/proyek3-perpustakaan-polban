<script setup>
import { Link } from '@inertiajs/vue3';
import {
    Book,
    Image,
    LayoutDashboard,
    LayoutPanelTop,
    Megaphone,
    Menu,
    Newspaper,
    User,
} from 'lucide-vue-next';
import { ref } from 'vue';

const sidebarOpen = ref(true);
const profileMenuOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const toggleProfileMenu = () => {
    profileMenuOpen.value = !profileMenuOpen.value;
};
</script>

<template>
    <div class="flex h-screen bg-gray-50 text-gray-800">
        <!-- Sidebar -->
        <aside
            :class="[
                'flex flex-col bg-white shadow-sm transition-all duration-300',
                sidebarOpen ? 'w-64' : 'w-20',
            ]"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3 border-b p-4">
                <img
                    src="/logo-polban.webp"
                    alt="Logo"
                    class="h-10 w-10 rounded-lg bg-emerald-500 p-1"
                />
                <div v-if="sidebarOpen">
                    <h1
                        class="text-md font-bold whitespace-nowrap text-emerald-500"
                    >
                        UPT Perpustakaan
                    </h1>
                    <h3 class="text-sm text-gray-500">Admin Panel</h3>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 space-y-1 p-3 text-sm font-medium">
                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/dashboard',
                    }"
                    href="/admin/dashboard"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <LayoutDashboard
                        :class="{
                            'text-gray-100': $page.url === '/admin/dashboard',
                        }"
                        class="text-xl"
                    />
                    <span
                        v-if="sidebarOpen"
                        :class="{
                            'text-gray-100': $page.url === '/admin/dashboard',
                        }"
                        >Dashboard</span
                    >
                </Link>

                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/page-builder',
                    }"
                    href="/admin/page-builder"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <LayoutPanelTop class="text-xl" />
                    <span v-if="sidebarOpen">Page Builder</span>
                </Link>

                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/berita',
                    }"
                    href="/admin/berita"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <Newspaper class="text-xl" />
                    <span v-if="sidebarOpen">Berita</span>
                </Link>

                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/pengumuman',
                    }"
                    href="/admin/pengumuman"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <Megaphone class="text-xl" />
                    <span v-if="sidebarOpen">Pengumuman</span>
                </Link>

                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/galeri',
                    }"
                    href="/admin/galeri"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <Image class="text-xl" />
                    <span v-if="sidebarOpen">Galeri</span>
                </Link>

                <Link
                    :class="{
                        'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                            $page.url === '/admin/usulan-buku',
                    }"
                    href="/admin/usulan-buku"
                    class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
                >
                    <Book class="text-xl" />
                    <span v-if="sidebarOpen">Usulan Buku</span>
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-1 flex-col">
            <!-- Header -->
            <header
                class="flex items-center justify-between border-b bg-white px-6 py-3"
            >
                <div class="flex items-center gap-3">
                    <button
                        @click="toggleSidebar"
                        class="rounded-lg p-2 transition hover:bg-gray-100"
                    >
                        <Menu
                            class="text-2xl text-gray-700 transition-transform"
                            :class="{ 'rotate-180': !sidebarOpen }"
                        />
                    </button>
                    <h2 class="text-lg font-semibold">Dashboard</h2>
                </div>

                <div class="relative">
                    <button
                        @click="toggleProfileMenu"
                        class="flex items-center gap-2 rounded-full bg-emerald-500 px-3 py-1.5 text-white transition hover:bg-emerald-600"
                    >
                        <span class="text-sm font-medium">Admin</span>
                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-full bg-white/20"
                        >
                            <User></User>
                        </div>
                    </button>

                    <!-- Dropdown -->
                    <div
                        v-if="profileMenuOpen"
                        class="absolute right-0 mt-2 w-40 rounded-lg border bg-white py-1 text-sm shadow-md"
                    >
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                        >
                            Logout
                        </Link>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* @import '/resources/css/fonts/remixicon.css'; */
</style>
