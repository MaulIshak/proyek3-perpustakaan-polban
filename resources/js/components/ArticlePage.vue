<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    CalendarDays,
    Download,
    FileText,
    User,
} from 'lucide-vue-next';
import { computed } from 'vue';

// Define props
const props = defineProps<{
    article: {
        title: string;
        imageUrl: string;
        content: string;
        publishedAt?: string;
        url_attachment?: string;
        attachment_name?: string;
        type: 'berita' | 'pengumuman';
        author?: string;
    };
    isAdmin?: boolean;
}>();

// Format Date
const formattedDate = computed(() => {
    if (!props.article.publishedAt) return null;
    return new Date(props.article.publishedAt).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});

const backUrl = computed(() => {
    return props.article.type === 'berita' ? '/berita' : '/pengumuman';
});

const categoryLabel = computed(() => {
    return props.article.type === 'berita' ? 'Berita' : 'Pengumuman';
});

const authorName = computed(() => {
    return props.article.author;
});
</script>

<template>
    <div
        class="relative w-full sm:container sm:mx-auto sm:px-6 sm:py-10 lg:px-8"
    >
        <div
            class="mx-auto max-w-5xl overflow-hidden rounded-none border-none bg-white shadow-none sm:rounded sm:border sm:border-slate-100 sm:shadow-xl sm:shadow-slate-200/60"
        >
            <div
                class="border-b border-slate-100 p-6 sm:p-10"
                :v-show="!props.isAdmin"
            >
                <Link
                    :href="backUrl"
                    class="group mb-6 inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition-colors hover:text-[#99cc33] sm:mb-8"
                >
                    <div
                        class="rounded-full bg-slate-50 p-1.5 transition-colors group-hover:bg-[#99cc33]/10"
                    >
                        <ArrowLeft
                            class="h-4 w-4 transition-transform group-hover:-translate-x-1"
                        />
                    </div>
                    Kembali ke {{ categoryLabel }}
                </Link>

                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <span
                        class="rounded-full px-3 py-1 text-[10px] font-bold tracking-wider uppercase sm:text-xs"
                        :class="
                            article.type === 'berita'
                                ? 'bg-[#99cc33]/10 text-[#99cc33]'
                                : 'bg-amber-100 text-amber-600'
                        "
                    >
                        {{ categoryLabel }}
                    </span>
                    <span
                        v-if="formattedDate"
                        class="flex items-center gap-1.5 text-[10px] font-medium text-slate-400 sm:text-xs"
                    >
                        <CalendarDays class="h-3.5 w-3.5" />
                        {{ formattedDate }}
                    </span>
                </div>

                <h1
                    class="mb-6 text-2xl leading-tight font-bold tracking-tight text-slate-900 sm:text-4xl md:text-5xl"
                >
                    {{ article.title }}
                </h1>

                <div
                    class="flex items-center gap-3 border-t border-slate-50 pt-6"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                    >
                        <User class="h-5 w-5" />
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold tracking-wide text-slate-400 uppercase"
                        >
                            Ditulis oleh
                        </span>
                        <span class="text-sm font-semibold text-slate-700">
                            {{ authorName }}
                        </span>
                    </div>
                </div>
            </div>

            <div v-if="article.imageUrl" class="w-full">
                <div
                    v-if="article.type === 'berita'"
                    class="relative aspect-video w-full overflow-hidden"
                >
                    <img
                        :src="article.imageUrl"
                        :alt="article.title"
                        class="h-full w-full object-cover transition-transform duration-700"
                    />
                </div>

                <div
                    v-else
                    class="flex w-full justify-center bg-slate-100/50 p-4 sm:p-10"
                >
                    <img
                        :src="article.imageUrl"
                        :alt="article.title"
                        class="max-h-[80vh] w-auto max-w-full rounded-xl shadow-lg"
                    />
                </div>
            </div>

            <div class="p-6 sm:p-12">
                <div
                    class="prose prose-base max-w-none prose-slate sm:prose-lg prose-headings:font-bold prose-headings:text-slate-800 prose-p:leading-relaxed prose-p:text-slate-600 prose-a:text-[#99cc33] prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-img:shadow-md"
                    v-html="article.content"
                ></div>

                <div
                    v-if="article.url_attachment"
                    class="mt-12 border-t border-dashed border-slate-200 pt-8"
                >
                    <h3
                        class="mb-4 flex items-center gap-2 text-sm font-bold tracking-wider text-slate-400 uppercase"
                    >
                        <FileText class="h-4 w-4" />
                        Lampiran Dokumen
                    </h3>

                    <a
                        :href="article.url_attachment"
                        target="_blank"
                        :download="article.attachment_name"
                        class="group flex flex-col items-start justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 transition-all duration-300 hover:border-[#99cc33] hover:bg-[#99cc33]/5 sm:flex-row sm:items-center"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="rounded-lg border border-slate-100 bg-white p-3 shadow-sm transition-transform group-hover:scale-110"
                            >
                                <FileText class="h-6 w-6 text-[#99cc33]" />
                            </div>
                            <div class="overflow-hidden">
                                <p
                                    class="truncate font-bold text-slate-700 transition-colors group-hover:text-[#99cc33]"
                                >
                                    {{
                                        article.attachment_name ||
                                        'Dokumen Lampiran'
                                    }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    Klik untuk mengunduh
                                </p>
                            </div>
                        </div>

                        <div
                            class="hidden rounded-full bg-white p-2 text-slate-400 shadow-sm transition-all group-hover:bg-[#99cc33] group-hover:text-white sm:flex"
                        >
                            <Download class="h-5 w-5" />
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
