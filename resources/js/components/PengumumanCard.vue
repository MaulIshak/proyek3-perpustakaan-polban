<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';
import { defineProps } from 'vue';

const props = defineProps<{
    // Prop ID diubah menjadi string (UUID)
    id: string;
    title: string;
    content: string;
    // PengumumanCard tidak selalu punya thumbnail, jadi dihapus atau jadikan opsional jika ada
    date: string;
}>();

function formatDate(dateString: string) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function truncateText(text: string, maxLength: number = 150): string {
    // Pengumuman biasanya lebih panjang, gunakan maksimal 150 karakter untuk pratinjau
    if (text.length <= maxLength) return text;
    return text.slice(0, maxLength) + '...';
}

function stripHtml(html: string) {
    if (!html) return '';
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
}

function extractDateParts(dateString: string) {
    const date = new Date(dateString);
    const day = date.getDate();
    const month = date.toLocaleString('id-ID', { month: 'short' }); // Jan, Feb, dst
    const year = date.getFullYear();
    return { day, month, year };
}
</script>

<template>
    <div
        class="group flex flex-col overflow-hidden rounded-xl border bg-white shadow-sm transition-all hover:shadow-md sm:flex-row"
    >
        <!-- Kotak Tanggal -->
        <div class="flex items-center justify-center p-6 sm:w-1/4">
            <div
                class="flex flex-col items-center justify-center rounded-xl bg-[var(--primary-green)]/90 px-5 py-4 text-white shadow"
            >
                <span class="text-4xl leading-none font-extrabold">
                    {{ extractDateParts(date).day }}
                </span>
                <span
                    class="mt-1 text-xs font-medium tracking-widest uppercase opacity-90"
                >
                    {{ extractDateParts(date).month }}
                    {{ extractDateParts(date).year }}
                </span>
            </div>
        </div>

        <!-- Konten -->
        <div class="flex flex-col justify-between p-6 sm:w-3/4">
            <div>
                <h3
                    class="mb-2 line-clamp-2 text-lg font-semibold text-gray-900 transition-colors group-hover:text-[var(--primary-green)]"
                >
                    {{ title }}
                </h3>

                <p class="mb-4 line-clamp-3 text-sm text-gray-600">
                    {{ truncateText(stripHtml(content)) }}
                </p>
            </div>

            <a
                class="flex w-45 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                :href="`/pengumuman/${id}`"
                data-discover="true"
                >Baca Selengkapnya <ArrowRight class="w-5" />
            </a>
        </div>
    </div>
</template>
