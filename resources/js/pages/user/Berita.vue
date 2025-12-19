<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import PaginationLink from '@/components/PaginationLink.vue';
import ScrollReveal from '@/components/ScrollReveal.vue'; // Import ScrollReveal
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { FileX, Search, ArrowUpDown } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

// Tipe data
interface Article {
    article_id: string;
    judul: string;
    content: string;
    url_thumbnail: string;
    created_date: string;
}

const props = defineProps<{
    articles: {
        data: Article[];
        links: {
            url: string | null;
            label: string;
            active: boolean;
        }[];
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
    searchQuery: string | null;
    sortFilter: string;
}>();

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Arsip' },
    { label: 'Berita' },
];

// State pencarian
const search = ref(props.searchQuery || '');
const sort = ref(props.sortFilter || 'desc');

const searchArticles = debounce(() => {
    router.get(
        '/berita',
        { search: search.value, sort: sort.value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);

watch(search, searchArticles);

const sortArticles = debounce(() => {
    router.get(
        '/berita',
        { search: search.value, sort: sort.value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);

watch(sort, sortArticles);

const paginationLinks = computed(() => {
    return props.articles.links.filter(
        (link) => link.url || link.label.includes('...'),
    );
});
</script>

<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Arsip Berita">

        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative min-h-[60vh] mt-10">

            <ScrollReveal
                animation="zoom-in"
                :duration="600"
                class="max-w-4xl mx-auto mb-4 -mt-16 relative z-20"
            >
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                    <!-- Search -->
                    <div class="relative group flex-1 max-w-md">
                        <div class="absolute inset-0 bg-[#99cc33]/20 rounded-full blur-md opacity-0 group-focus-within:opacity-100 transition-opacity duration-300"></div>

                        <div class="relative bg-white rounded-full shadow-lg shadow-slate-200/50 flex items-center px-2 py-1.5 border border-slate-100 focus-within:border-[#99cc33] transition-colors">
                            <div class="pl-4 pr-2 text-slate-400 group-focus-within:text-[#99cc33] transition-colors">
                                <Search class="w-6 h-6" />
                            </div>
                            <input
                                type="text"
                                placeholder="Cari judul atau topik berita..."
                                v-model="search"
                                class="w-full bg-transparent border-none outline-none text-slate-700 placeholder:text-slate-400 h-12 text-base focus:ring-0"
                            />
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="flex items-center gap-2">
                        <ArrowUpDown class="w-5 h-5 text-slate-400" />
                        <select
                            v-model="sort"
                            class="rounded-full border border-slate-100 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-lg shadow-slate-200/50 focus:border-[#99cc33] focus:outline-none focus:ring-2 focus:ring-[#99cc33]/20 transition-colors"
                        >
                            <option value="desc">Terbaru</option>
                            <option value="asc">Terlama</option>
                        </select>
                    </div>
                </div>
            </ScrollReveal>

            <div v-if="props.articles.data.length > 0">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3 mb-12">
                    <ScrollReveal
                        v-for="(berita, index) in props.articles.data"
                        :key="berita.article_id"
                        animation="fade-up"
                        :delay="index * 100"
                        class="h-full"
                    >
                        <BeritaCard
                            :id="berita.article_id"
                            :title="berita.judul"
                            :content="berita.content"
                            :thumbnail="berita.url_thumbnail || '/hero-bg.jpg'"
                            :date="berita.created_date"
                            class="h-full transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                        />
                    </ScrollReveal>
                </div>

                <ScrollReveal
                    animation="fade-in"
                    :delay="300"
                    class="flex flex-col items-center justify-between gap-6 sm:flex-row border-t border-slate-200 pt-8"
                >
                    <div class="text-sm text-slate-500 font-medium bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                        Menampilkan <span class="text-[#99cc33] font-bold">{{ props.articles.from }}</span> - <span class="text-[#99cc33] font-bold">{{ props.articles.to }}</span> dari <span class="text-slate-800 font-bold">{{ props.articles.total }}</span> berita
                    </div>

                    <nav class="isolate inline-flex -space-x-px rounded-xl shadow-sm bg-white p-1 border border-slate-100">
                        <PaginationLink
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            :link="link"
                        />
                    </nav>
                </ScrollReveal>
            </div>

            <ScrollReveal
                v-else
                animation="zoom-in"
                :duration="500"
                class="flex flex-col items-center justify-center py-24 text-center"
            >
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-6 animate-pulse">
                    <FileX class="w-10 h-10 text-slate-400" />
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2">
                    Berita Tidak Ditemukan
                </h3>
                <p class="text-slate-500 max-w-md leading-relaxed">
                    Maaf, kami tidak dapat menemukan berita dengan kata kunci "<span class="text-[#99cc33] font-semibold">{{ search }}</span>". Silakan coba kata kunci lain.
                </p>
                <button
                    @click="search = ''"
                    class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
                >
                    Reset Pencarian
                </button>
            </ScrollReveal>

        </div>
    </UserAppLayout>
</template>
