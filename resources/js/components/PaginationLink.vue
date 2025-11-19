<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    link: {
        url: string | null;
        label: string;
        active: boolean;
    };
}>();

const label = computed(() => {
    // Mengganti &laquo; Previous menjadi Sebelumnya, dan &raquo; Next menjadi Selanjutnya
    return props.link.label
        .replace('&laquo; Previous', '« Sebelumnya')
        .replace('Next &raquo;', 'Selanjutnya »');
});
</script>

<template>
    <Link
        :href="link.url ?? '#'"
        :class="[
            'relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0 transition-colors',
            link.active
                ? 'bg-[var(--primary-green)] text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--primary-green)]'
                : 'text-gray-900 hover:bg-gray-50',
            !link.url && 'cursor-default text-gray-400 pointer-events-none',
            // Tambahkan kelas untuk sudut jika ini adalah link pertama atau terakhir
            label === '« Sebelumnya' && 'rounded-l-md',
            label === 'Selanjutnya »' && 'rounded-r-md',
        ]"
        preserve-scroll
        preserve-state
        v-html="label"
    />
</template>
