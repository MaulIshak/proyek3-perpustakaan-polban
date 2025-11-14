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
        <Navbar class="fixed top-0 left-0 z-50 w-full shadow" />
        <main class="flex-grow bg-gray-50 pt-[70px] sm:pt-[80px]">
            <section
                v-if="page"
                class="relative w-full bg-cover bg-center bg-no-repeat px-6 py-16 text-white sm:px-12 sm:py-20 md:px-24"
                :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
            >
                <div class="absolute inset-0 bg-black/60"></div>
                <RemahanRoti :itemRoti="breadcrumb" class="relative z-10" />

                <div
                    class="relative z-10 mt-5 mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="h-8 w-2 bg-[var(--primary-green)] sm:h-10 sm:w-3"
                        ></div>
                        <div>
                            <h2
                                class="text-2xl font-bold text-[var(--background-green)] sm:text-4xl"
                            >
                                {{ title }}
                            </h2>
                            <p class="text-sm sm:text-base">
                                {{ subtitle }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <HeroSection v-else />

            <div class="container mx-auto px-4">
                <slot />
            </div>
        </main>
        <ChatWidget />
        <Footer />
    </div>
</template>
