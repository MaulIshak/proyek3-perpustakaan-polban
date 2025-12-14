<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import {
    BookOpen,
    Download,
    FileCheck,
    FileText,
    GitGraph,
    Image,
    ShieldCheck,
    AlertCircle,
    FileType
} from 'lucide-vue-next';
import { ref, computed } from 'vue';

// --- 1. DEFINISI TIPE DATA ---
interface Settings {
    alur_image_path?: string;
    alur_description?: string;

    requirement_file_path?: string;
    requirement_description?: string;

    guide_file_path?: string;
    guide_description?: string;

    template_title?: string;
    template_instruction?: string;
    template_info?: string;
    template_file_path?: string;

    watermark_title?: string;
    watermark_info?: string;
    watermark_instruction?: string;
    watermark_file_path?: string;
}

const props = defineProps<{
    settings: Settings | null;
}>();

const activeTab = ref('alur');
const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Bebas Masalah' },
];

const tabs = [
    { id: 'alur', label: 'Diagram Alur', icon: GitGraph },
    { id: 'persyaratan', label: 'Persyaratan', icon: ShieldCheck },
    { id: 'panduan', label: 'Panduan', icon: BookOpen },
    { id: 'template', label: 'SP3 KTI', icon: FileCheck },
    { id: 'watermark', label: 'Watermark', icon: FileText },
];

// --- 2. COMPUTED PROPERTI ---
const currentFilePath = computed(() => {
    if (activeTab.value === 'persyaratan') return props.settings?.requirement_file_path;
    if (activeTab.value === 'panduan') return props.settings?.guide_file_path;
    if (activeTab.value === 'template') return props.settings?.template_file_path;
    if (activeTab.value === 'watermark') return props.settings?.watermark_file_path;
    return undefined;
});

