<script setup lang="ts">
import ProfileMenu from '@/components/admin/ProfileMenu.vue';
import { Menu } from 'lucide-vue-next';

defineProps({
    sidebarOpen: Boolean,
    profileMenuOpen: Boolean,
    title: String,
});

const emit = defineEmits(['toggle-sidebar', 'toggle-profile-menu']);
</script>

<template>
    <header
        class="flex min-h-40 items-center justify-between rounded-b-3xl border-b bg-white bg-[url('/hero-bg.jpg')] bg-cover bg-center px-6 py-3 shadow-sm brightness-40"
    >
        <div class="flex items-center gap-3">
            <button
                @click="emit('toggle-sidebar')"
                class="rounded-lg p-2 transition hover:bg-gray-100"
            >
                <Menu
                    class="text-2xl text-gray-700 transition-transform"
                    :class="{ 'rotate-180': !sidebarOpen }"
                />
            </button>
            <h2 class="text-lg font-semibold">{{ title }}</h2>
        </div>

        <ProfileMenu
            :profile-menu-open="profileMenuOpen"
            @toggle-profile-menu="emit('toggle-profile-menu')"
        />
    </header>
</template>
