<script setup lang="ts">
import { ref, computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3'; 
import {
    Search,
    ExternalLink,
    Globe,
    Book,
    Library,
    Info,
    ArrowRight,
    Sparkles
} from 'lucide-vue-next';

// -- TYPES --
interface LibraryItem {
    id: number;
    name: string;       
    description: string;
    url: string;        
    type: 'journal' | 'ebook';
    img_url: string | null; 
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
</script>

<template>
    <Head title="E-Journal & Database" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Journal & Database">

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
                        {{ filteredItems.length }} Database Tersedia
                    </span>
                </div>

                <TransitionGroup 
                    tag="div" 
                    class="space-y-6 mb-20"
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-6"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="absolute opacity-0"
                >
                    <div
                        v-for="item in filteredItems"
                        :key="item.id"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-[#99cc33]/10 transition-all duration-300 hover:-translate-y-1 flex flex-col md:flex-row gap-8 items-start overflow-hidden"
                    >
                        <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full transition-colors duration-300"
                             :class="activeTab === 'journal' ? 'bg-[#99cc33]' : 'bg-blue-500'">
                        </div>

                        <div class="w-full md:w-32 flex-shrink-0">
                            <div class="aspect-square w-32 h-32 rounded-2xl bg-slate-50 border border-slate-100 p-4 flex items-center justify-center group-hover:bg-white group-hover:border-[#99cc33]/30 transition-all duration-300">
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

                        <div class="flex-1 flex flex-col h-full min-h-[128px]">
                            
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-[#99cc33] transition-colors">
                                        {{ item.name }}
                                    </h3>
                                    
                                    <span class="inline-flex w-fit items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border"
                                        :class="activeTab === 'journal' ? 'bg-[#99cc33]/5 text-[#7da62b] border-[#99cc33]/20' : 'bg-blue-50 text-blue-600 border-blue-100'">
                                        <Sparkles class="w-3.5 h-3.5" />
                                        {{ activeTab === 'journal' ? 'Jurnal' : 'E-Book' }}
                                    </span>
                                </div>

                                <div class="mb-5">
                                    <p class="text-slate-600 text-base leading-relaxed">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>

                            <div class="pt-5 border-t border-slate-50 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2 text-sm font-medium text-slate-400">
                                    <Info class="w-4 h-4" />
                                    <span>Akses via IP Polban</span>
                                </div>

                                <a
                                    :href="item.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white text-sm font-bold shadow-md transition-all duration-300 hover:shadow-lg transform active:scale-95"
                                    :class="activeTab === 'journal' 
                                        ? 'bg-[#99cc33] hover:bg-[#8ebf2f] shadow-[#99cc33]/20' 
                                        : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'"
                                >
                                    Buka Database
                                    <ArrowRight class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                </TransitionGroup>

                <div v-if="filteredItems.length === 0" class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <Search class="w-10 h-10 text-slate-300" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Tidak Ditemukan</h3>
                    <p class="text-slate-500 mb-6">
                        Tidak ada data dengan kata kunci "<span class="font-bold">{{ searchQuery }}</span>".
                    </p>
                    <button 
                        @click="searchQuery = ''" 
                        class="text-sm font-bold hover:underline"
                        :class="activeTab === 'journal' ? 'text-[#99cc33]' : 'text-blue-600'"
                    >
                        Bersihkan Pencarian
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