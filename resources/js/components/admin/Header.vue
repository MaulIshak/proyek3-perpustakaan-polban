<script setup lang="ts">
defineProps({
    sidebarOpen: Boolean,
    profileMenuOpen: Boolean,
    title: String,
    subTitle: String,
});

const emit = defineEmits(['toggle-profile-menu']);
</script>

<template>
    <header
        class="relative flex h-30 items-center justify-between rounded-b-4xl bg-[url('/hero-bg.jpg')] bg-cover bg-center shadow-sm"
    >
        <div
            class="absolute inset-0 bg-[var(--dark-green)]/85 bg-gradient-to-r to-[var(--primary-green)]/50"
        ></div>

        <div
            class="relative z-10 flex w-full items-end justify-between px-8 pb-4"
        ></div>
    </header>
</template>
