<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
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
        </div>
    </UserAppLayout>
</template>
