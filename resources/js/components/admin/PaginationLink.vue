<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

// Definisi tipe untuk Link Pagination Laravel
interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

defineProps<{
    links: PaginationLink[];
}>();
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap justify-center gap-2 mt-6">
        <template v-for="(link, key) in links" :key="key">

            <!-- Case 1: Link Disabled / Ellipsis (...) -->
            <!-- Biasanya untuk 'Previous' di halaman 1 atau '...' -->
            <div
                v-if="link.url === null"
                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-default select-none"
                v-html="link.label"
            />

            <!-- Case 2: Link Aktif / Halaman Saat Ini -->
            <Link
                v-else-if="link.active"
                :href="link.url"
                class="flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-[#99cc33] border border-[#99cc33] rounded-lg shadow-md shadow-[#99cc33]/30 transform scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#99cc33] focus:ring-offset-2"
                v-html="link.label"
            />

            <!-- Case 3: Link Inaktif (Bisa diklik) -->
            <Link
                v-else
                :href="link.url"
                class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-[#99cc33] hover:border-[#99cc33]/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#99cc33]/20"
                v-html="link.label"
            />

        </template>
    </div>
</template>
