<script setup lang="ts"></script>

<template>
    <section
        class="relative w-full bg-cover bg-center bg-no-repeat text-white"
        :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
    >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Konten -->
        <!-- Perubahan: text-center diubah menjadi text-left untuk mobile, dan md:text-center untuk desktop -->
        <div
            class="relative z-10 px-6 py-36 text-left md:py-42 md:text-center lg:px-24"
        >
            <h2 class="mb-4 text-3xl font-extrabold md:text-5xl">
                Selamat Datang di
            </h2>

            <!-- Judul dengan teks gradasi -->
            <h1
                class="mb-6 bg-gradient-to-r from-[var(--primary-green)] from-50% to-emerald-600 bg-clip-text text-4xl font-bold text-transparent md:text-6xl"
            >
                PERPUSTAKAAN POLBAN
            </h1>

            <!-- Perubahan: mx-auto diubah menjadi md:mx-auto agar di mobile rata kiri (default), desktop rata tengah -->
            <div
                class="h-1.5 w-36 rounded-full bg-[#99cc33] shadow-[0_0_20px_rgba(153,204,51,0.6)] md:mx-auto"
            ></div>
        </div>
    </section>
</template>
