<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';

defineProps({
    id: Number,
    title: String,
    date: String,
    content: {
        type: String,
        default: '',
    },
});

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
        class="mb-4 rounded-xl border bg-card p-6 text-card-foreground shadow transition-shadow hover:shadow-lg"
    >
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-[var(--primary-green)]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-calendar h-8 w-8 text-white"
                        aria-hidden="true"
                    >
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm text-gray-500">{{ date }}</span>
                </div>
                <h3 class="mb-2 text-xl font-bold text-gray-800">
                    {{ title }}
                </h3>
                <p class="mb-4 text-gray-600">
                    {{ truncateText(stripHtml(content)) }}
                </p>
                <a
                    class="flex w-45 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                    :href="`/pengumuman${id}`"
                    data-discover="true"
                    >Baca Selengkapnya <ArrowRight class="w-5" />
                </a>
            </div>
        </div>
    </div>
</template>
