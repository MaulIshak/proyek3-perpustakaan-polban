<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown, Menu, X } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref, watch } from 'vue';

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
            { name: 'Tim Manajemen', href: '/tim-manajemen' },
            { name: 'Peraturan Perpustakaan', href: '/peraturan' },
            { name: 'Jam Layanan', href: '/jam-layanan' },
        ],
    },
    {
        name: 'Pelayanan',
        items: [
            { name: 'Peminjaman Buku', href: '/pelayanan/peminjaman' },
            { name: 'Pengembalian Buku', href: '/pelayanan/pengembalian' },
            { name: 'Keanggotaan', href: '/pelayanan/keanggotaan' },
            { name: 'Pelayanan Referensi', href: '/pelayanan/referensi' },
            { name: 'Ruang Komputer', href: '/pelayanan/ruang_komputer' },
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
        name: 'Informasi',
        items: [
            { name: 'Berita', href: '/berita' },
            { name: 'Pengumuman', href: '/pengumuman' },
        ],
    },
    { name: 'Bebas Masalah', href: '/bebas_masalah' },
    { name: 'Galeri', href: '/gallery' },
    { name: 'Booking Buku', href: '/book-reservation' },
    { name: 'Kontak', href: '/contact' },
];

const page = usePage();
const currentUrl = page.url;

const openIndex = ref<number | null>(null);
const mobileOpen = ref(false);

function toggleMenu(i: number) {
    openIndex.value = openIndex.value === i ? null : i;
}

function closeAll() {
    openIndex.value = null;
}

function closeMobileMenu() {
    mobileOpen.value = false;
    openIndex.value = null;
}

function onDocumentClick(e: MouseEvent) {
    const target = e.target as HTMLElement | null;
    if (!target) return;
    if (target.closest('.navbar-dropdown')) return;
    closeAll();
}

function onEsc(e: KeyboardEvent) {
    if (e.key === 'Escape') {
        closeAll();
        if (mobileOpen.value) {
            closeMobileMenu();
        }
    }
}

// Mencegah scroll pada body ketika mobile menu terbuka
watch(mobileOpen, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    document.addEventListener('click', onDocumentClick, true);
    document.addEventListener('keydown', onEsc);
});

onUnmounted(() => {
    document.removeEventListener('click', onDocumentClick, true);
    document.removeEventListener('keydown', onEsc);
    // Reset body overflow saat component unmount
    document.body.style.overflow = '';
});
</script>

<template>
    <nav
        class="bg-grey border-b border-gray-200 bg-white/90 py-3 text-black backdrop-blur-md"
    >
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <Link href="/" class="flex items-center gap-6">
                        <img
                            src="/Images/logo-polban-ori.png"
                            alt="Logo Politeknik Negeri Bandung"
                            class="h-10 w-auto object-contain md:h-14"
                        />
                        <div class="leading-tight sm:block">
                            <h1 class="text-sm font-bold md:text-lg">
                                PERPUSTAKAAN POLBAN
                            </h1>
                            <p class="text-md text-gray-600 md:text-lg">
                                NPP: 321702200000001
                            </p>
                        </div>
                    </Link>
                </div>

                <!-- Tombol Mobile -->
                <button
                    @click="mobileOpen = !mobileOpen"
                    class="flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 focus:outline-none xl:hidden"
                    aria-label="Toggle menu"
                >
                    <Menu v-if="!mobileOpen" class="h-6 w-6" />
                    <X v-else class="h-6 w-6" />
                </button>

                <!-- Desktop Nav -->
                <div class="hidden items-center gap-5 xl:flex">
                    <template v-for="(item, i) in navItems" :key="item.name">
                        <!-- plain link -->
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="text-md rounded-full p-2 font-medium hover:text-[var(--dark-green)]"
                            :class="[
                                item.href === currentUrl
                                    ? 'bg-[var(--background-green)] text-[var(--dark-green)]'
                                    : 'text-gray-700',
                            ]"
                        >
                            {{ item.name }}
                        </Link>

                        <!-- dropdown -->
                        <div
                            v-else
                            class="navbar-dropdown relative"
                            @click.stop
                        >
                            <button
                                @click="toggleMenu(i)"
                                class="text-md flex items-center gap-1 rounded-full p-2 font-medium text-gray-700 transition-colors hover:text-[var(--font-green)]"
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

            <!-- Mobile Menu -->
            <transition name="fade">
                <div
                    v-show="mobileOpen"
                    class="mt-3 flex max-h-[70vh] flex-col gap-2 overflow-y-auto border-t border-gray-200 pt-3 xl:hidden"
                >
                    <template v-for="(item, i) in navItems" :key="item.name">
                        <!-- single link -->
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="block rounded-md px-3 py-2 text-gray-700 hover:bg-gray-100"
                            :class="[
                                item.href === currentUrl
                                    ? 'bg-[var(--background-green)] text-[var(--dark-green)]'
                                    : '',
                            ]"
                            @click="closeMobileMenu"
                        >
                            {{ item.name }}
                        </Link>

                        <!-- dropdown in mobile -->
                        <div v-else class="navbar-dropdown">
                            <button
                                @click="toggleMenu(i)"
                                class="flex w-full items-center justify-between rounded-md px-3 py-2 text-gray-700 hover:bg-gray-100"
                            >
                                <span>{{ item.name }}</span>
                                <ChevronDown
                                    :class="[
                                        'h-4 w-4 transition-transform',
                                        openIndex === i ? 'rotate-180' : '',
                                    ]"
                                />
                            </button>

                            <div
                                v-show="openIndex === i"
                                class="flex flex-col gap-1 py-1 pl-5"
                            >
                                <Link
                                    v-for="subItem in item.items"
                                    :key="subItem.name"
                                    :href="subItem.href"
                                    class="block rounded-md px-3 py-1 text-sm text-gray-600 hover:bg-gray-100"
                                    :class="[
                                        subItem.href === currentUrl
                                            ? 'bg-[var(--background-green)] text-[var(--dark-green)]'
                                            : '',
                                    ]"
                                    @click="closeMobileMenu"
                                >
                                    {{ subItem.name }}
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </transition>
        </div>
    </nav>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
