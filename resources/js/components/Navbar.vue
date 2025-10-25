<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';

defineProps({
    title: String,
});

const navItems = [
    { name: 'Home', href: '/' },
    {
        name: 'Profil',
        items: [
            { name: 'Tentang Perpustakaan', href: '/about' },
            { name: 'Fasilitas', href: '/facilities' },
        ],
    },
    {
        name: 'Pelayanan',
        items: [
            { name: 'Layanan 1', href: '/service-1' },
            { name: 'Layanan 2', href: '/service-2' },
        ],
    },
    {
        name: 'Koleksi',
        items: [
            { name: 'Buku', href: '/books' },
            { name: 'Jurnal', href: '/journals' },
        ],
    },
    {
        name: 'Berita & Pengumuman',
        items: [
            { name: 'Berita', href: '/news' },
            { name: 'Pengumuman', href: '/announcements' },
        ],
    },
    { name: 'Bebas Masalah', href: '/no-problem' },
    { name: 'Galeri', href: '/gallery' },
    { name: 'Booking Buku', href: '/book-reservation' },
    { name: 'Kontak', href: '/contact' },
];

const page = usePage();
const currentUrl = page.url;

// custom dropdown state: index of open menu, null = none
const openIndex = ref<number | null>(null);

function toggleMenu(i: number) {
    openIndex.value = openIndex.value === i ? null : i;
}

function closeAll() {
    openIndex.value = null;
}

function onDocumentClick(e: MouseEvent) {
    // close menus on outside click
    const target = e.target as HTMLElement | null;
    if (!target) return;
    // if click inside a menu button or menu, do nothing
    if (target.closest('.navbar-dropdown')) return;
    closeAll();
}

function onEsc(e: KeyboardEvent) {
    if (e.key === 'Escape') closeAll();
}

onMounted(() => {
    document.addEventListener('click', onDocumentClick, true);
    document.addEventListener('keydown', onEsc);
});

onUnmounted(() => {
    document.removeEventListener('click', onDocumentClick, true);
    document.removeEventListener('keydown', onEsc);
});
</script>

<template>
    <nav class="bg-white/95 py-3 text-[var(--font-green)] backdrop-blur-md">
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-3">
                    <img
                        src="logo-polban-hijau.webp"
                        alt="Logo"
                        class="h-12 w-12"
                    />

                    <div>
                        <h1 class="text-lg font-extrabold">
                            UPT Perpustakaan POLBAN
                        </h1>
                        <p class="text-sm text-gray-600">
                            NPP: 3270130B1000002
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-7">
                    <template v-for="(item, i) in navItems" :key="item.name">
                        <!-- plain link -->
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="text-md rounded-full p-2 font-medium hover:text-[var(--font-green)]"
                            :class="[
                                item.href === currentUrl
                                    ? 'bg-[var(--background-green)] text-[var(--font-green)]'
                                    : 'text-gray-700',
                            ]"
                        >
                            {{ item.name }}
                        </Link>

                        <!-- custom dropdown (no scroll lock) -->
                        <div
                            v-else
                            class="navbar-dropdown relative"
                            @click.stop
                        >
                            <button
                                @click="toggleMenu(i)"
                                class="text-md flex items-center gap-1 rounded-full p-2 font-medium text-gray-700 transition-colors hover:text-[var(--font-green)]"
                                :aria-expanded="
                                    openIndex === i ? 'true' : 'false'
                                "
                                :aria-haspopup="true"
                            >
                                <span>{{ item.name }}</span>
                                <ChevronDown class="h-4 w-4" />
                            </button>

                            <ul
                                v-show="openIndex === i"
                                class="absolute z-50 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none"
                            >
                                <li
                                    v-for="subItem in item.items"
                                    :key="subItem.name"
                                    class="p-3 hover:bg-[var(--background-green)]"
                                >
                                    <Link
                                        :href="subItem.href"
                                        class="block text-sm text-gray-700"
                                        @click="closeAll"
                                    >
                                        {{ subItem.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