const isPdf = computed(() => {
    const path = currentFilePath.value;
    if (!path) return false;
    return path.toLowerCase().endsWith('.pdf');
});

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

        <div class="relative container mx-auto px-3 py-6 sm:px-6 sm:py-10 lg:px-8">

            <div class="mb-8 grid grid-cols-2 gap-2 sm:mb-12 sm:flex sm:flex-wrap sm:justify-center sm:gap-3">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    class="flex items-center justify-center gap-2 rounded-full border px-3 py-2 text-xs font-medium shadow-sm transition-all duration-300 sm:px-6 sm:py-3 sm:text-base"
                    :class="[
                        activeTab === tab.id
                            ? '-translate-y-0.5 border-[#99cc33] bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/30 sm:-translate-y-1'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-[#99cc33]/30 hover:bg-slate-50 hover:text-[#99cc33]',
                        /* Membuat tab terakhir (jika ganjil) mengambil 2 kolom di mobile agar rapi */
                        tabs.length % 2 !== 0 && tabs.indexOf(tab) === tabs.length - 1 ? 'col-span-2 sm:col-span-1' : ''
                    ]"
                >
                    <component :is="tab.icon" class="h-3.5 w-3.5 sm:h-4 sm:w-4" />
                    {{ tab.label }}
                </button>
            </div>

            <div class="mx-auto min-h-[400px] max-w-5xl">
                <transition name="fade" mode="out-in">

                    <div
                        v-if="activeTab === 'alur'"
                        key="alur"
                        class="rounded-3xl border border-slate-100 bg-white p-3 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-4 flex items-center gap-3 px-1 sm:mb-6 sm:px-4">
                            <div class="rounded-lg bg-[#99cc33]/10 p-1.5 sm:p-2 text-[#99cc33]">
                                <GitGraph class="h-5 w-5 sm:h-6 sm:w-6" />
                            </div>
                            <h2 class="text-lg font-bold text-slate-800 sm:text-2xl">Diagram Alur Proses</h2>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-1 sm:p-4">
                            <img
                                v-if="settings?.alur_image_path"
                                :src="settings.alur_image_path"
                                alt="Diagram Alur Bebas Masalah"
                                class="h-auto w-full rounded-xl shadow-sm transition-transform duration-500 group-hover:scale-[1.01]"
                            />
                            <div v-else class="h-48 sm:h-64 w-full flex flex-col items-center justify-center gap-2 text-slate-400">
                                <Image class="h-10 w-10 opacity-50 sm:h-12 sm:w-12" />
                                <span class="text-xs sm:text-sm">Gambar Diagram Alur belum tersedia.</span>
                            </div>
                        </div>
                        <p class="mt-4 sm:mt-6 text-center text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 sm:p-4 rounded-xl border border-slate-100">
                            {{ settings?.alur_description || 'Silakan ikuti langkah-langkah sesuai diagram di atas untuk kelancaran proses.' }}
                        </p>
                    </div>

                    <div
                        v-else
                        :key="activeTab"
                        class="rounded-3xl border border-slate-100 bg-white p-3 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-4 flex flex-col gap-4 border-b border-slate-100 pb-4 sm:mb-6 sm:flex-row sm:items-center sm:justify-between sm:pb-6">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-[#99cc33]/10 p-1.5 sm:p-2 text-[#99cc33]">
                                    <component :is="tabs.find(t => t.id === activeTab)?.icon" class="h-5 w-5 sm:h-6 sm:w-6" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800 capitalize sm:text-2xl">
                                        {{
                                            activeTab === 'template' ? (settings?.template_title || 'Template Dokumen') :
                                            activeTab === 'watermark' ? (settings?.watermark_title || 'Watermark') :
                                            activeTab
                                        }}
                                    </h2>
                                    <p class="text-xs text-slate-500 sm:text-sm">
                                        {{ activeTab === 'template' ? (settings?.template_info || '') :
                                           activeTab === 'watermark' ? (settings?.watermark_info || '') :
                                           'Dokumen Preview' }}
                                    </p>
                                </div>
                            </div>

                            <button
                                @click="downloadFile(currentFilePath)"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/20 transition-all duration-300 hover:bg-[#88b82d] hover:-translate-y-0.5 active:scale-95 sm:w-auto sm:px-6 sm:py-2.5 sm:text-base"
                            >
                                <Download class="h-4 w-4" />
                                <span>Download File</span>
                            </button>
                        </div>

                        <div class="mb-4 rounded-xl bg-slate-50 p-3 sm:p-5 border border-slate-100 text-slate-600 leading-relaxed text-xs sm:text-sm">
                            <p class="font-bold text-slate-800 mb-1 flex items-center gap-2">
                                <AlertCircle class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#99cc33]" /> Keterangan:
                            </p>
                            {{
                                activeTab === 'persyaratan' ? (settings?.requirement_description || 'Silakan baca dokumen persyaratan di bawah ini.') :
                                activeTab === 'panduan' ? (settings?.guide_description || 'Berikut adalah panduan lengkap proses bebas masalah.') :
                                activeTab === 'template' ? (settings?.template_instruction || 'Gunakan template ini untuk membuat dokumen.') :
                                (settings?.watermark_instruction || 'Watermark untuk disisipkan pada dokumen Anda.')
                            }}
                        </div>

                        <div class="w-full rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-inner min-h-[300px] sm:min-h-[400px] relative group">

                            <div v-if="currentFilePath" class="w-full h-full min-h-[400px] sm:min-h-[600px] flex flex-col">

                                <div v-if="isPdf" class="w-full h-[400px] sm:h-[800px] relative">
                                    <embed
                                        :src="currentFilePath"
                                        type="application/pdf"
                                        class="w-full h-full"
                                    />
                                </div>

                                <div v-else class="flex flex-col items-center justify-center flex-1 py-12 px-4 text-center sm:py-20">
                                    <div class="h-16 w-16 sm:h-20 sm:w-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                                        <FileType class="w-8 h-8 sm:w-10 sm:h-10" />
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold text-slate-700 mb-2">Preview Tidak Tersedia</h3>
                                    <p class="text-xs sm:text-base text-slate-500 max-w-md mb-6">
                                        File ini berformat dokumen (.doc/.docx) dan tidak dapat ditampilkan langsung di browser. Silakan download untuk membukanya.
                                    </p>
                                    <button
                                        @click="downloadFile(currentFilePath)"
                                        class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-slate-800 px-6 py-3 text-sm font-bold text-white transition-all hover:bg-slate-900 sm:py-2.5"
                                    >
                                        <Download class="h-4 w-4" />
                                        Download Dokumen
                                    </button>
                                </div>

                            </div>

                            <div v-else class="flex flex-col items-center justify-center h-[300px] sm:h-[400px] text-slate-400">
                                <div class="p-3 sm:p-4 bg-white rounded-full mb-3 shadow-sm">
                                    <FileText class="w-8 h-8 sm:w-10 sm:h-10 opacity-30" />
                                </div>
                                <h3 class="font-bold text-sm sm:text-base text-slate-600">Dokumen Belum Tersedia</h3>
                                <p class="text-xs sm:text-sm">Admin belum mengupload file untuk bagian ini.</p>
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
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
