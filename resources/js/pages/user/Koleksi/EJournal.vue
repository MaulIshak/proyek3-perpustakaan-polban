<script setup lang="ts">
import { ref, computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import {
    Search,
    ExternalLink,
    BookOpen,
    AlertCircle,
    Globe,
    ShieldAlert,
    CheckCircle2
} from 'lucide-vue-next';

// 1. Breadcrumb
const breadcrumb = [
    { label: 'Koleksi' },
    { label: 'E-Journal' },
];

// 2. Data E-Journal
const journals = [
  {
    nama: "Emerald Insight",
    link: "https://www.emerald.com/insight/",
    subjek: "Manajemen, Ekonomi, Bisnis",
    // Menggunakan placeholder yang lebih baik atau inisial jika null
    imgUrl: "https://placehold.co/120x50/00644D/FFFFFF?text=Emerald"
  },
  {
    nama: "ProQuest",
    link: "https://www.proquest.com/",
    subjek: "Multi-disiplin",
    imgUrl: "https://placehold.co/120x50/002D72/FFFFFF?text=ProQuest"
  },
  {
    nama: "ScienceDirect",
    link: "https://www.sciencedirect.com/",
    subjek: "Sains, Teknologi, Medis",
    imgUrl: "https://placehold.co/120x50/FF6C28/FFFFFF?text=ScienceDirect"
  },
  {
    nama: "IEEE Xplore",
    link: "https://ieeexplore.ieee.org/",
    subjek: "Teknik Elektro, Ilmu Komputer",
    imgUrl: "https://placehold.co/120x50/00629B/FFFFFF?text=IEEE"
    // Note: Saya ganti imgUrl hero-bg.jpg dummy dengan placeholder logo agar visual sesuai konteks
  },
  {
    nama: "JSTOR",
    link: "https://www.jstor.org/",
    subjek: "Humaniora, Ilmu Sosial",
    imgUrl: "https://placehold.co/120x50/990000/FFFFFF?text=JSTOR"
    // Note: Saya tambahkan placeholder agar tidak kosong
  },
  {
    nama: "Garuda Portal",
    link: "https://garuda.kemdikbud.go.id/",
    subjek: "Publikasi Ilmiah Indonesia",
    imgUrl: "" // Case tanpa gambar
  },
];

// 3. Fitur Pencarian Sederhana
const searchQuery = ref('');

const filteredJournals = computed(() => {
    if (!searchQuery.value) return journals;
    const query = searchQuery.value.toLowerCase();
    return journals.filter(journal =>
        journal.nama.toLowerCase().includes(query) ||
        journal.subjek.toLowerCase().includes(query)
    );
});
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Journal & Database">

        <!-- Background Decoration -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative">

            <!-- Header Section
            <div class="mb-12 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Akses Jurnal Digital
                </h1>
                <p class="text-slate-600 text-lg">
                    Referensi ilmiah dan database internasional yang dilanggan oleh Politeknik Negeri Bandung untuk menunjang riset civitas akademika.
                </p>
                <div class="flex justify-center mt-6">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <!-- Search Bar -->
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

            <!-- Content Grid -->
            <div v-if="filteredJournals.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                <div
                    v-for="(item, index) in filteredJournals"
                    :key="index"
                    class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-[#99cc33]/10 hover:border-[#99cc33]/30 transition-all duration-300 flex flex-col"
                >
                    <!-- Header Card: Logo/Icon -->
                    <div class="h-16 mb-6 flex items-center justify-start">
                        <!-- Case 1: Ada Image -->
                        <img
                            v-if="item.imgUrl"
                            :src="item.imgUrl"
                            :alt="item.nama"
                            class="h-full w-auto object-contain max-w-[180px] transition-transform duration-300 group-hover:scale-105"
                        />

                        <!-- Case 2: Tidak Ada Image (Fallback UI) -->
                        <div v-else class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#99cc33]/10 flex items-center justify-center text-[#99cc33]">
                                <Globe class="w-6 h-6" />
                            </div>
                            <span class="font-bold text-xl text-slate-800">{{ item.nama }}</span>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="flex-grow">
                        <h3 v-if="item.imgUrl" class="text-lg font-bold text-slate-800 mb-2 group-hover:text-[#99cc33] transition-colors">
                            {{ item.nama }}
                        </h3>

                        <div class="flex items-start gap-2 text-slate-500 text-sm mb-6">
                            <BookOpen class="w-4 h-4 mt-0.5 shrink-0 text-slate-400" />
                            <span class="leading-relaxed">{{ item.subjek }}</span>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a
                            :href="item.link"
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

            <!-- Empty State -->
            <div v-else class="text-center py-16">
                <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <Search class="w-8 h-8 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">Tidak Ditemukan</h3>
                <p class="text-slate-500">Coba kata kunci pencarian lain.</p>
            </div>

            <!-- Rules Section (Card) -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-amber-50 border border-amber-100 rounded-3xl p-8 relative overflow-hidden">
                    <!-- Decorative Icon -->
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
