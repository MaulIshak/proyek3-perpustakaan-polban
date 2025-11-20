<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import {
    BookOpen,
    CheckCircle2,
    Download,
    FileCheck,
    FileText,
    GitGraph,
    Image,
    ShieldCheck,
} from 'lucide-vue-next';
import { ref } from 'vue';

// --- State ---
const activeTab = ref('alur');

const breadcrumb = [{ label: 'Bebas Masalah' }];

// --- Data Tab Menu ---
const tabs = [
    { id: 'alur', label: 'Diagram Alur', icon: GitGraph },
    { id: 'persyaratan', label: 'Persyaratan', icon: FileCheck },
    { id: 'panduan', label: 'Panduan', icon: BookOpen },
    { id: 'template', label: 'SP3 KTI', icon: FileText },
    { id: 'watermark', label: 'Watermark', icon: Image },
];

// --- Data Content ---
const persyaratanData = [
    {
        title: '1. Pengembalian Buku',
        desc: 'Mengembalikan seluruh buku yang dipinjam dan memastikan tidak ada tunggakan denda.',
    },
    {
        title: '2. Penyerahan Tugas Akhir',
        desc: 'Menyerahkan 1 (satu) eksemplar hard copy tugas akhir yang telah dijilid hardcover.',
    },
    {
        title: '3. Upload Soft Copy',
        desc: 'Mengunggah file PDF tugas akhir ke Repository POLBAN sesuai format yang ditentukan.',
    },
    {
        title: '4. Surat Pernyataan',
        desc: 'Mengisi dan menandatangani surat pernyataan publikasi karya ilmiah di atas meterai.',
    },
    {
        title: '5. Watermark Logo POLBAN',
        desc: 'Menempelkan watermark logo POLBAN pada halaman judul tugas akhir.',
    },
];

const panduanSteps = [
    {
        title: 'Persiapan Dokumen',
        desc: 'Pastikan file PDF tugas akhir telah final dan sesuai format. Nama file: NIM_NamaLengkap_Judul.pdf',
    },
    {
        title: 'Akses Repository',
        desc: 'Login ke Repository POLBAN menggunakan akun mahasiswa (NIM dan password).',
    },
    {
        title: 'Upload File',
        desc: 'Pilih menu Submit New Item dan ikuti petunjuk upload. Isi metadata dengan lengkap dan benar.',
    },
    {
        title: 'Verifikasi',
        desc: 'Tunggu proses verifikasi oleh pustakawan (maksimal 3 hari kerja).',
    },
    {
        title: 'Cetak Bukti',
        desc: 'Setelah disetujui, cetak bukti upload sebagai persyaratan Bebas Masalah.',
    },
];
</script>

