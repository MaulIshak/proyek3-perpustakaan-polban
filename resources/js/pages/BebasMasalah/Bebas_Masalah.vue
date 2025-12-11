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
    { id: 'template', label: 'SP3 KTI', icon: FileCheck }, // SP3KTI seringkali .docx
    { id: 'watermark', label: 'Watermark', icon: FileText },
];

// --- 2. COMPUTED PROPERTI BARU (Untuk Logic Preview) ---

// Mendapatkan path file berdasarkan tab yang aktif
const currentFilePath = computed(() => {
    if (activeTab.value === 'persyaratan') return props.settings?.requirement_file_path;
    if (activeTab.value === 'panduan') return props.settings?.guide_file_path;
    if (activeTab.value === 'template') return props.settings?.template_file_path;
    if (activeTab.value === 'watermark') return props.settings?.watermark_file_path;
    return undefined;
});

// Cek apakah file tersebut PDF
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
                        class="rounded-3xl border border-slate-100 bg-white p-4 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-6 flex items-center gap-3 px-2 sm:px-4">
                            <div class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]">
                                <GitGraph class="h-6 w-6" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">Diagram Alur Proses</h2>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-2 sm:p-4">
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
                        <p class="mt-6 text-center text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ settings?.alur_description || 'Silakan ikuti langkah-langkah sesuai diagram di atas untuk kelancaran proses.' }}
                        </p>
                    </div>

                    <div
                        v-else
                        :key="activeTab"
                        class="rounded-3xl border border-slate-100 bg-white p-4 shadow-xl shadow-slate-200/60 sm:p-8"
                    >
                        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]">
                                    <component :is="tabs.find(t => t.id === activeTab)?.icon" class="h-6 w-6" />
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-800 capitalize">
                                        {{ 
                                            activeTab === 'template' ? (settings?.template_title || 'Template Dokumen') : 
                                            activeTab === 'watermark' ? (settings?.watermark_title || 'Watermark') : 
                                            activeTab 
                                        }}
                                    </h2>
                                    <p class="text-sm text-slate-500">
                                        {{ activeTab === 'template' ? (settings?.template_info || '') : 
                                           activeTab === 'watermark' ? (settings?.watermark_info || '') : 
                                           'Dokumen Preview' }}
                                    </p>
                                </div>
                            </div>

                            <button
                                @click="downloadFile(currentFilePath)"
                                class="flex items-center justify-center gap-2 rounded-xl bg-[#99cc33] px-6 py-2.5 font-bold text-white shadow-lg shadow-[#99cc33]/20 transition-all duration-300 hover:bg-[#88b82d] hover:-translate-y-0.5 active:scale-95"
                            >
                                <Download class="h-4 w-4" />
                                <span>Download File</span>
                            </button>
                        </div>

                        <div class="mb-6 rounded-xl bg-slate-50 p-5 border border-slate-100 text-slate-600 leading-relaxed text-sm">
                            <p class="font-bold text-slate-800 mb-1 flex items-center gap-2">
                                <AlertCircle class="w-4 h-4 text-[#99cc33]" /> Keterangan:
                            </p>
                            {{ 
                                activeTab === 'persyaratan' ? (settings?.requirement_description || 'Silakan baca dokumen persyaratan di bawah ini.') :
                                activeTab === 'panduan' ? (settings?.guide_description || 'Berikut adalah panduan lengkap proses bebas masalah.') :
                                activeTab === 'template' ? (settings?.template_instruction || 'Gunakan template ini untuk membuat dokumen.') :
                                (settings?.watermark_instruction || 'Watermark untuk disisipkan pada dokumen Anda.')
                            }}
                        </div>

                        <div class="w-full rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-inner min-h-[400px] relative group">
                            
                            <div v-if="currentFilePath" class="w-full h-full min-h-[600px] flex flex-col">
                                
                                <div v-if="isPdf" class="w-full h-[600px] sm:h-[800px] relative">
                                    <embed
                                        :src="currentFilePath"
                                        type="application/pdf"
                                        class="w-full h-full"
                                    />
                                </div>

                                <div v-else class="flex flex-col items-center justify-center flex-1 py-20 text-center px-4">
                                    <div class="h-20 w-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                                        <FileType class="w-10 h-10" />
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-700 mb-2">Preview Tidak Tersedia</h3>
                                    <p class="text-slate-500 max-w-md mb-6">
                                        File ini berformat dokumen (.doc/.docx) dan tidak dapat ditampilkan langsung di browser. Silakan download untuk membukanya.
                                    </p>
                                    <button
                                        @click="downloadFile(currentFilePath)"
                                        class="flex items-center gap-2 rounded-xl bg-slate-800 px-6 py-2.5 font-bold text-white transition-all hover:bg-slate-900"
                                    >
                                        <Download class="h-4 w-4" />
                                        Download Dokumen
                                    </button>
                                </div>

                            </div>

                            <div v-else class="flex flex-col items-center justify-center h-[400px] text-slate-400">
                                <div class="p-4 bg-white rounded-full mb-3 shadow-sm">
                                    <FileText class="w-10 h-10 opacity-30" />
                                </div>
                                <h3 class="font-bold text-slate-600">Dokumen Belum Tersedia</h3>
                                <p class="text-sm">Admin belum mengupload file untuk bagian ini.</p>
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