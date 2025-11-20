<script setup lang="ts">
import PaginationLink from '@/components/PaginationLink.vue';
import PengumumanCard from '@/components/PengumumanCard.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { Megaphone, Search } from 'lucide-vue-next';
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
    { label: 'Pengumuman' },
];

// State pencarian
const search = ref(props.searchQuery || '');

const searchArticles = debounce(() => {
    router.get(
        '/pengumuman',
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
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Pengumuman">
        <!-- Background Decoration -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div
            class="relative container mx-auto min-h-[60vh] px-4 py-10 sm:px-6 lg:px-8"
        >
            <!-- 1. Search Bar Modern -->
            <div class="relative z-20 mx-auto -mt-16 mb-12 max-w-2xl">
                <div class="group relative">
                    <!-- Shadow Effect -->
                    <div
                        class="absolute inset-0 rounded-full bg-[#99cc33]/20 opacity-0 blur-md transition-opacity duration-300 group-focus-within:opacity-100"
                    ></div>

                    <div
                        class="relative flex items-center rounded-full border border-slate-100 bg-white px-2 py-1.5 shadow-lg shadow-slate-200/50 transition-colors focus-within:border-[#99cc33]"
                    >
                        <div
                            class="pr-2 pl-4 text-slate-400 transition-colors group-focus-within:text-[#99cc33]"
                        >
                            <Search class="h-6 w-6" />
                        </div>
                        <input
                            type="text"
                            placeholder="Cari pengumuman..."
                            v-model="search"
                            class="h-12 w-full border-none bg-transparent text-base text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0"
                        />
                    </div>
                </div>
            </div>

            <!-- 2. Content Area -->
            <div v-if="props.articles.data.length > 0">
                <!-- List Pengumuman (Vertical Stack) -->
                <div class="mx-auto mb-12 max-w-5xl space-y-6">
                    <PengumumanCard
                        v-for="pengumuman in props.articles.data"
                        :key="pengumuman.article_id"
                        :id="pengumuman.article_id"
                        :title="pengumuman.judul"
                        :content="pengumuman.content"
                        :date="pengumuman.created_date"
                    />
                </div>

                <!-- Pagination & Info -->
                <div
                    class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-6 border-t border-slate-200 pt-8 sm:flex-row"
                >
                    <div
                        class="rounded-full border border-slate-100 bg-white px-4 py-2 text-sm font-medium text-slate-500 shadow-sm"
                    >
                        Menampilkan
                        <span class="font-bold text-[#99cc33]">{{
                            props.articles.from
                        }}</span>
                        -
                        <span class="font-bold text-[#99cc33]">{{
                            props.articles.to
                        }}</span>
                        dari
                        <span class="font-bold text-slate-800">{{
                            props.articles.total
                        }}</span>
                        pengumuman
                    </div>

                    <nav
                        class="isolate inline-flex -space-x-px rounded-xl border border-slate-100 bg-white p-1 shadow-sm"
                    >
                        <PaginationLink
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            :link="link"
                        />
                    </nav>
                </div>
            </div>

            <!-- 3. Empty State -->
            <div
                v-else
                class="flex flex-col items-center justify-center py-24 text-center"
            >
                <div
                    class="mb-6 flex h-24 w-24 animate-pulse items-center justify-center rounded-full bg-slate-100"
                >
                    <Megaphone class="h-10 w-10 text-slate-400" />
                </div>
                <h3 class="mb-2 text-2xl font-black text-slate-800">
                    Pengumuman Tidak Ditemukan
                </h3>
                <p class="max-w-md leading-relaxed text-slate-500">
                    Maaf, kami tidak dapat menemukan pengumuman dengan kata
                    kunci "<span class="font-semibold text-[#99cc33]">{{
                        search
                    }}</span
                    >". Silakan coba kata kunci lain.
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
