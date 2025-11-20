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
    AlertCircle
} from 'lucide-vue-next';
import { ref } from 'vue';

// --- 1. DEFINISI TIPE DATA (INTERFACE) ---
// Ini memberitahu VS Code struktur data yang datang dari Database
interface Settings {
    alur_image_path?: string;
    alur_description?: string;
    template_title?: string;
    template_instruction?: string;
    template_info?: string;
    template_file_path?: string;
    watermark_title?: string;
    watermark_info?: string;
    watermark_instruction?: string;
    watermark_image_path?: string;
}

interface ListItem {
    id?: number;
    title: string;
    description: string;
    sort_order?: number;
}

// --- 2. PROPS DENGAN TYPE SAFETY ---
// Mengganti defineProps biasa dengan Generic Type
const props = defineProps<{
    settings: Settings | null; // Data bisa null jika belum diset admin
    requirements: ListItem[];  // Array of ListItem
    guides: ListItem[];        // Array of ListItem
}>();

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

// --- Helper Function ---
// Tambahkan tipe data (path?: string) agar 'path' tidak error
const downloadFile = (path?: string) => {
    if (!path) {
        alert("File belum tersedia / belum diupload admin.");
        return;
    }
    window.open(path, '_blank');
};
</script>

<template>
    <Layout :page="true" title="Bebas Masalah" :breadcrumb="breadcrumb">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            
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

            <div class="mx-auto min-h-[400px] max-w-5xl">
                <transition name="fade" mode="out-in">
                    
                    <div
                        v-if="activeTab === 'alur'"
                        key="alur"
                        class="rounded-3xl border border-slate-100 bg-white p-2 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-6 flex items-center gap-3 px-4">
                            <div class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]">
                                <GitGraph class="h-6 w-6" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">Diagram Alur Proses</h2>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <img
                                v-if="settings?.alur_image_path"
                                :src="settings.alur_image_path"
                                alt="Diagram Alur Bebas Masalah"
                                class="h-auto w-full rounded-xl shadow-sm transition-transform duration-500 group-hover:scale-[1.01]"
                            />
                            <div v-else class="h-64 w-full flex flex-col items-center justify-center gap-2 text-slate-400">
                                <Image class="h-12 w-12 opacity-50" />
                                <span class="text-sm">Gambar Diagram Alur belum tersedia.</span>
                            </div>
                        </div>
                        <p class="mt-4 text-center text-sm text-slate-500 italic">
                            {{ settings?.alur_description || '*Silakan ikuti langkah-langkah sesuai diagram di atas untuk kelancaran proses.' }}
                        </p>
                    </div>

                    <div
                        v-else-if="activeTab === 'persyaratan'"
                        key="persyaratan"
                        class="grid gap-6"
                    >
                        <div class="mb-2 flex items-center justify-between">
                            <h2 class="flex items-center gap-3 text-2xl font-bold text-slate-800">
                                <ShieldCheck class="h-7 w-7 text-[#99cc33]" />
                                Checklist Persyaratan
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div
                                v-for="(item, index) in requirements"
                                :key="item.id || index"
                                class="group flex gap-4 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 hover:border-[#99cc33]/30 hover:shadow-md"
                            >
                                <div class="mt-1 shrink-0">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#99cc33]/10 text-[#99cc33] transition-colors group-hover:bg-[#99cc33] group-hover:text-white">
                                        <CheckCircle2 class="h-5 w-5" />
                                    </div>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-lg font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]">
                                        {{ item.title }}
                                    </h3>
                                    <p class="text-sm leading-relaxed text-slate-600">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>

                            <div v-if="!requirements || requirements.length === 0" class="col-span-full text-center py-10 text-slate-500">
                                <AlertCircle class="mx-auto mb-2 h-8 w-8 opacity-50" />
                                Belum ada data persyaratan yang ditambahkan.
                            </div>
                        </div>
                    </div>

                    <div
                        v-else-if="activeTab === 'panduan'"
                        key="panduan"
                        class="rounded-3xl border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/60"
                    >
                        <h2 class="mb-8 flex items-center gap-3 text-2xl font-bold text-slate-800">
                            <BookOpen class="h-7 w-7 text-[#99cc33]" />
                            Panduan Upload Karya Tulis
                        </h2>

                        <div class="relative space-y-8 pl-4 before:absolute before:top-2 before:bottom-2 before:left-0 before:w-0.5 before:bg-slate-200 sm:pl-8 sm:before:left-4">
                            <div
                                v-for="(step, index) in guides"
                                :key="step.id || index"
                                class="group relative pl-8 sm:pl-12"
                            >
                                <div class="absolute top-0 left-[-5px] h-4 w-4 rounded-full border-2 border-white bg-slate-300 shadow-sm transition-all duration-300 group-hover:scale-125 group-hover:bg-[#99cc33] sm:left-[11px]"></div>

                                <h3 class="mb-1 text-lg font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]">
                                    <span class="mr-2 text-[#99cc33]">0{{ index + 1 }}.</span>
                                    {{ step.title }}
                                </h3>
                                <p class="leading-relaxed text-slate-600">
                                    {{ step.description }}
                                </p>
                            </div>

                             <div v-if="!guides || guides.length === 0" class="py-4 pl-8 text-slate-500 italic">
                                Belum ada data panduan yang ditambahkan.
                            </div>
                        </div>
                    </div>

                    <div
                        v-else-if="activeTab === 'template'"
                        key="template"
                        class="mx-auto max-w-2xl"
                    >
                        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
                            <div class="h-2 bg-[#99cc33]"></div>
                            <div class="p-8 text-center">
                                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[#99cc33]/10">
                                    <FileText class="h-10 w-10 text-[#99cc33]" />
                                </div>
                                <h2 class="mb-2 text-2xl font-bold text-slate-800">
                                    {{ settings?.template_title || 'Template Dokumen' }}
                                </h2>
                                <p class="mx-auto mb-8 max-w-md text-slate-500">
                                    {{ settings?.template_instruction || 'Silakan unduh template surat pernyataan yang tersedia.' }}
                                </p>

                                <div class="mb-8 flex items-center justify-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                    <span class="flex items-center gap-1">
                                        <FileText class="h-4 w-4" /> 
                                        {{ settings?.template_info || 'File Document' }}
                                    </span>
                                </div>

                                <button
                                    @click="downloadFile(settings?.template_file_path)"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] px-8 py-3 font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:bg-[#88b82d] sm:w-auto cursor-pointer"
                                >
                                    <Download class="h-5 w-5" />
                                    Download Template
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        v-else-if="activeTab === 'watermark'"
                        key="watermark"
                        class="mx-auto max-w-2xl"
                    >
                        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
                            <div class="h-2 bg-cyan-500"></div>
                            <div class="p-8 text-center">
                                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50">
                                    <Image class="h-10 w-10 text-cyan-600" />
                                </div>
                                <h2 class="mb-2 text-2xl font-bold text-slate-800">
                                    {{ settings?.watermark_title || 'Watermark Logo' }}
                                </h2>
                                <p class="mx-auto mb-8 max-w-md text-slate-500">
                                    Logo resmi untuk ditempelkan pada halaman judul tugas akhir.
                                </p>

                                <div class="mb-8 space-y-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                    <div class="flex justify-center gap-4 font-medium">
                                        <span>{{ settings?.watermark_info || 'Image File' }}</span>
                                    </div>
                                    <p class="text-xs text-slate-400 italic">
                                        {{ settings?.watermark_instruction || 'Instruksi: Atur posisi di tengah halaman dengan Opacity 30%.' }}
                                    </p>
                                </div>

                                <button
                                    @click="downloadFile(settings?.watermark_image_path)"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-600 px-8 py-3 font-bold text-white shadow-lg shadow-cyan-600/30 transition-all duration-300 hover:bg-cyan-700 sm:w-auto cursor-pointer"
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
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>