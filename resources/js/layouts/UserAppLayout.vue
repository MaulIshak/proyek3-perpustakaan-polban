<script setup lang="ts">
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col">
        <Navbar class="fixed top-0 left-0 z-50 w-full shadow" />
        <main class="flex-grow pt-22">
            <slot />
        </main>
        <Footer />
    </div>
</template>