<template>
    <Layout :page="true" title="Bebas Masalah" :breadcrumb="breadcrumb">
        <!-- Background decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <!-- <div class="mb-10 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Bebas Masalah
                </h1>
                <p class="text-slate-600 text-lg">
                    Pusat informasi, panduan, dan persyaratan penyelesaian administrasi perpustakaan untuk wisudawan.
                </p>
                <div class="flex justify-center mt-6">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <!-- Modern Tabs Navigation (Pills Style) -->
            <div class="mb-12 flex flex-wrap justify-center gap-3">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    class="flex items-center gap-2 rounded-full border px-6 py-3 font-medium shadow-sm transition-all duration-300"
                    :class="
                        activeTab === tab.id
                            ? '-translate-y-1 transform border-[#99cc33] bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/30'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-[#99cc33]/30 hover:bg-slate-50 hover:text-[#99cc33]'
                    "
                >
                    <component :is="tab.icon" class="h-4 w-4" />
                    {{ tab.label }}
                </button>
            </div>

            <!-- Content Area with Transition -->
            <div class="mx-auto min-h-[400px] max-w-5xl">
                <transition name="fade" mode="out-in">
                    <!-- TAB: ALUR -->
                    <div
                        v-if="activeTab === 'alur'"
                        key="alur"
                        class="rounded-3xl border border-slate-100 bg-white p-2 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-6 flex items-center gap-3 px-4">
                            <div
                                class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                            >
                                <GitGraph class="h-6 w-6" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">
                                Diagram Alur Proses
                            </h2>
                        </div>

                        <div
                            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-4"
                        >
                            <!-- Placeholder for image if URL breaks, stylized -->
                            <img
                                src="/Images/Diagram_Alur.png"
                                alt="Diagram Alur Bebas Masalah"
                                class="h-auto w-full rounded-xl shadow-sm transition-transform duration-500 group-hover:scale-[1.01]"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                            />
                            <!-- Fallback visual if image missing -->
                            <div
                                class="hidden h-64 w-full flex-col items-center justify-center gap-2 text-slate-400"
                            >
                                <Image class="h-12 w-12 opacity-50" />
                                <span class="text-sm"
                                    >Gambar Diagram Alur tidak ditemukan</span
                                >
                            </div>
                        </div>
                        <p
                            class="mt-4 text-center text-sm text-slate-500 italic"
                        >
                            *Silakan ikuti langkah-langkah sesuai diagram di
                            atas untuk kelancaran proses.
                        </p>
                    </div>

                    <!-- TAB: PERSYARATAN -->
                    <div
                        v-else-if="activeTab === 'persyaratan'"
                        key="persyaratan"
                        class="grid gap-6"
                    >
                        <div class="mb-2 flex items-center justify-between">
                            <h2
                                class="flex items-center gap-3 text-2xl font-bold text-slate-800"
                            >
                                <ShieldCheck class="h-7 w-7 text-[#99cc33]" />
                                Checklist Persyaratan
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div
                                v-for="(item, index) in persyaratanData"
                                :key="index"
                                class="group flex gap-4 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 hover:border-[#99cc33]/30 hover:shadow-md"
                            >
                                <div class="mt-1 shrink-0">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-[#99cc33]/10 text-[#99cc33] transition-colors group-hover:bg-[#99cc33] group-hover:text-white"
                                    >
                                        <CheckCircle2 class="h-5 w-5" />
                                    </div>
                                </div>
                                <div>
                                    <h3
                                        class="mb-2 text-lg font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                                    >
                                        {{ item.title }}
                                    </h3>
                                    <p
                                        class="text-sm leading-relaxed text-slate-600"
                                    >
                                        {{ item.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: PANDUAN -->
                    <div
                        v-else-if="activeTab === 'panduan'"
                        key="panduan"
                        class="rounded-3xl border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/60"
                    >
                        <h2
                            class="mb-8 flex items-center gap-3 text-2xl font-bold text-slate-800"
                        >
                            <BookOpen class="h-7 w-7 text-[#99cc33]" />
                            Panduan Upload Karya Tulis
                        </h2>

                        <div
                            class="relative space-y-8 pl-4 before:absolute before:top-2 before:bottom-2 before:left-0 before:w-0.5 before:bg-slate-200 sm:pl-8 sm:before:left-4"
                        >
                            <div
                                v-for="(step, index) in panduanSteps"
                                :key="index"
                                class="group relative pl-8 sm:pl-12"
                            >
                                <!-- Timeline Dot -->
                                <div
                                    class="absolute top-0 left-[-5px] h-4 w-4 rounded-full border-2 border-white bg-slate-300 shadow-sm transition-all duration-300 group-hover:scale-125 group-hover:bg-[#99cc33] sm:left-[11px]"
                                ></div>

                                <h3
                                    class="mb-1 text-lg font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                                >
                                    <span class="mr-2 text-[#99cc33]"
                                        >0{{ index + 1 }}.</span
                                    >
                                    {{ step.title }}
                                </h3>
                                <p class="leading-relaxed text-slate-600">
                                    {{ step.desc }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: TEMPLATE -->
                    <div
                        v-else-if="activeTab === 'template'"
                        key="template"
                        class="mx-auto max-w-2xl"
                    >
                        <div
                            class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"
                        >
                            <div class="h-2 bg-[#99cc33]"></div>
                            <div class="p-8 text-center">
                                <div
                                    class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[#99cc33]/10"
                                >
                                    <FileText
                                        class="h-10 w-10 text-[#99cc33]"
                                    />
                                </div>
                                <h2
                                    class="mb-2 text-2xl font-bold text-slate-800"
                                >
                                    Surat Pernyataan Publikasi
                                </h2>
                                <p class="mx-auto mb-8 max-w-md text-slate-500">
                                    Silakan unduh template surat pernyataan, isi
                                    dengan lengkap, dan tandatangani di atas
                                    meterai Rp 10.000.
                                </p>

                                <div
                                    class="mb-8 flex items-center justify-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
                                >
                                    <span class="flex items-center gap-1"
                                        ><FileText class="h-4 w-4" /> Format:
                                        DOCX/PDF</span
                                    >
                                    <span
                                        class="h-1 w-1 rounded-full bg-slate-400"
                                    ></span>
                                    <span>Size: 150 KB</span>
                                </div>

                                <button
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] px-8 py-3 font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:bg-[#88b82d] sm:w-auto"
                                >
                                    <Download class="h-5 w-5" />
                                    Download Template
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: WATERMARK -->
                    <div
                        v-else-if="activeTab === 'watermark'"
                        key="watermark"
                        class="mx-auto max-w-2xl"
                    >
                        <div
                            class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"
                        >
                            <div class="h-2 bg-cyan-500"></div>
                            <div class="p-8 text-center">
                                <div
                                    class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50"
                                >
                                    <Image class="h-10 w-10 text-cyan-600" />
                                </div>
                                <h2
                                    class="mb-2 text-2xl font-bold text-slate-800"
                                >
                                    Watermark Logo POLBAN
                                </h2>
                                <p class="mx-auto mb-8 max-w-md text-slate-500">
                                    Logo resmi untuk ditempelkan pada halaman
                                    judul tugas akhir sebagai tanda keaslian
                                    dokumen.
                                </p>

                                <div
                                    class="mb-8 space-y-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
                                >
                                    <div
                                        class="flex justify-center gap-4 font-medium"
                                    >
                                        <span>Format: PNG (Transparan)</span>
                                        <span>•</span>
                                        <span>Size: 2 MB</span>
                                    </div>
                                    <p class="text-xs text-slate-400 italic">
                                        Instruksi: Atur posisi di tengah halaman
                                        dengan Opacity 30%.
                                    </p>
                                </div>

                                <button
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-600 px-8 py-3 font-bold text-white shadow-lg shadow-cyan-600/30 transition-all duration-300 hover:bg-cyan-700 sm:w-auto"
                                >
                                    <Download class="h-5 w-5" />
                                    Download Watermark
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* Animasi Fade sederhana untuk perpindahan Tab */
.fade-enter-active,
.fade-leave-active {
    transition:
        opacity 0.2s ease,
        transform 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
