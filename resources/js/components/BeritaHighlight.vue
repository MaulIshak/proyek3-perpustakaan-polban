<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import { ArrowRight, Newspaper } from 'lucide-vue-next';

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
];
</script>

<template>
    <section class="w-full py-4">
        <div class="mx-auto max-w-7xl">
            <!-- Header Section (Consistent with Home) -->
            <div
                class="mb-10 flex flex-col justify-between gap-4 md:flex-row md:items-end"
            >
                <div>
                    <div class="mb-2 flex items-center gap-3">
                        <div
                            class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                        >
                            <Newspaper class="h-6 w-6" />
                        </div>
                        <h2
                            class="text-3xl font-black tracking-tight text-slate-900"
                        >
                            Berita Terbaru
                        </h2>
                    </div>
                    <div
                        class="ml-1 h-1.5 w-24 rounded-full bg-[#99cc33] shadow-sm shadow-[#99cc33]/50"
                    ></div>
                </div>

                <a
                    href="/berita"
                    class="group flex items-center gap-2 rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:border-[#99cc33] hover:text-[#99cc33] hover:shadow-md"
                >
                    Lihat Semua
                    <ArrowRight
                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                    />
                </a>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <BeritaCard
                    v-for="berita in beritaList"
                    :key="berita.id"
                    :id="berita.id"
                    :title="berita.title"
                    :content="berita.content"
                    :thumbnail="berita.thumbnail"
                    :date="berita.date"
                    class="h-full transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                />
            </div>
        </div>
    </section>
</template>
