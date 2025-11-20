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
            { name: 'Rencana Strategi', href: '/renstra' },
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
            { name: 'Katalog Digital', href: 'https://elib.polban.ac.id/' },
            { name: 'Digilib', href: 'https://digilib.polban.ac.id/' },
            { name: 'E-Journal', href: '/E_Journal' },
            { name: 'Form Usulan Buku', href: '/usulan_buku' },
        ],
    },
    {
        name: 'Arsip',
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
    document.body.style.overflow = '';
});
</script>

<template>
    <nav
        class="sticky top-0 z-50 w-full border-b border-slate-200 bg-white shadow-sm transition-all duration-300"
    >
        <!-- Top Decorative Line -->
        <div
            class="absolute top-0 left-0 h-0.5 w-full bg-gradient-to-r from-[#99cc33] to-[#7aace5]"
        ></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo Section -->
                <!-- Adjusted gap for mobile -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <Link href="/" class="group flex items-center gap-2 sm:gap-4">
                        <div class="relative shrink-0">
                            <div
                                class="absolute inset-0 rounded-full bg-[#99cc33]/20 opacity-0 blur-lg transition-opacity duration-500 group-hover:opacity-100"
                            ></div>
                            <img
                                src="/logo-polban.png"
                                alt="Logo Politeknik Negeri Bandung"
                                class="relative h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105 md:h-14"
                            />
                        </div>
                        <!-- PERBAIKAN DI SINI: -->
                        <!-- 1. Menghapus 'hidden' agar muncul di mobile -->
                        <!-- 2. Menggunakan text-[10px] untuk mobile agar muat -->
                        <!-- 3. Menggunakan flex-col agar teks NPP berada di bawah judul -->
                        <div class="flex flex-col justify-center">
                            <h1
                                class="text-[10px] leading-tight font-extrabold tracking-tight text-slate-800 transition-colors duration-300 group-hover:text-[#99cc33] sm:text-sm md:text-base lg:text-lg"
                            >
                                PERPUSTAKAAN POLITEKNIK NEGERI BANDUNG
                                <span
                                    class="block font-semibold text-slate-500 text-[9px] sm:text-xs md:text-sm lg:text-base"
                                    >NPP: 321702200000001</span
                                >
                            </h1>
                        </div>
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="mobileOpen = !mobileOpen"
                    class="flex shrink-0 items-center justify-center rounded-xl p-2.5 text-slate-600 transition-colors hover:bg-[#99cc33]/10 hover:text-[#99cc33] focus:outline-none xl:hidden"
                    aria-label="Toggle menu"
                >
                    <Menu v-if="!mobileOpen" class="h-6 w-6" />
                    <X v-else class="h-6 w-6" />
                </button>

                <!-- Desktop Nav -->
                <div class="hidden items-center gap-2 xl:flex">
                    <template v-for="(item, i) in navItems" :key="item.name">
                        <!-- Single Link -->
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="rounded-full px-4 py-2 text-sm font-semibold transition-all duration-200"
                            :class="[
                                item.href === currentUrl
                                    ? 'bg-[#99cc33]/10 text-[#99cc33]'
                                    : 'text-slate-600 hover:bg-slate-50 hover:text-[#99cc33]',
                            ]"
                        >
                            {{ item.name }}
                        </Link>

                        <!-- Dropdown Menu -->
                        <div v-else class="navbar-dropdown group relative">
                            <button
                                @click="toggleMenu(i)"
                                class="flex items-center gap-1 rounded-full px-4 py-2 text-sm font-semibold transition-all duration-200 group-hover:text-[#99cc33]"
                                :class="
                                    openIndex === i
                                        ? 'bg-[#99cc33]/5 text-[#99cc33]'
                                        : 'text-slate-600 hover:bg-slate-50'
                                "
                            >
                                <span>{{ item.name }}</span>
                                <ChevronDown
                                    class="h-4 w-4 transition-transform duration-300"
                                    :class="{ 'rotate-180': openIndex === i }"
                                />
                            </button>

                            <!-- Dropdown Content -->
                            <transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 translate-y-2"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-2"
                            >
                                <ul
                                    v-show="openIndex === i"
                                    class="absolute left-0 z-50 mt-2 w-56 origin-top-left rounded-2xl bg-white py-2 shadow-xl ring-1 shadow-slate-200/50 ring-slate-100 focus:outline-none"
                                >
                                    <li
                                        v-for="subItem in item.items"
                                        :key="subItem.name"
                                    >
                                        <a
                                            v-if="
                                                subItem.href &&
                                                subItem.href.startsWith('http')
                                            "
                                            :href="subItem.href"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="block px-4 py-2.5 text-sm font-medium text-slate-600 transition-all duration-200 hover:bg-[#99cc33]/5 hover:pl-6 hover:text-[#99cc33]"
                                            @click="closeAll"
                                        >
                                            {{ subItem.name }}
                                        </a>

                                        <Link
                                            v-else
                                            :href="subItem.href"
                                            class="block px-4 py-2.5 text-sm font-medium text-slate-600 transition-all duration-200 hover:bg-[#99cc33]/5 hover:pl-6 hover:text-[#99cc33]"
                                            :class="{
                                                'bg-[#99cc33]/5 text-[#99cc33]':
                                                    subItem.href === currentUrl,
                                            }"
                                            @click="closeAll"
                                        >
                                            {{ subItem.name }}
                                        </Link>
                                    </li>
                                </ul>
                            </transition>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Mobile Menu Overlay -->
            <transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="mobileOpen"
                    class="fixed inset-0 z-40 bg-slate-900/20 backdrop-blur-sm xl:hidden"
                    @click="closeMobileMenu"
                ></div>
            </transition>

            <!-- Mobile Menu Content -->
            <transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="-translate-y-4 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="-translate-y-4 opacity-0"
            >
                <div
                    v-show="mobileOpen"
                    class="absolute top-full right-0 left-0 z-50 mx-4 mt-2 flex max-h-[80vh] flex-col gap-2 overflow-y-auto rounded-2xl bg-white p-4 shadow-2xl ring-1 ring-slate-100 xl:hidden"
                >
                    <template v-for="(item, i) in navItems" :key="item.name">
                        <!-- Single Link Mobile -->
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="block rounded-xl px-4 py-3 text-base font-medium transition-colors"
                            :class="[
                                item.href === currentUrl
                                    ? 'bg-[#99cc33]/10 text-[#99cc33]'
                                    : 'text-slate-600 hover:bg-slate-50 hover:text-[#99cc33]',
                            ]"
                            @click="closeMobileMenu"
                        >
                            {{ item.name }}
                        </Link>

                        <!-- Dropdown Mobile -->
                        <div
                            v-else
                            class="rounded-xl transition-colors duration-200"
                            :class="{ 'bg-slate-50': openIndex === i }"
                        >
                            <button
                                @click="toggleMenu(i)"
                                class="flex w-full items-center justify-between px-4 py-3 text-base font-medium text-slate-600 transition-colors hover:text-[#99cc33]"
                                :class="{
                                    'text-[#99cc33]': openIndex === i,
                                }"
                            >
                                <span>{{ item.name }}</span>
                                <ChevronDown
                                    class="h-5 w-5 transition-transform duration-300"
                                    :class="{ 'rotate-180': openIndex === i }"
                                />
                            </button>

                            <!-- Konten Dropdown -->
                            <div
                                v-show="openIndex === i"
                                class="flex flex-col gap-1 p-2 pt-0"
                            >
                                <template
                                    v-for="subItem in item.items"
                                    :key="subItem.name"
                                >
                                    <a
                                        v-if="
                                            subItem.href &&
                                            subItem.href.startsWith('http')
                                        "
                                        :href="subItem.href"
                                        target="_blank"
                                        class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 transition-all hover:bg-white hover:text-[#99cc33] hover:shadow-sm"
                                        @click="closeMobileMenu"
                                    >
                                        {{ subItem.name }}
                                    </a>
                                    <Link
                                        v-else
                                        :href="subItem.href"
                                        class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 transition-all hover:bg-white hover:text-[#99cc33] hover:shadow-sm"
                                        :class="{
                                            'bg-white text-[#99cc33] shadow-sm':
                                                subItem.href === currentUrl,
                                        }"
                                        @click="closeMobileMenu"
                                    >
                                        {{ subItem.name }}
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </transition>
        </div>
    </nav>
</template>
