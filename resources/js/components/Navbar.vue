<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';

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
console.log(currentUrl);
</script>

<template>
    <nav class="bg-white py-4 text-[var(--font-green)] backdrop-blur-3xl">
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
                    <template v-for="item in navItems" :key="item.name">
                        <Link
                            v-if="!item.items"
                            :href="item.href"
                            class="font-medium hover:text-[var(--font-green)]"
                            :class="[
                                item.href === currentUrl
                                    ? 'text-[var(--font-green)]'
                                    : 'text-gray-700',
                            ]"
                        >
                            {{ item.name }}
                        </Link>

                        <DropdownMenu v-else>
                            <DropdownMenuTrigger
                                class="flex items-center gap-1 font-medium text-gray-700 transition-colors hover:text-[var(--font-green)]"
                            >
                                <span>{{ item.name }}</span>
                                <ChevronDown class="h-4 w-4" />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuItem
                                    v-for="subItem in item.items"
                                    :key="subItem.name"
                                >
                                    <Link :href="subItem.href">
                                        {{ subItem.name }}
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
