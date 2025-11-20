<script setup lang="ts">
import { ArrowRight, CalendarDays } from 'lucide-vue-next';
import { defineProps } from 'vue';

const props = defineProps<{
    // Mengubah tipe id menjadi string/number agar fleksibel
    id: string | number;
    title: string;
    content: string;
    thumbnail: string;
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
        class="group flex flex-col h-full bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-lg shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-[#99cc33]/30"
    >
        <!-- Image Container -->
        <div class="relative h-52 overflow-hidden shrink-0">
            <img
                :src="thumbnail"
                :alt="title"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>

            <!-- Date Badge (Floating) -->
            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-2 text-xs font-bold text-slate-600 shadow-sm">
                <CalendarDays class="w-3.5 h-3.5 text-[#99cc33]" />
                {{ formatDate(date) }}
            </div>
        </div>

        <!-- Content Container -->
        <div class="p-6 flex flex-col flex-grow">
            <h3 class="mb-3 text-xl font-extrabold text-slate-800 leading-tight line-clamp-2 group-hover:text-[#99cc33] transition-colors">
                {{ title }}
            </h3>

            <p class="mb-6 text-sm text-slate-500 leading-relaxed line-clamp-3 flex-grow">
                {{ truncateText(stripHtml(content)) }}
            </p>

            <!-- Action Button -->
            <div class="mt-auto pt-4 border-t border-slate-100">
                <a
                    :href="`/berita/${id}`"
                    class="flex items-center justify-center w-full gap-2 rounded-xl bg-[#99cc33] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/20 transition-all duration-300 hover:bg-[#88b82d] hover:shadow-[#99cc33]/40 group/btn"
                >
                    Baca Selengkapnya
                    <ArrowRight class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
                </a>
            </div>
        </div>
    </div>
</template>
