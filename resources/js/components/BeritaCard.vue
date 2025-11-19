<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';
import { defineProps } from 'vue';

const props = defineProps<{
    // Mengubah tipe id menjadi string karena menggunakan UUID
    id: string;
    title: string;
    content: string;
    thumbnail: string;
    date: string;
}>();

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
        class="group overflow-hidden rounded-xl border bg-card text-card-foreground shadow transition-shadow hover:shadow-xl"
    >
        <img
            alt="Workshop Literasi Digital untuk Mahasiswa Baru 2025"
            class="h-48 w-full object-cover transition-all duration-700 ease-out group-hover:scale-110 group-hover:brightness-120"
            :src="thumbnail"
        />
        <div class="p-5">
            <div class="mb-3 flex items-center gap-2">
                <span class="text-sm text-gray-500">{{
                    formatDate(date)
                }}</span>
            </div>
            <h3 class="mb-2 line-clamp-2 text-lg font-bold text-gray-800">
                {{ title }}
            </h3>
            <p class="mb-4 line-clamp-2 text-sm text-gray-600">
                {{ truncateText(stripHtml(content)) }}
            </p>
            <a
                class="flex w-45 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                :href="`/berita/${id}`"
                data-discover="true"
                >Baca Selengkapnya <ArrowRight class="w-5" />
            </a>
        </div>
    </div>
</template>
