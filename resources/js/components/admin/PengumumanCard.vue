<script setup lang="ts">
import { Eye, Pencil, Trash } from 'lucide-vue-next';
import { computed, defineEmits, defineProps } from 'vue';

const props = defineProps<{
    title: string;
    content: string;
    status: string;
    time: string;
    thumbnailUrl: string;
    updateHref: string;
    deleteAction: string;
}>();

const emit = defineEmits(['delete', 'view']);

const formattedDate = computed(() => {
    if (!props.time) return { day: '-', monthYear: '-' };
    const date = new Date(props.time);
    const day = String(date.getDate()).padStart(2, '0');
    const monthYear = new Intl.DateTimeFormat('id-ID', {
        month: 'short',
        year: 'numeric',
    }).format(date);
    return { day, monthYear };
});

function truncateText(text: string, maxLength: number = 110): string {
    if (text.length <= maxLength) return text;
    return text.slice(0, maxLength) + '...';
}

function stripHtml(html: string) {
    if (!html) return '';
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
}
</script>
<template>
    <div
        class="position-relative flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-lg"
    >
        <div
            class="flex h-16 w-16 flex-col items-center justify-center rounded-lg bg-[var(--primary-green)] p-1 text-white"
        >
            <span class="text-2xl leading-none font-bold">{{
                formattedDate.day
            }}</span>
            <span class="text-xs leading-none">{{
                formattedDate.monthYear
            }}</span>
        </div>
        <div class="mt-4 space-y-2">
            <h1 class="text-md font-bold text-gray-800">
                {{ truncateText(title) }}
            </h1>
            <div class="flex items-center gap-2">
                <span
                    class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-emerald-600"
                    >{{ status }}</span
                >
            </div>

            <div class="mt-3 text-sm text-gray-700">
                {{ truncateText(stripHtml(content), 110) }}
            </div>
            <div class="mt-4 flex justify-end gap-2 text-sm">
                <button
                    @click="emit('view')"
                    class="rounded-lg border border-blue-600 px-2 py-2 text-center font-medium text-blue-600 transition hover:bg-blue-600 hover:text-white"
                >
                    <Eye class="mr-1 inline-block h-4 w-4" />
                    Lihat
                </button>
                <a
                    :href="updateHref"
                    class="rounded-lg border border-yellow-500 px-2 py-2 text-center font-medium text-yellow-500 transition hover:bg-yellow-500 hover:text-white"
                >
                    <Pencil class="mr-1 inline-block h-4 w-4" />
                    Edit
                </a>
                <button
                    @click="emit('delete')"
                    class="rounded-lg border border-red-600 px-2 py-2 text-center font-medium text-red-600 transition hover:bg-red-600 hover:text-white"
                >
                    <Trash class="mr-1 inline-block h-4 w-4" />
                    Hapus
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
a,
button:hover {
    cursor: pointer;
}
</style>
