<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import { ArrowRight, Newspaper } from 'lucide-vue-next';

const props = defineProps({
    articles: {
        type: Array<{
            article_id: string;
            url_thumbnail: string | '';
            judul: string;
            content: string;
            created_date: string;
        }>,
        default: [],
    },
});
</script>

<template>
    <section class="w-full py-4">
        <div class="mx-auto max-w-7xl">
            <!-- Header Section (Consistent with Home) -->
            <div
                class="mb-10 flex flex-col justify-between gap-4 md:flex-row md:items-end"
            >
                <div>
                    <div class="mb-2 flex items-center gap-3">
                        <div
                            class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                        >
                            <Newspaper class="h-6 w-6" />
                        </div>
                        <h2
                            class="text-3xl font-black tracking-tight text-slate-900"
                        >
                            Berita Terbaru
                        </h2>
                    </div>
                    <div
                        class="ml-1 h-1.5 w-24 rounded-full bg-[#99cc33] shadow-sm shadow-[#99cc33]/50"
                    ></div>
                </div>

                <a
                    href="/berita"
                    class="group flex items-center gap-2 rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:border-[#99cc33] hover:text-[#99cc33] hover:shadow-md"
                >
                    Lihat Semua
                    <ArrowRight
                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                    />
                </a>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <BeritaCard
                    v-for="berita in articles"
                    :key="berita.article_id"
                    :id="berita.article_id"
                    :title="berita.judul"
                    :content="berita.content"
                    :thumbnail="berita.url_thumbnail"
                    :date="berita.created_date"
                    class="h-full transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                />
            </div>
        </div>
    </section>
</template>
