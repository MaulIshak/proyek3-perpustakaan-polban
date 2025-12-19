<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import PaginationLink from '@/components/PaginationLink.vue'; // Pastikan komponen ini ada (dari percakapan sebelumnya)
import { Head, router } from '@inertiajs/vue3';
import { debounce } from 'lodash'; // Pastikan lodash terinstall: npm i lodash @types/lodash
import {
    Search,
    ExternalLink,
    Book,
    Library,
    Info,
    ArrowRight,
    Sparkles,
    Link2
} from 'lucide-vue-next';

// -- TYPES --
interface AdditionalLink {
    label: string;
    url: string;
}

interface LibraryItem {
    id: number;
    name: string;
    description: string;
    url: string;
    additional_links: AdditionalLink[] | null;
    type: 'journal' | 'ebook';
    img_url: string | null;
}

interface DescriptionBlock {
    type: 'list' | 'p';
    content: string;
}

// -- PROPS (Updated untuk Pagination Laravel) --
const props = defineProps<{
    // Struktur ini cocok dengan return $query->paginate() dari Laravel
    journals: {
        data: LibraryItem[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        current_page: number;
        from: number;
        to: number;
        total: number;
    };
    // Menerima state filter dari backend agar sinkron saat refresh
    filters?: {
        search?: string;
        type?: 'journal' | 'ebook';
    };
}>();

// -- STATE --
// Ambil default dari props filters (jika ada) atau default value
const activeTab = ref<'journal' | 'ebook'>(props.filters?.type || 'journal');
const searchQuery = ref(props.filters?.search || '');

// -- BREADCRUMB --
const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Koleksi' },
    { label: 'Referensi Digital' },
];

// -- LOGIC SERVER SIDE --

// 1. Fungsi Request Data
const fetchData = () => {
    router.get(
        // URL saat ini
        window.location.pathname,
        {
            search: searchQuery.value,
            type: activeTab.value
        },
        {
            preserveState: true, // Jaga state komponen
            preserveScroll: true, // Jaga posisi scroll
            replace: true, // Ganti history browser agar rapi
        }
    );
};

// 2. Watch Search (Debounce agar hemat request)
watch(searchQuery, debounce(() => {
    fetchData();
}, 500));

// 3. Watch Tab (Langsung request saat ganti tab)
const switchTab = (tab: 'journal' | 'ebook') => {
    activeTab.value = tab;
    searchQuery.value = ''; // Reset search saat ganti tab (opsional, tergantung UX yg dimau)
    fetchData();
};

// -- HELPER: PARSE DESKRIPSI --
const parseDescription = (text: string): DescriptionBlock[] => {
    if (!text) return [];

    return text.split('\n').map((line): DescriptionBlock | null => {
        const trimmed = line.trim();
        if (!trimmed) return null;

        if (trimmed.startsWith('- ') || trimmed.startsWith('* ')) {
            return { type: 'list', content: trimmed.substring(2) };
        }
        return { type: 'p', content: trimmed };
    })
    .filter((item): item is DescriptionBlock => item !== null);
};

// Helper untuk membersihkan link pagination (filter link prev/next bawaan jika mau custom, atau pakai semua)
const paginationLinks = computed(() => {
    return props.journals.links;
});
</script>

