<script setup lang="ts">
import { SwatchBook } from 'lucide-vue-next';
</script>

<template>
    <section
        class="relative w-full bg-cover bg-center bg-no-repeat text-white"
        :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
    >
        <!-- Overlay gelap agar teks terbaca -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Konten utama hero -->
        <div
            class="relative z-10 container mx-auto px-6 py-32 text-center md:py-44 lg:px-16"
        >
            <h2 class="mb-4 text-4xl font-extrabold md:text-6xl">
                Selamat Datang di
            </h2>
            <h1
                class="mb-6 text-5xl font-extrabold text-[var(--primary-green)] md:text-7xl"
            >
                UPT Perpustakaan POLBAN
            </h1>
            <p class="mb-10 text-lg text-gray-100 md:text-xl">
                Pusat Informasi dan Pengetahuan untuk Kemajuan Akademik Anda
            </p>

            <div class="flex justify-center gap-4">
                <a
                    href="/collections"
                    class="flex items-center gap-2 rounded-lg bg-[var(--primary-green)] px-6 py-3 font-semibold text-white transition-colors hover:bg-emerald-700"
                >
                    <SwatchBook />
                    Jelajahi Koleksi
                </a>

                <a
                    href="/about"
                    class="rounded-lg border border-white px-6 py-3 font-semibold transition-colors hover:bg-white hover:text-[var(--font-green)]"
                >
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>
</template>
