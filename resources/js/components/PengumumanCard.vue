<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';

const props = defineProps<{
    id: string | number;
    title: string;
    content: string;
    date: string;
}>();

// Helper untuk memecah tanggal
function getDateParts(dateString: string) {
    if (!dateString) return { day: '-', month: '-', year: '-' };
    const date = new Date(dateString);
    return {
        day: String(date.getDate()).padStart(2, '0'),
        month: date.toLocaleString('id-ID', { month: 'short' }), // Jan, Feb
        year: date.getFullYear()
    };
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
        class="group flex flex-col sm:flex-row bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-[#99cc33]/20 hover:border-[#99cc33]/30 transition-all duration-300 hover:-translate-y-1"
    >
        <!-- Kotak Tanggal (Visual Anchor) -->
        <div class="sm:w-32 bg-[#99cc33] p-4 flex flex-col items-center justify-center text-white shrink-0 relative overflow-hidden">
            <!-- Decorative pattern overlay -->
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full blur-xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-black/5 rounded-full blur-lg translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

            <div class="relative z-10 text-center">
                <span class="block text-4xl font-black leading-none mb-1 drop-shadow-sm">
                    {{ getDateParts(date).day }}
                </span>
                <span class="block text-sm font-bold uppercase tracking-widest opacity-90">
                    {{ getDateParts(date).month }}
                </span>
                <span class="block text-xs font-medium opacity-75 mt-1">
                    {{ getDateParts(date).year }}
                </span>
            </div>
        </div>

        <!-- Konten -->
        <div class="flex-1 p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 group-hover:text-[#99cc33] transition-colors leading-tight">
                    {{ title }}
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-4">
                    {{ truncateText(stripHtml(content)) }}
                </p>
            </div>

            <div class="flex justify-end mt-auto">
                <a
                    :href="`/pengumuman/${id}`"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-[#99cc33] transition-colors group/btn"
                >
                    Baca Detail
                    <div class="bg-slate-100 p-1.5 rounded-full group-hover/btn:bg-[#99cc33] group-hover/btn:text-white transition-colors duration-300">
                        <ArrowRight class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>
