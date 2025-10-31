<script setup>
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
        class="flex items-center gap-3 rounded-lg p-2 text-gray-700 hover:bg-emerald-50"
        :class="{
            'bg-emerald-500 text-gray-100 hover:bg-emerald-600':
                $page.url === to,
        }"
    >
        <component
            :is="Icons[icon]"
            class="min-w-7 text-xl"
            :class="{ 'text-gray-100': $page.url === to }"
        />
        <span
            v-show="true"
            class="text-wrap whitespace-nowrap transition-opacity duration-300"
            :class="{
                'text-gray-100': $page.url === to,
                'opacity-0': !sidebarOpen,
            }"
        >
            {{ label }}
        </span>
    </Link>
</template>
