<script setup lang="js">
import { Link } from '@inertiajs/vue3';
import * as Icons from 'lucide-vue-next';

defineProps({
    icon: String,
    label: String,
    to: String,
    sidebarOpen: Boolean,
});
</script>

<template>
    <Link
        :href="to"
        class="flex items-center gap-3 rounded-lg p-2 text-[var(--dark-green)] hover:bg-white"
        :class="{
            'bg-white text-[var(--dark-green)]': $page.url === to,
        }"
    >
        <component
            :is="Icons[icon]"
            class="min-w-7 text-xl"
            :class="{ 'text-[var(--dark-green)]': $page.url === to }"
        />
        <span
            v-show="true"
            class="text-wrap whitespace-nowrap transition-opacity duration-300"
            :class="{
                'text-[var(--dark-green)]': $page.url === to,
                'opacity-0': !sidebarOpen,
            }"
        >
            {{ label }}
        </span>
    </Link>
</template>
