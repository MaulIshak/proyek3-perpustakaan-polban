<script setup lang="ts">
import Navbar from '../components/Navbar.vue';
import ChatWidget from '@/components/ChatWidget.vue';
import Footer from '../components/Footer.vue';
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
        <main class="flex-grow pt-22">
            <section
                v-if="page"
                class="relative w-full bg-cover bg-center bg-no-repeat p-12 px-24 text-white"
                :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
            >
                <div class="absolute inset-0 bg-black/60"></div>
                <RemahanRoti :itemRoti="breadcrumb" class="relative z-10" />

                <!-- Flex Container -->
                <div
                    class="relative z-10 mt-5 mb-4 flex items-center justify-between"
                >
                    <!-- Kiri: Berita -->
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-3 bg-[var(--primary-green)]"></div>
                        <h2
                            class="text-4xl font-bold text-[var(--background-green)]"
                        >
                            {{ title }}
                        </h2>
                        <p>
                            {{ subtitle }}
                        </p>
                    </div>
                </div>
            </section>
            <slot />
        </main>
        <ChatWidget />
        <Footer />
    </div>
</template>
