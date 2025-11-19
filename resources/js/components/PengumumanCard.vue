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
        class="group flex flex-col overflow-hidden rounded-xl border bg-card text-card-foreground shadow transition-shadow hover:shadow-xl sm:flex-row"
    >
        <!-- Kotak Tanggal -->
        <div
            class="flex items-center justify-start p-6 sm:w-1/4 sm:justify-center"
        >
            <div
                class="flex flex-col items-center justify-center rounded-lg border bg-[var(--primary-green)] p-4 shadow-sm"
            >
                <span class="text-4xl leading-none font-extrabold text-white">
                    {{ extractDateParts(date).day }}
                </span>
                <span class="text-xs tracking-wide text-white uppercase">
                    {{ extractDateParts(date).month }}
                    {{ extractDateParts(date).year }}
                </span>
            </div>
        </div>

        <!-- Konten -->
        <div class="flex flex-col justify-between p-5 sm:w-3/4">
            <div>
                <h3 class="mb-2 line-clamp-2 text-xl font-bold text-gray-800">
                    {{ title }}
                </h3>

                <p class="mb-4 line-clamp-3 text-sm text-gray-600">
                    {{ truncateText(stripHtml(content)) }}
                </p>
            </div>

            <a
                class="mt-4 flex w-fit items-center gap-1 self-start rounded-3xl border border-transparent bg-[var(--primary-green)] px-4 py-2 text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                :href="`/pengumuman/${id}`"
                data-discover="true"
            >
                Lihat Selengkapnya
                <ArrowRight class="h-4 w-4" />
            </a>
        </div>
    </div>
</template>
