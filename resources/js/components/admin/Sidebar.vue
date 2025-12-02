<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import SidebarLink from './SidebarLink.vue';

defineProps({
    sidebarOpen: Boolean,
});

const emit = defineEmits(['toggle-sidebar']);
</script>

<template>
    <aside
        :class="[
            'flex h-[85dvh] flex-col rounded-r-2xl bg-[var(--background-green)]/80 shadow-sm backdrop-blur-xl transition-all duration-300',
            sidebarOpen ? 'w-64' : 'w-20',
        ]"
    >
        <!-- HEADER (FIXED TOP) -->
        <div
            class="flex shrink-0 items-center gap-3 border-b border-white/10 px-4 py-4"
        >
            <!-- Logo -->
            <img
                src="/logo-polban.png"
                alt="Polban"
                class="h-12 w-12 object-contain"
            />

            <!-- Title + Subtitle -->
            <div v-if="sidebarOpen" class="flex flex-col">
                <span
                    class="text-sm font-bold tracking-wide text-wrap whitespace-nowrap text-[var(--dark-green)]"
                >
                    PERPUSTAKAAN POLBAN
                </span>

                <span
                    class="text-[10px] font-medium tracking-wide text-wrap whitespace-nowrap text-gray-600"
                >
                    Laman Pustakawan
                </span>
            </div>
        </div>

        <!-- NAVIGATION LINKS (SCROLLABLE MIDDLE) -->
        <!-- Perubahan: scrollbar-hide dihapus, diganti custom-scrollbar -->
        <nav
            class="custom-scrollbar flex-1 space-y-4 overflow-hidden overflow-y-auto p-3 text-sm font-medium"
        >
            <!-- Group 1 -->
            <div>
                <template v-if="sidebarOpen">
                    <h2
                        class="mb-2 px-2 text-xs font-semibold text-[var(--secondary-green)] uppercase"
                    >
                        Umum
                    </h2>
                </template>

                <SidebarLink
                    icon="LayoutDashboard"
                    label="Dashboard"
                    to="/admin/dashboard"
                    :sidebar-open="sidebarOpen"
                />
            </div>

            <!-- Group 2 -->
            <div>
                <template v-if="sidebarOpen">
                    <h2
                        class="mb-2 px-2 text-xs font-semibold whitespace-nowrap text-[var(--secondary-green)] uppercase"
                    >
                        Konten & Informasi Publik
                    </h2>
                </template>
                <template v-else>
                    <hr
                        class="my-2 border-[var(--secondary-green)] opacity-40"
                    />
                </template>

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
                    icon="Handshake"
                    label="BebasMasalah"
                    to="/admin/bebas-masalah"
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

            <!-- Group 3 -->
            <div>
                <template v-if="sidebarOpen">
                    <h2
                        class="mb-2 px-2 text-xs font-semibold whitespace-nowrap text-[var(--secondary-green)] uppercase"
                    >
                        Layanan Perpustakaan
                    </h2>
                </template>
                <template v-else>
                    <hr
                        class="my-2 border-[var(--secondary-green)] opacity-40"
                    />
                </template>

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

            <!-- Group 4 -->
            <div>
                <template v-if="sidebarOpen">
                    <h2
                        class="mb-2 px-2 text-xs font-semibold whitespace-nowrap text-[var(--secondary-green)] uppercase"
                    >
                        Sumber Daya Digital
                    </h2>
                </template>
                <template v-else>
                    <hr
                        class="my-2 border-[var(--secondary-green)] opacity-40"
                    />
                </template>

                <SidebarLink
                    icon="BookImage"
                    label="Cover Buku"
                    to="/admin/cover-buku"
                    :sidebar-open="sidebarOpen"
                />
                <SidebarLink
                    icon="LibraryBig"
                    label="E-Journal & E-Book"
                    to="/admin/e-journals"
                    :sidebar-open="sidebarOpen"
                />
            </div>
        </nav>

        <!-- LOGOUT SECTION (FIXED BOTTOM) -->
        <div class="shrink-0 p-3">
            <!-- Divider sebelum logout -->
            <hr class="mb-2 border-[var(--secondary-green)] opacity-40" />

            <!-- Logout -->
            <Link
                href="/admin/logout"
                method="post"
                as="button"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-red-500 transition hover:bg-red-500 hover:text-black"
            >
                <LogOut class="w-5" />
                <span v-if="sidebarOpen">Keluar</span>
            </Link>
        </div>
    </aside>
</template>

<style scoped>
/* Webkit browsers (Chrome, Safari, Edge) */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px; /* Sangat tipis dan elegan */
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; /* Track transparan agar menyatu */
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: var(
        --secondary-green
    ); /* Menggunakan variabel warna yang sudah ada */
    border-radius: 20px;
    opacity: 0.5; /* Sedikit transparansi agar tidak mencolok */
}

.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background-color: var(--dark-green); /* Lebih gelap saat di-hover */
}

/* Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: var(--secondary-green) transparent;
}
</style>
