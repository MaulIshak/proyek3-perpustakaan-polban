<script setup lang="ts">
import ChatWidget from '@/components/ChatWidget.vue';
import HeroSection from '@/components/HeroSection.vue';
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import RemahanRoti from './RemahanRoti.vue';

defineProps<{
    title: string;
    subtitle?: string;
    breadcrumb: { label: string; link?: string }[];
    page?: boolean;
}>();
</script>

<template>
    <div class="flex min-h-screen flex-col">
        <!-- Navbar Fixed -->
        <Navbar class="fixed top-0 left-0 z-50 w-full shadow" />

        <!-- Main Content -->
        <!-- Tambahkan pt-20 (atau sesuaikan tinggi navbar) agar konten tidak tertutup navbar fixed -->
        <main class="flex-grow bg-gray-50">
            <!-- Header Halaman (Breadcrumb & Title) -->
            <section
                v-if="page"
                class="relative w-full bg-cover bg-center bg-no-repeat text-white"
                :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
            >
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/50"></div>

                <!-- WRAPPER KONTEN: Gunakan Container standar agar sejajar dengan konten di bawah -->
                <!-- Padding vertikal (py) diletakkan di sini, bukan di section luar -->
                <div
                    class="relative z-10 container mx-auto px-4 py-16 sm:px-6 sm:py-20 lg:px-8"
                >
                    <RemahanRoti :itemRoti="breadcrumb" class="relative z-10" />

                    <div
                        class="relative z-10 mt-5 mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div class="flex items-center gap-3">
                            <!-- Aksen Garis Hijau -->
                            <div
                                class="h-8 w-2 shrink-0 bg-[var(--primary-green)] sm:h-10 sm:w-3"
                            ></div>

                            <div>
                                <h2
                                    class="text-2xl font-medium text-[var(--background-green)] sm:text-4xl"
                                >
                                    {{ title }}
                                </h2>
                                <p class="text-sm text-gray-200 sm:text-base">
                                    {{ subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Hero Section untuk Halaman Depan -->
            <!-- Pastikan komponen HeroSection Anda juga menggunakan 'container mx-auto' di dalamnya jika ingin sejajar -->
            <HeroSection v-else />

            <!-- Slot Konten Utama -->
            <!-- Gunakan konfigurasi Container & Padding yang PERSIS SAMA dengan Header di atas -->
            <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>

        <ChatWidget />
        <Footer />
    </div>
</template>
