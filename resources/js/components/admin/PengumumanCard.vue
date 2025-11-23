<script setup lang="ts">
import { Eye, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    id: string | number;
    title: string;
    content: string;
    date: string;
    status?: string; // Opsional: status tayang
    updateHref: string; // URL edit
}>();

const emit = defineEmits(['delete', 'view']);

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

// Helper warna status
const statusColor = computed(() => {
    const s = (props.status || '').toLowerCase();
    if (s === 'published' || s === 'tayang') return 'bg-emerald-100 text-emerald-700 border-emerald-200';
    if (s === 'draft') return 'bg-slate-100 text-slate-700 border-slate-200';
    return 'bg-amber-100 text-amber-700 border-amber-200';
});
</script>

<template>
    <div
        class="group flex flex-col sm:flex-row bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-[#99cc33]/50 overflow-hidden"
    >
        <!-- 1. Kotak Tanggal (Visual Anchor - Admin Style) -->
        <!-- Menggunakan warna primary admin (#99cc33) -->
        <div class="sm:w-32 bg-[#99cc33] p-4 flex flex-col items-center justify-center text-white shrink-0 relative overflow-hidden">
            <!-- Decorative patterns -->
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full blur-xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-black/5 rounded-full blur-lg translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

            <div class="relative z-10 text-center group-hover:scale-110 transition-transform duration-300">
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

        <!-- 2. Konten & Actions -->
        <div class="flex-1 flex flex-col">
            <div class="p-5 flex-grow">
                <div class="flex justify-between items-start gap-4 mb-2">
                    <h3 class="text-lg font-bold text-slate-800 leading-tight line-clamp-2 group-hover:text-[#99cc33] transition-colors">
                        {{ title }}
                    </h3>

                    <!-- Status Badge (Jika ada) -->
                    <span
                        v-if="status"
                        class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide border shrink-0"
                        :class="statusColor"
                    >
                        {{ status }}
                    </span>
                </div>

                <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">
                    {{ truncateText(stripHtml(content)) }}
                </p>
            </div>

            <!-- 3. Admin Action Footer -->
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">

                <!-- View Button -->
                <button
                    @click="$emit('view')"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-sky-600 bg-sky-50 hover:bg-sky-100 border border-sky-100 transition-colors"
                    title="Lihat Detail"
                >
                    <Eye class="w-3.5 h-3.5" />
                    Lihat
                </button>

                <!-- Edit Button -->
                <Link
                    :href="updateHref"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-100 transition-colors"
                    title="Edit Pengumuman"
                >
                    <Pencil class="w-3.5 h-3.5" />
                    Edit
                </Link>

                <!-- Delete Button -->
                <button
                    @click="$emit('delete')"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition-colors"
                    title="Hapus Pengumuman"
                >
                    <Trash class="w-3.5 h-3.5" />
                    Hapus
                </button>
            </div>
        </div>
    </div>
</template>
