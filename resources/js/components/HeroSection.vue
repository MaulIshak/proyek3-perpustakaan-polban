<script setup lang="ts"></script>

<template>
    <section
        class="relative w-full bg-cover bg-center bg-no-repeat text-white"
        :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
    >
        <!-- Overlay gelap agar teks terbaca -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Konten utama hero -->
        <div
            class="relative z-10 container mx-auto px-6 py-24 text-center md:py-36 lg:px-16"
        >
            <h2 class="mb-4 text-3xl font-extrabold md:text-5xl">
                Selamat Datang di
            </h2>
            <h1
                class="mb-6 text-4xl font-bold text-[var(--primary-green)] md:text-6xl"
            >
                PERPUSTAKAAN POLBAN
            </h1>
            <p class="mb-10 text-base text-gray-100 md:text-lg">
                Pusat Informasi dan Pengetahuan untuk Kemajuan Akademik Anda
            </p>
        </div>
    </section>
</template>
