<script setup lang="ts">
import Navbar from '../components/Navbar.vue';
import ChatWidget from '@/components/ChatWidget.vue';
import Footer from '../components/Footer.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col">
        <Navbar class="fixed top-0 left-0 z-50 w-full shadow" />
        <main class="flex-grow pt-22">
            <slot />
        </main>
        <ChatWidget />
        <Footer />
    </div>
</template>
