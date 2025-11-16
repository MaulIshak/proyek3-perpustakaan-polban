<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { computed } from 'vue';
import { Calendar, Download } from 'lucide-vue-next';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Detail Pengumuman',
                subTitle: 'Rincian lengkap dari pengumuman',
            },
            { default: () => page },
        ),
});

const props = defineProps({
    article: Object,
});

const formattedDate = computed(() => {
    if (!props.article.created_date) return '-';
    const date = new Date(props.article.created_date);
    return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(date);
});
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white shadow-lg">
        <!-- Header Gambar -->
        <div v-if="article.url_thumbnail" class="w-full bg-gray-100">
            <img
                :src="article.url_thumbnail"
                alt="Header Pengumuman"
                class="w-full h-auto object-contain"
            />
        </div>

        <!-- Konten Teks -->
        <div class="p-6 md:p-8">
            <!-- Judul -->
            <h1 class="mb-4 text-3xl font-bold text-gray-800">
                {{ article.judul }}
            </h1>

            <!-- Meta Info -->
            <div class="mb-6 flex items-center text-sm text-gray-500">
                <Calendar class="mr-2 h-4 w-4" />
                <span>Dipublikasikan pada {{ formattedDate }}</span>
            </div>

            <!-- Isi Konten -->
            <div
                class="prose max-w-none"
                v-html="article.content"
            ></div>

            <!-- Lampiran -->
            <div v-if="article.url_attachment" class="mt-8 border-t pt-6">
                <h2 class="mb-3 text-lg font-semibold text-gray-700">
                    Lampiran
                </h2>
                <a
                    :href="article.url_attachment"
                    target="_blank"
                    download
                    class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700"
                >
                    <Download class="mr-2 h-4 w-4" />
                    Unduh {{ article.attachment_name || 'Lampiran' }}
                </a>
            </div>
        </div>
    </div>
</template>

<style>
.prose h1, .prose h2, .prose h3 {
    color: #334155;
}
.prose p {
    margin-bottom: 1rem;
}
.prose a {
    color: #10b981;
    text-decoration: none;
}
.prose a:hover {
    text-decoration: underline;
}
</style>
