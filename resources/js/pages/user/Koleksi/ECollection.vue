<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { AlertCircle, BookOpen, ExternalLink, Sparkles } from 'lucide-vue-next';

// 1. Definisi Interface agar tidak error 'item type unknown'
interface CollectionItem {
    id: number;
    title: string;
    description: string;
    image_path: string | null;
    url: string | null;
    is_active?: boolean;
}

// 2. Definisi Props dengan tipe data yang jelas
defineProps<{
    collections: CollectionItem[];
}>();

const breadcrumb = [{ label: 'Layanan' }, { label: 'E-Collection' }];
</script>

<template>
    <Head title="E-Collection" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Collection">
        <div class="fixed inset-0 -z-10 h-full w-full bg-slate-50">
            <div
                class="absolute top-0 right-0 -mt-20 -mr-20 h-[500px] w-[500px] rounded-full bg-[#99cc33]/10 blur-[80px]"
            ></div>
            <div
                class="absolute bottom-0 left-0 -mb-20 -ml-20 h-[500px] w-[500px] rounded-full bg-emerald-200/20 blur-[80px]"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <div
                class="mx-auto max-w-5xl overflow-hidden rounded-3xl border border-white/50 bg-white/80 shadow-2xl shadow-slate-200/50 backdrop-blur-xl"
            >
                <div
                    class="h-1.5 w-full bg-gradient-to-r from-[#99cc33] via-emerald-400 to-teal-500"
                ></div>

                <div class="p-8 sm:p-10">
                    <!-- <div class="mb-10 flex flex-col items-start sm:flex-row sm:items-center gap-5 border-b border-slate-100 pb-8">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#99cc33]/20 to-emerald-100 shadow-inner text-[#88b82d]">
                            <Library class="h-8 w-8" />
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">
                                Daftar E-Collection
                            </h3>
                            <p class="mt-2 text-slate-500 leading-relaxed max-w-2xl">
                                Jelajahi sumber daya digital kami. Akses jurnal, ebook, dan referensi lainnya dengan mudah.
                            </p>
                        </div>
                    </div> -->

                    <div class="space-y-6">
                        <div
                            v-for="(item, index) in collections"
                            :key="item.id"
                            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-1 transition-all hover:border-[#99cc33]/50 hover:shadow-lg hover:shadow-[#99cc33]/10"
                        >
                            <div
                                class="flex h-full flex-col gap-6 rounded-xl bg-white p-5 md:flex-row md:p-6"
                            >
                                <div
                                    class="flex shrink-0 flex-col items-center justify-center rounded-xl border border-slate-100 bg-slate-50 p-6 transition-colors group-hover:bg-[#99cc33]/5 md:w-48"
                                >
                                    <img
                                        v-if="item.image_path"
                                        :src="item.image_path"
                                        :alt="item.title"
                                        class="max-h-20 w-auto transform object-contain drop-shadow-sm transition-transform duration-500 group-hover:scale-110"
                                    />
                                    <div
                                        v-else
                                        class="flex flex-col items-center text-slate-400"
                                    >
                                        <BookOpen
                                            class="mb-2 h-10 w-10 opacity-40"
                                        />
                                        <span
                                            class="text-[10px] font-bold tracking-wider text-slate-300 uppercase"
                                            >No Image</span
                                        >
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col">
                                    <div
                                        class="mb-4 flex flex-col items-start justify-between gap-4 sm:flex-row"
                                    >
                                        <h4
                                            class="text-lg font-bold text-slate-800 transition-colors group-hover:text-[#7ea82a]"
                                        >
                                            {{ item.title }}
                                        </h4>

                                        <a
                                            v-if="item.url"
                                            :href="item.url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex shrink-0 items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-4 py-1.5 text-xs font-bold text-emerald-700 shadow-sm transition-all hover:border-[#99cc33] hover:bg-[#99cc33] hover:text-white"
                                        >
                                            <span>Buka Tautan</span>
                                            <ExternalLink class="h-3 w-3" />
                                        </a>
                                        <span
                                            v-else
                                            class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold text-slate-400"
                                        >
                                            Info Saja
                                        </span>
                                    </div>

                                    <div
                                        class="rich-text-content text-sm leading-relaxed text-slate-600"
                                        v-html="item.description"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="collections.length === 0"
                            class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-slate-50/50 py-16 text-center"
                        >
                            <div
                                class="mb-4 inline-flex rounded-full bg-white p-4 shadow-sm ring-4 ring-slate-50"
                            >
                                <AlertCircle class="h-10 w-10 text-slate-300" />
                            </div>
                            <h3 class="text-lg font-bold text-slate-700">
                                Belum ada koleksi
                            </h3>
                            <p class="mt-1 text-sm text-slate-400">
                                Data E-Collection belum tersedia saat ini.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-center gap-2 border-t border-slate-100 bg-slate-50 px-8 py-4 text-xs text-slate-400"
                >
                    <Sparkles class="h-3 w-3 text-[#99cc33]" />
                    <span>Perpustakaan Politeknik Negeri Bandung</span>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style>
/* CSS Khusus untuk format HTML dari Database (Rich Text) */
.rich-text-content h4 {
    color: #059669; /* emerald-600 - Lebih soft daripada biru murni */
    font-weight: 700;
    font-size: 0.95rem;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.rich-text-content h4::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    background-color: #99cc33; /* Aksen hijau user */
    border-radius: 50%;
    margin-right: 8px;
}

.rich-text-content p {
    margin-bottom: 0.75rem;
    color: #475569; /* slate-600 */
}

.rich-text-content a {
    color: #059669; /* emerald-600 */
    font-weight: 600;
    text-decoration-line: underline;
    text-decoration-color: #a7f3d0; /* emerald-200 */
    text-underline-offset: 3px;
    transition: all 0.2s;
}

.rich-text-content a:hover {
    color: #047857; /* emerald-700 */
    text-decoration-color: #34d399;
}

/* Kotak Kuning - Dibuat lebih soft (Pastel) */
.rich-text-content .warning-box,
.rich-text-content div[class*='bg-yellow'] {
    background-color: #fffbeb; /* amber-50 */
    border: 1px solid #fcd34d; /* amber-300 */
    color: #92400e; /* amber-800 */
    padding: 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    margin-top: 1.25rem;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
}
</style>
