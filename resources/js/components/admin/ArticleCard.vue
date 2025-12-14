<script setup lang="ts">
import { Calendar, Eye, Pencil, Trash, Clock } from 'lucide-vue-next';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    title: string;
    content: string;
    status: string;
    time: string;
    thumbnailUrl: string;
    updateHref: string;
    deleteAction: string; // ID atau URL untuk delete
}>();

const emit = defineEmits(['delete', 'view']);

// Format Tanggal
function formatDate(dateString: string) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
}

function stripHtml(html: string) {
    if (!html) return '';
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
}

// Helper warna status (Opsional, bisa disesuaikan dengan value status Anda)
const statusColor = computed(() => {
    const s = props.status.toLowerCase();
    if (s === 'published' || s === 'tayang') return 'bg-emerald-500 text-white';
    if (s === 'draft') return 'bg-slate-500 text-white';
    return 'bg-amber-500 text-white';
});
</script>

<template>
    <div
        class="group relative flex flex-col h-full rounded-2xl bg-white border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 overflow-hidden"
    >
        <!-- 1. Image Section with Overlay Status -->
        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
            <img
                :src="thumbnailUrl"
                alt="Thumbnail Artikel"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
            />

            <!-- Gradient Overlay for text readability if needed -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            <!-- Status Badge (Floating) -->
            <div class="absolute top-3 left-3">
                <span
                    class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm"
                    :class="statusColor"
                >
                    {{ status }}
                </span>
            </div>
        </div>

        <!-- 2. Content Section -->
        <div class="flex flex-col flex-grow p-5">
            <!-- Date -->
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 mb-2">
                <Calendar class="h-3.5 w-3.5" />
                <span>{{ formatDate(time) }}</span>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-bold text-slate-800 leading-tight mb-3 line-clamp-2 group-hover:text-[#99cc33] transition-colors">
                {{ title }}
            </h3>

            <!-- Excerpt -->
            <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 mb-4">
                {{ stripHtml(content) }}
            </p>
        </div>

        <!-- 3. Action Footer -->
        <div class="mt-auto px-5 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
            <!-- View Button -->
            <button
                @click="$emit('view')"
                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition-all duration-200"
                title="Lihat Detail"
            >
                <Eye class="h-4 w-4" />
                <span class="hidden sm:inline">Lihat</span>
            </button>

            <!-- Edit Button -->
            <a
                :href="updateHref"
                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white transition-all duration-200"
                title="Edit Artikel"
            >
                <Pencil class="h-4 w-4" />
                <span class="hidden sm:inline">Edit</span>
            </a>

            <!-- Delete Button -->
            <button
                @click="$emit('delete')"
                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white transition-all duration-200"
                title="Hapus Artikel"
            >
                <Trash class="h-4 w-4" />
                <span class="hidden sm:inline">Hapus</span>
            </button>
        </div>
    </div>
</template>
