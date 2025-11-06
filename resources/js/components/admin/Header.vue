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
        class="relative flex min-h-40 items-center justify-between rounded-b-3xl border-b bg-white bg-[url('/hero-bg.jpg')] bg-cover bg-center px-6 py-3 shadow-sm"
    >
        <div
            class="absolute inset-0 rounded-b-3xl bg-[var(--dark-green)]/55"
        ></div>
        <div class="relative flex w-full items-end justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    {{ title }}
                </h1>
                <p class="text-gray-200">
                    {{ subTitle }}
                </p>
            </div>
        </div>
    </header>
</template>
