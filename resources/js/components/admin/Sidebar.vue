<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { LogOut, PanelLeft, X } from 'lucide-vue-next';
import SidebarLink from './SidebarLink.vue';

defineProps({
    sidebarOpen: Boolean,
});

const emit = defineEmits(['toggle-sidebar']);
</script>

<template>
    <aside
        :class="[
            'flex flex-col rounded-br-2xl bg-[var(--background-green)] shadow-sm transition-all duration-300',
            sidebarOpen ? 'w-64' : 'w-20',
        ]"
    >
        <!-- Header Logo -->
        <div
            class="flex min-h-20 items-center justify-between gap-3 border-b p-4"
        >
            <div v-if="sidebarOpen" class="flex items-center gap-3">
                <div>
                    <h1
                        class="text-md font-bold whitespace-nowrap text-[var(--dark-green)]"
                    >
                        Perpustakaan POLBAN
                    </h1>
                    <h3 class="text-sm text-[var(--secondary-green)]">
                        Pustakawan
                    </h3>
                </div>
            </div>
            <button
                @click="emit('toggle-sidebar')"
                class="rounded-lg p-2 transition hover:bg-gray-100"
            >
                <X v-if="sidebarOpen" class="text-2xl text-gray-700" />
                <PanelLeft v-else class="text-2xl text-gray-700" />
            </button>
        </div>

        <!-- Navigation -->
        <nav
            class="flex-1 space-y-4 overflow-hidden overflow-y-auto p-3 text-sm font-medium"
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
                        class="mb-2 px-2 text-xs font-semibold text-wrap whitespace-nowrap text-[var(--secondary-green)] uppercase"
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
                        class="mb-2 px-2 text-xs font-semibold text-wrap whitespace-nowrap text-[var(--secondary-green)] uppercase"
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
                        class="mb-2 px-2 text-xs font-semibold text-wrap whitespace-nowrap text-[var(--secondary-green)] uppercase"
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
                    label="E-Journal"
                    to="/admin/e-journal"
                    :sidebar-open="sidebarOpen"
                />
            </div>

            <!-- Divider sebelum logout -->
            <hr class="my-2 border-[var(--secondary-green)] opacity-40" />

            <!-- Logout -->
            <Link
                href="/admin/logout"
                method="post"
                as="button"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-red-500 transition hover:bg-red-500 hover:text-black"
            >
                <LogOut class="w-5" />
                <span v-if="sidebarOpen">Keluar</span>
            </Link>
        </nav>
    </aside>
</template>
