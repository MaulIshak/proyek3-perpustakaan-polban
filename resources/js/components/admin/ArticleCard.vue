<script setup lang="ts">
import DOMPurify from 'dompurify';
import { Calendar, Eye, Pencil, Trash } from 'lucide-vue-next';

defineProps<{
    title: string;
    content: string;
    status: string;
    time: string;
    deleteAction: string;
    thumbnailUrl: string;
}>();

const sanitizeContent = (html: string) => DOMPurify.sanitize(html);

function formatDate(dateString: string) {
    if (!dateString) return '-'; // fallback kalau null
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function truncateText(text: string, maxLength: number = 120): string {
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
        <div class="h-40 w-full overflow-hidden rounded-lg bg-gray-200">
            <img
                :src="thumbnailUrl"
                alt="Thumbnail"
                class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
            />
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

            <p class="flex items-center gap-1 text-xs text-gray-500">
                <Calendar class="h-3.5 w-3.5" />{{ formatDate(time) }}
            </p>
            <div class="mt-3 text-sm text-gray-700">
                {{ truncateText(stripHtml(content), 110) }}
            </div>
            <div class="mt-4 flex justify-end gap-2 text-sm">
                <a
                    class="rounded-lg border border-blue-600 px-2 py-2 text-center font-medium text-blue-600 transition hover:bg-blue-600 hover:text-white"
                >
                    <Eye class="mr-1 inline-block h-4 w-4" />
                    Lihat
                </a>
                <a
                    class="rounded-lg border border-yellow-500 px-2 py-2 text-center font-medium text-yellow-500 transition hover:bg-yellow-500 hover:text-white"
                >
                    <Pencil class="mr-1 inline-block h-4 w-4" />
                    Edit
                </a>
                <form :action="deleteAction" method="POST">
                    <button
                        type="submit"
                        class="rounded-lg border border-red-600 px-2 py-2 text-center font-medium text-red-600 transition hover:bg-red-600 hover:text-white"
                    >
                        <Trash class="mr-1 inline-block h-4 w-4" />
                        Hapus
                    </button>
                </form>
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
