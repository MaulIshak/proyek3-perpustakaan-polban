<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { User } from 'lucide-vue-next';

defineProps({
    profileMenuOpen: Boolean,
});

const emit = defineEmits(['toggle-profile-menu']);
</script>

<template>
    <div class="relative">
        <button
            @click="emit('toggle-profile-menu')"
            class="flex items-center gap-2 rounded-full bg-emerald-500 px-3 py-1.5 text-white transition hover:bg-emerald-600"
        >
            <span class="text-sm font-medium">Admin</span>
            <div
                class="flex h-7 w-7 items-center justify-center rounded-full bg-white/20"
            >
                <User />
            </div>
        </button>

        <div
            v-if="profileMenuOpen"
            class="absolute right-0 mt-2 w-40 rounded-lg border bg-white py-1 text-sm shadow-md"
        >
            <Link
                href="/admin/logout"
                method="post"
                as="button"
                class="block w-full px-4 py-2 text-left hover:bg-gray-100"
            >
                Logout
            </Link>
        </div>
    </div>
</template>
