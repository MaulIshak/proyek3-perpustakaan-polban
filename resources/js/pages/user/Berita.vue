<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import PaginationLink from '@/components/PaginationLink.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { Search, FileX } from 'lucide-vue-next'; // Tambah FileX untuk empty state
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
}>();

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Arsip' },
    { label: 'Berita' },
];

// State pencarian
const search = ref(props.searchQuery || '');

const searchArticles = debounce(() => {
    router.get(
        '/berita',
        { search: search.value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);

watch(search, searchArticles);

const paginationLinks = computed(() => {
    return props.articles.links.filter(
        (link) => link.url || link.label.includes('...'),
    );
});
</script>

<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Arsip Berita">

        <!-- Background Decoration -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative min-h-[60vh]">

            <!-- 1. Search Bar Modern -->
            <div class="max-w-2xl mx-auto mb-12 -mt-16 relative z-20">
                <div class="relative group">
                    <!-- Shadow Effect -->
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
            </div>

            <!-- 2. Content Area -->
            <div v-if="props.articles.data.length > 0">
                <!-- Grid Berita -->
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3 mb-12">
                    <BeritaCard
                        v-for="berita in props.articles.data"
                        :key="berita.article_id"
                        :id="berita.article_id"
                        :title="berita.judul"
                        :content="berita.content"
                        :thumbnail="berita.url_thumbnail || '/hero-bg.jpg'"
                        :date="berita.created_date"
                        class="h-full transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                    />
                </div>

                <!-- Pagination & Info -->
                <div class="flex flex-col items-center justify-between gap-6 sm:flex-row border-t border-slate-200 pt-8">
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
                </div>
            </div>

            <!-- 3. Empty State -->
            <div v-else class="flex flex-col items-center justify-center py-24 text-center">
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
            </div>

        </div>
    </UserAppLayout>
</template>
