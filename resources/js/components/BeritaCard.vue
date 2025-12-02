<script setup lang="ts">
import { ArrowRight, CalendarDays } from 'lucide-vue-next';
import { defineProps } from 'vue';

const props = defineProps<{
    // Mengubah tipe id menjadi string/number agar fleksibel
    id: string | number;
    title: string;
    content: string;
    thumbnail: string | null;
    date: string;
}>();

function formatDate(dateString: string) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }).format(date);
}

function truncateText(text: string, maxLength: number = 100): string {
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
        class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-lg shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/30 hover:shadow-xl"
    >
        <!-- Image Container -->
        <div class="relative h-52 shrink-0 overflow-hidden">
            <img
                :src="thumbnail ?? ''"
                :alt="title"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <!-- Gradient Overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"
            ></div>

            <!-- Date Badge (Floating) -->
            <div
                class="absolute top-4 right-4 flex items-center gap-2 rounded-full bg-white/90 px-3 py-1.5 text-xs font-bold text-slate-600 shadow-sm backdrop-blur-sm"
            >
                <CalendarDays class="h-3.5 w-3.5 text-[#99cc33]" />
                {{ formatDate(date) }}
            </div>
        </div>

        <!-- Content Container -->
        <div class="flex flex-grow flex-col p-6">
            <h3
                class="mb-3 line-clamp-2 text-xl leading-tight font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
            >
                {{ title }}
            </h3>

            <p
                class="mb-6 line-clamp-3 flex-grow text-sm leading-relaxed text-slate-500"
            >
                {{ truncateText(stripHtml(content)) }}
            </p>

            <!-- Action Button -->
            <div class="mt-auto border-t border-slate-100 pt-4">
                <a
                    :href="`/berita/${id}`"
                    class="group/btn flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/20 transition-all duration-300 hover:bg-[#88b82d] hover:shadow-[#99cc33]/40"
                >
                    Baca Selengkapnya
                    <ArrowRight
                        class="h-4 w-4 transition-transform group-hover/btn:translate-x-1"
                    />
                </a>
            </div>
        </div>
    </div>
</template>