<template>
    <Head title="E-Journal & E-Book" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Journal & E-Book">

        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-slate-50">
            <div class="absolute top-[-10%] right-[-5%] w-[800px] h-[800px] bg-gradient-to-br from-[#99cc33]/15 to-emerald-200/20 rounded-full blur-3xl opacity-70 mix-blend-multiply animate-pulse-slow"></div>
            <div class="absolute top-[20%] left-[-10%] w-[600px] h-[600px] bg-gradient-to-tr from-blue-200/15 to-indigo-200/20 rounded-full blur-3xl opacity-70 mix-blend-multiply"></div>
        </div>

        <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 relative">

            <div class="max-w-6xl mx-auto">

                <div class="flex justify-center mb-10 relative z-20">
                    <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 inline-flex gap-3">
                        <button
                            @click="switchTab('journal')"
                            class="flex items-center gap-2.5 px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'journal'
                                ? 'bg-[#99cc33] text-white shadow-md shadow-[#99cc33]/20'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
                        >
                            <Library class="w-5 h-5" />
                            E-Journals
                        </button>

                        <button
                            @click="switchTab('ebook')"
                            class="flex items-center gap-2.5 px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300"
                            :class="activeTab === 'ebook'
                                ? 'bg-blue-500 text-white shadow-md shadow-blue-500/20'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
                        >
                            <Book class="w-5 h-5" />
                            E-Books
                        </button>
                    </div>
                </div>

                <div class="max-w-3xl mx-auto mb-12 relative z-20">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#99cc33] transition-colors">
                            <Search class="w-6 h-6" />
                        </div>
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="w-full pl-14 pr-6 py-4 rounded-full border-2 border-slate-100 bg-white shadow-xl shadow-slate-200/40 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none text-lg text-slate-700 placeholder:text-slate-400 font-medium"
                            :placeholder="`Cari referensi di koleksi ${activeTab === 'journal' ? 'Jurnal' : 'E-Book'}...`"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6 px-2">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="w-2 h-8 rounded-full" :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'"></span>
                        Koleksi {{ activeTab === 'journal' ? 'E-Journal' : 'E-Book' }}
                    </h2>
                    <span class="text-sm font-medium px-4 py-1.5 rounded-full bg-white border border-slate-200 text-slate-500">
                        {{ journals.total }} referensi Tersedia
                    </span>
                </div>

                <TransitionGroup
                    tag="div"
                    class="space-y-4 mb-8"
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-6"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="absolute opacity-0"
                >
                    <div
                        v-for="item in journals.data"
                        :key="item.id"
                        class="group relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-[#99cc33]/10 transition-all duration-300 hover:-translate-y-1 flex flex-col md:flex-row gap-4 items-start overflow-hidden"
                    >
                        <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full transition-colors duration-300"
                             :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'">
                        </div>

                        <div class="w-full md:w-24 flex-shrink-0">
                            <div class="aspect-square w-24 h-24 rounded-2xl bg-slate-50 border border-slate-100 p-3 flex items-center justify-center group-hover:bg-white group-hover:border-[#99cc33]/30 transition-all duration-300">
                                <img
                                    v-if="item.img_url"
                                    :src="item.img_url"
                                    :alt="item.name"
                                    class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300"
                                />
                                <div v-else class="flex flex-col items-center text-slate-300">
                                    <Library v-if="activeTab === 'journal'" class="w-12 h-12" />
                                    <Book v-else class="w-12 h-12" />
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col h-full min-h-[88px]">

                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-[#99cc33] transition-colors">
                                        {{ item.name }}
                                    </h3>

                                    <span class="inline-flex w-fit items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border"
                                        :class="activeTab === 'journal' ? 'bg-[#99cc33]/5 text-[#7da62b] border-[#99cc33]/20' : 'bg-blue-50 text-blue-600 border-blue-100'">
                                        <Sparkles class="w-3.5 h-3.5" />
                                        {{ activeTab === 'journal' ? 'Jurnal' : 'E-Book' }}
                                    </span>
                                </div>

                                <div class="mb-3 text-slate-600 text-sm leading-snug space-y-1">
                                    <template v-for="(block, idx) in parseDescription(item.description)" :key="idx">
                                        <div v-if="block.type === 'list'" class="flex items-start gap-2 pl-2">
                                            <span class="mt-1 w-1.5 h-1.5 rounded-full shrink-0"
                                                  :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'">
                                            </span>
                                            <span>{{ block.content }}</span>
                                        </div>
                                        <p v-else>{{ block.content }}</p>
                                    </template>
                                </div>

                                <div v-if="item.additional_links && item.additional_links.length > 0" class="mb-4 pt-2 border-t border-dashed border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Link Terkait:</p>
                                    <div class="flex flex-wrap gap-3">
                                        <a
                                            v-for="(link, lIdx) in item.additional_links"
                                            :key="lIdx"
                                            :href="link.url"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold hover:bg-[#99cc33]/10 hover:border-[#99cc33]/50 hover:text-[#7da62b] transition-all group/link"
                                        >
                                            <Link2 class="w-3.5 h-3.5 opacity-50 group-hover/link:opacity-100" />
                                            {{ link.label }}
                                            <ExternalLink class="w-3 h-3 opacity-30 group-hover/link:opacity-100" />
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-50 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-2 text-sm font-medium text-slate-400">
                                    <Info class="w-4 h-4" />
                                    <span>Akses via IP Polban</span>
                                </div>

                                <a
                                    :href="item.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-sm font-bold shadow-md transition-all duration-300 hover:shadow-lg transform active:scale-95"
                                    :class="activeTab === 'journal'
                                        ? 'bg-[#99cc33] hover:bg-[#8ebf2f] shadow-[#99cc33]/20'
                                        : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'"
                                >
                                    Buka Referensi Utama
                                    <ArrowRight class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                </TransitionGroup>

                <div v-if="journals.data.length > 0" class="flex flex-col items-center justify-between gap-4 sm:flex-row border-t border-slate-200 pt-6 pb-8">
                    <div class="text-sm text-slate-500 font-medium bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                        Menampilkan <span class="text-[#99cc33] font-bold">{{ journals.from }}</span> - <span class="text-[#99cc33] font-bold">{{ journals.to }}</span> dari <span class="text-slate-800 font-bold">{{ journals.total }}</span> referensi
                    </div>

                    <nav class="isolate inline-flex -space-x-px rounded-xl shadow-sm bg-white p-1 border border-slate-100">
                        <PaginationLink
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            :link="link"
                        />
                    </nav>
                </div>

                <div v-if="journals.data.length === 0" class="flex flex-col items-center justify-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                        <Search class="w-8 h-8 text-slate-300" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Tidak Ditemukan</h3>
                    <p class="text-slate-500 mb-4">
                        Tidak ada data dengan kata kunci "<span class="font-bold">{{ searchQuery }}</span>".
                    </p>
                    <button
                        @click="switchTab('journal')"
                        class="text-sm font-bold hover:underline"
                        :class="activeTab === 'journal' ? 'text-[#99cc33]' : 'text-blue-600'"
                    >
                        Reset Pencarian
                    </button>
                </div>

            </div>
        </div>
    </Layout>
</template>

<style scoped>
@keyframes pulse-slow {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.05); }
}
.animate-pulse-slow {
    animation: pulse-slow 8s infinite ease-in-out;
}
</style>
