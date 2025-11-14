<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { Search } from 'lucide-vue-next';
const beritaList = [
    {
        id: 1,
        title: 'Workshop Literasi Digital untuk Mahasiswa Baru 2025',
        content:
            '<p>Perpustakaan POLBAN mengadakan workshop literasi digital bagi mahasiswa baru tahun 2025...</p>',
        thumbnail: '/hero-bg.jpg',
        date: '2024-06-15',
    },
    {
        id: 2,
        title: 'Pameran Buku Langka di Perpustakaan POLBAN',
        content:
            '<p>Perpustakaan POLBAN mempersembahkan pameran buku langka yang berisi koleksi istimewa...</p>',
        thumbnail: '/hero-bg.jpg',
        date: '2024-06-10',
    },
    {
        id: 3,
        title: 'Peluncuran Aplikasi Mobile Perpustakaan POLBAN',
        content:
            '<p>Perpustakaan POLBAN meluncurkan aplikasi mobile terbaru untuk memudahkan akses koleksi...</p>',
        thumbnail: '/hero-bg.jpg',
        date: '2024-06-05',
    },
    {
        id: 3,
        title: 'Peluncuran Aplikasi Mobile Perpustakaan POLBAN',
        content:
            '<p>Perpustakaan POLBAN meluncurkan aplikasi mobile terbaru untuk memudahkan akses koleksi...</p>',
        thumbnail: '/hero-bg.jpg',
        date: '2024-06-05',
    },
    {
        id: 3,
        title: 'Peluncuran Aplikasi Mobile Perpustakaan POLBAN',
        content:
            '<p>Perpustakaan POLBAN meluncurkan aplikasi mobile terbaru untuk memudahkan akses koleksi...</p>',
        thumbnail: '/hero-bg.jpg',
        date: '2024-06-05',
    },
];
defineProps({
    title: String,
    description: String,
});

const breadcrumb = [{ label: 'Informasi' }, { label: 'Berita' }];
</script>

<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Berita">
        <div class="mx-auto mt-10 mb-8 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="relative mb-6 flex items-center">
                <input
                    type="text"
                    placeholder="Cari berita..."
                    class="w-full rounded-md border border-gray-300 p-3 pl-10 shadow-sm focus:border-[var(--primary-green)] focus:ring-[var(--primary-green)]"
                />
                <Search class="absolute left-3 h-5 w-5 text-gray-400" />
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <BeritaCard
                    v-for="berita in beritaList"
                    :key="berita.id"
                    :id="berita.id"
                    :title="berita.title"
                    :content="berita.content"
                    :thumbnail="berita.thumbnail"
                    :date="berita.date"
                />
            </div>

            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                <nav
                    class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                    aria-label="Pagination"
                >
                    <a
                        href="#"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Previous</span>
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </a>
                    <a
                        href="#"
                        aria-current="page"
                        class="relative z-10 inline-flex items-center bg-[var(--primary-green)] px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--primary-green)]"
                        >1</a
                    >
                    <a
                        href="#"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                        >2</a
                    >
                    <a
                        href="#"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                        >3</a
                    >
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
                        >...</span
                    >
                    <a
                        href="#"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                        >8</a
                    >
                    <a
                        href="#"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                        >9</a
                    >
                    <a
                        href="#"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                        >10</a
                    >
                    <a
                        href="#"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Next</span>
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </UserAppLayout>
</template>
