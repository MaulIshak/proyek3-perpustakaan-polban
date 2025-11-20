<script setup lang="ts">
import { ref, computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3'; // Optional: untuk title tab browser
import {
    Search,
    ExternalLink,
    BookOpen,
    AlertCircle,
    Globe,
    ShieldAlert,
    CheckCircle2
} from 'lucide-vue-next';

// 1. Definisi Interface untuk TypeScript (Optional tapi Good Practice)
interface EJournal {
    id: number;
    name: string;       // Sesuai kolom DB
    subject: string;    // Sesuai kolom DB
    url: string;        // Sesuai kolom DB
    img_url: string | null; // Dari Accessor di Model
}

// 2. Terima Data dari Controller via Props
const props = defineProps<{
    journals: EJournal[]
}>();

// 3. Breadcrumb
const breadcrumb = [
    { label: 'Koleksi' },
    { label: 'E-Journal' },
];

// 4. Fitur Pencarian
const searchQuery = ref('');

const filteredJournals = computed(() => {
    if (!searchQuery.value) return props.journals; // Ambil dari props
    
    const query = searchQuery.value.toLowerCase();
    return props.journals.filter(journal =>
        journal.name.toLowerCase().includes(query) ||
        journal.subject.toLowerCase().includes(query)
    );
});
</script>

<template>
    <Head title="E-Journal & Database" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Journal & Database">

        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative">

            <div class="max-w-xl mx-auto mb-12">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#99cc33] transition-colors">
                        <Search class="w-5 h-5" />
                    </div>
                    <input
                        v-model="searchQuery"
                        type="text"
                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 bg-white shadow-sm focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none text-slate-700 placeholder:text-slate-400"
                        placeholder="Cari nama jurnal atau subjek..."
                    />
                </div>
            </div>

            <div v-if="filteredJournals.length > 0" class="flex flex-wrap justify-center gap-6 mb-16">
                <div
                    v-for="(item, index) in filteredJournals"
                    :key="item.id"
                    
                    class="w-full md:w-[calc(50%-1.5rem)] lg:w-[calc(33.33%-1.5rem)] group bg-white rounded-2xl p-6 border border-slate-100 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-[#99cc33]/10 hover:border-[#99cc33]/30 transition-all duration-300 flex flex-col"
                >
                    <div class="h-16 mb-6 flex items-center justify-start">
                        <img
                            v-if="item.img_url"
                            :src="item.img_url"
                            :alt="item.name"
                            class="h-full w-auto object-contain max-w-[180px] transition-transform duration-300 group-hover:scale-105"
                        />

                        <div v-else class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#99cc33]/10 flex items-center justify-center text-[#99cc33]">
                                <Globe class="w-6 h-6" />
                            </div>
                            <span class="font-bold text-xl text-slate-800 line-clamp-1">{{ item.name }}</span>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <h3 v-if="item.img_url" class="text-lg font-bold text-slate-800 mb-2 group-hover:text-[#99cc33] transition-colors">
                            {{ item.name }}
                        </h3>

                        <div class="flex items-start gap-2 text-slate-500 text-sm mb-6">
                            <BookOpen class="w-4 h-4 mt-0.5 shrink-0 text-slate-400" />
                            <span class="leading-relaxed">{{ item.subject }}</span>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a
                            :href="item.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl bg-slate-50 text-slate-600 font-semibold text-sm group-hover:bg-[#99cc33] group-hover:text-white transition-all duration-300"
                        >
                            Akses Layanan
                            <ExternalLink class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-16">
                <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <Search class="w-8 h-8 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">Tidak Ditemukan</h3>
                <p class="text-slate-500">Coba kata kunci pencarian lain atau data belum tersedia.</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="bg-amber-50 border border-amber-100 rounded-3xl p-8 relative overflow-hidden">
                    <ShieldAlert class="absolute -right-6 -bottom-6 w-32 h-32 text-amber-100 -rotate-12 pointer-events-none" />

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                                <AlertCircle class="w-6 h-6" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">Aturan Akses E-Journal</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-for="(rule, idx) in [
                                'E-Journal hanya dapat diakses menggunakan jaringan kampus (IP POLBAN).',
                                'Dilarang membagikan akun akses (username/password) kepada pihak luar.',
                                'Pengguna wajib mematuhi lisensi dan aturan penggunaan database.',
                                'Download artikel hanya diperbolehkan untuk keperluan akademik/riset.',
                                'Menyebarkan file hasil download secara massal tanpa izin adalah pelanggaran.'
                            ]" :key="idx" class="flex items-start gap-3">
                                <CheckCircle2 class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" />
                                <span class="text-slate-700 text-sm leading-relaxed">{{ rule }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </Layout>
</template>