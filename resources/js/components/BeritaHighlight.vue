<script setup>
import BeritaCard from '@/components/BeritaCard.vue';
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
    <section class="bg-gradient-to-br py-12">
        <div class="mx-auto">
            <div class="mb-8 flex items-center justify-between">
                <div class="inline-block">
                    <h2
                        class="relative text-3xl font-bold text-[var(--dark-green)]"
                    >
                        Berita Terbaru
                    </h2>
                    <span
                        class="mt-1 block h-1 w-16 rounded-full bg-[var(--primary-green)]"
                    ></span>
                </div>
                <a
                    class="flex w-35 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                    href="/berita"
                    data-discover="true"
                    >Lihat Semua<svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-arrow-right h-5 w-5"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path></svg
                ></a>
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
        </div>
    </section>
</template>
