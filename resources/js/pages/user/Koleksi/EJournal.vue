<script setup lang="ts">
import { ref, computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3';
import ScrollReveal from '@/components/ScrollReveal.vue'; // Pastikan path ini sesuai
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

// -- PROPS --
const props = defineProps<{
    journals: LibraryItem[];
}>();

// -- STATE --
const activeTab = ref<'journal' | 'ebook'>('journal');
const searchQuery = ref('');

// -- BREADCRUMB --
const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Koleksi' },
    { label: 'Referensi Digital' },
];

// -- LOGIC --
const currentSource = computed(() => {
    return props.journals.filter(item => item.type === activeTab.value);
});

const filteredItems = computed(() => {
    if (!searchQuery.value) return currentSource.value;

    const query = searchQuery.value.toLowerCase();
    return currentSource.value.filter(item =>
        item.name.toLowerCase().includes(query) ||
        item.description.toLowerCase().includes(query)
    );
});

const switchTab = (tab: 'journal' | 'ebook') => {
    activeTab.value = tab;
    searchQuery.value = '';
};

// -- HELPER --
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
</script>

<template>
    <Head title="E-Journal & E-Book" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Journal & E-Book">
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-slate-50">
            <div class="absolute top-[-10%] right-[-5%] w-[800px] h-[800px] bg-gradient-to-br from-[#99cc33]/15 to-emerald-200/20 rounded-full blur-3xl opacity-70 mix-blend-multiply animate-pulse-slow"></div>
            <div class="absolute top-[20%] left-[-10%] w-[600px] h-[600px] bg-gradient-to-tr from-blue-200/15 to-indigo-200/20 rounded-full blur-3xl opacity-70 mix-blend-multiply"></div>
        </div>

        <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 relative min-h-screen">
            <div class="max-w-6xl mx-auto">

                <ScrollReveal animation="fade-up" :duration="800" :delay="100" class="flex justify-center mb-8 sm:mb-10 relative z-20">
                    <div class="bg-white p-1.5 sm:p-2 rounded-2xl shadow-sm border border-slate-200 inline-flex w-full sm:w-auto gap-2 sm:gap-3">
                        <button
                            v-for="tab in (['journal', 'ebook'] as const)"
                            :key="tab"
                            @click="switchTab(tab)"
                            class="flex-1 sm:flex-none justify-center items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300 flex"
                            :class="activeTab === tab
                                ? (tab === 'journal' ? 'bg-[#99cc33] text-white shadow-md shadow-[#99cc33]/20' : 'bg-blue-500 text-white shadow-md shadow-blue-500/20')
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
                        >
                            <component :is="tab === 'journal' ? Library : Book" class="w-4 h-4 sm:w-5 sm:h-5" />
                            {{ tab === 'journal' ? 'E-Journals' : 'E-Books' }}
                        </button>
                    </div>
                </ScrollReveal>

                <ScrollReveal animation="zoom-in" :duration="600" :delay="200" class="max-w-3xl mx-auto mb-8 sm:mb-12 relative z-20">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 sm:pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#99cc33] transition-colors">
                            <Search class="w-5 h-5 sm:w-6 sm:h-6" />
                        </div>
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="w-full pl-12 sm:pl-14 pr-6 py-3.5 sm:py-4 rounded-full border-2 border-slate-100 bg-white shadow-xl shadow-slate-200/40 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none text-base sm:text-lg text-slate-700 placeholder:text-slate-400 font-medium"
                            :placeholder="`Cari referensi ${activeTab === 'journal' ? 'Jurnal' : 'E-Book'}...`"
                        />
                    </div>
                </ScrollReveal>

                <ScrollReveal animation="fade-in" :duration="800" :delay="300" class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 px-2 gap-3">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="w-1.5 sm:w-2 h-6 sm:h-8 rounded-full transition-colors duration-500" :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'"></span>
                        Koleksi {{ activeTab === 'journal' ? 'E-Journal' : 'E-Book' }}
                    </h2>
                    <span class="text-xs sm:text-sm font-medium px-4 py-1.5 rounded-full bg-white border border-slate-200 text-slate-500 shadow-sm">
                        {{ filteredItems.length }} Referensi
                    </span>
                </ScrollReveal>

                <TransitionGroup
                    tag="div"
                    class="space-y-6 mb-20 min-h-[300px]"
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="absolute w-full opacity-0 z-0"
                >
                    <ScrollReveal
                        v-for="(item, index) in filteredItems"
                        :key="item.id"
                        animation="fade-up"
                        :duration="700"
                        :delay="index < 5 ? index * 100 : 0"
                        class="w-full"
                    >
                        <div
                            class="group relative bg-white rounded-3xl p-5 sm:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-[#99cc33]/10 transition-all duration-300 hover:-translate-y-1 flex flex-col md:flex-row gap-5 sm:gap-8 items-start overflow-hidden h-full z-10"
                        >
                            <div class="absolute left-0 top-6 bottom-6 w-1 sm:w-1.5 rounded-r-full transition-colors duration-300"
                                 :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'">
                            </div>

                            <div class="w-full md:w-32 flex-shrink-0 flex justify-center md:block">
                                <div class="aspect-[4/3] md:aspect-square w-full max-w-[160px] md:w-32 rounded-2xl bg-slate-50 border border-slate-100 p-4 flex items-center justify-center group-hover:bg-white group-hover:border-[#99cc33]/30 transition-all duration-300">
                                    <img
                                        v-if="item.img_url"
                                        :src="item.img_url"
                                        :alt="item.name"
                                        class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300"
                                    />
                                    <div v-else class="flex flex-col items-center text-slate-300">
                                        <component :is="activeTab === 'journal' ? Library : Book" class="w-10 h-10 sm:w-12 sm:h-12" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 flex flex-col h-full w-full">
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-3">
                                        <h3 class="text-lg sm:text-xl font-bold text-slate-800 group-hover:text-[#99cc33] transition-colors leading-tight">
                                            {{ item.name }}
                                        </h3>

                                        <span class="inline-flex w-fit items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] sm:text-xs font-bold uppercase tracking-wide border whitespace-nowrap"
                                            :class="activeTab === 'journal' ? 'bg-[#99cc33]/5 text-[#7da62b] border-[#99cc33]/20' : 'bg-blue-50 text-blue-600 border-blue-100'">
                                            <Sparkles class="w-3 h-3" />
                                            {{ activeTab === 'journal' ? 'Jurnal' : 'E-Book' }}
                                        </span>
                                    </div>

                                    <div class="mb-5 text-slate-600 text-sm sm:text-base leading-relaxed space-y-2">
                                        <template v-for="(block, idx) in parseDescription(item.description)" :key="idx">
                                            <div v-if="block.type === 'list'" class="flex items-start gap-2 pl-2">
                                                <span class="mt-2 w-1.5 h-1.5 rounded-full shrink-0"
                                                      :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'">
                                                </span>
                                                <span>{{ block.content }}</span>
                                            </div>
                                            <p v-else>{{ block.content }}</p>
                                        </template>
                                    </div>

                                    <div v-if="item.additional_links && item.additional_links.length > 0" class="mb-5 pt-3 border-t border-dashed border-slate-100">
                                        <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Link Terkait:</p>
                                        <div class="flex flex-wrap gap-2 sm:gap-3">
                                            <a
                                                v-for="(link, lIdx) in item.additional_links"
                                                :key="lIdx"
                                                :href="link.url"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm font-bold hover:bg-[#99cc33]/10 hover:border-[#99cc33]/50 hover:text-[#7da62b] transition-all group/link"
                                            >
                                                <Link2 class="w-3 h-3 opacity-50 group-hover/link:opacity-100" />
                                                {{ link.label }}
                                                <ExternalLink class="w-2.5 h-2.5 opacity-30 group-hover/link:opacity-100" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 sm:pt-5 border-t border-slate-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-slate-400">
                                        <Info class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                        <span>Akses via IP Polban</span>
                                    </div>

                                    <a
                                        :href="item.url"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-2.5 rounded-xl text-white text-sm font-bold shadow-md transition-all duration-300 hover:shadow-lg transform active:scale-95"
                                        :class="activeTab === 'journal'
                                            ? 'bg-[#99cc33] hover:bg-[#8ebf2f] shadow-[#99cc33]/20'
                                            : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'"
                                    >
                                        Buka Referensi
                                        <ArrowRight class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </ScrollReveal>
                </TransitionGroup>

                <ScrollReveal
                    v-if="filteredItems.length === 0"
                    animation="fade-up"
                    class="flex flex-col items-center justify-center py-16 sm:py-20 bg-white rounded-3xl border border-dashed border-slate-200"
                >
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <Search class="w-8 h-8 sm:w-10 sm:h-10 text-slate-300" />
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-1">Tidak Ditemukan</h3>
                    <p class="text-sm sm:text-base text-slate-500 mb-6 text-center px-4">
                        Tidak ada data dengan kata kunci "<span class="font-bold">{{ searchQuery }}</span>".
                    </p>
                    <button
                        @click="searchQuery = ''"
                        class="text-sm font-bold hover:underline"
                        :class="activeTab === 'journal' ? 'text-[#99cc33]' : 'text-blue-600'"
                    >
                        Bersihkan Pencarian
                    </button>
                </ScrollReveal>

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
