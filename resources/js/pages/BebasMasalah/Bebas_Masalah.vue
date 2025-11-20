<script setup>
import Layout from '@/layouts/UserAppLayout.vue';
import { CheckCircle, Download, FileText, Image as ImageIcon, ArrowRight, Info } from 'lucide-vue-next';
import { ref } from 'vue';

// Terima data dari Controller via Props
const props = defineProps({
    settings: Object,
    requirements: Array,
    guides: Array,
});

const breadcrumb = [{ label: 'Bebas Masalah' }];
const activeTab = ref('alur');

// Fungsi helper download
const downloadFile = (path) => {
    if(!path) return alert('File belum tersedia.');
    window.open(path, '_blank');
};
</script>

<template>
    <Layout :page="true" title="Bebas Masalah" :breadcrumb="breadcrumb">
        <div class="min-h-screen py-10 font-sans">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-extrabold text-[#0f3800] tracking-tight">Pusat Bebas Masalah</h1>
                    <p class="mt-2 text-gray-600 max-w-2xl mx-auto">
                        Ikuti panduan, lengkapi persyaratan, dan unduh dokumen yang diperlukan untuk menyelesaikan administrasi perpustakaan.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-[#99cc33]/30 overflow-hidden">
                    
                    <div class="bg-[#f9fff9] border-b border-[#99cc33]/20 px-6 py-4">
                        <div class="flex flex-wrap justify-center gap-2 sm:gap-4">
                            <button
                                v-for="tab in ['alur', 'persyaratan', 'panduan', 'template', 'watermark']"
                                :key="tab"
                                class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 ease-in-out flex items-center gap-2 transform hover:-translate-y-0.5"
                                :class="activeTab === tab 
                                    ? 'bg-[#00637b] text-white shadow-lg ring-2 ring-[#99cc33]/50' 
                                    : 'bg-white text-[#0f3800] border border-[#99cc33]/30 hover:bg-[#e6ffe6] hover:text-[#00637b]'"
                                @click="activeTab = tab"
                            >
                                {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
                            </button>
                        </div>
                    </div>

                    <div class="p-6 lg:p-10 min-h-[400px]">
                        
                        <div v-if="activeTab === 'alur'" class="space-y-6 animate-fade-in-up">
                            <div class="text-center space-y-2">
                                <h2 class="text-2xl font-bold text-[#0f3800]">Diagram Alur Proses</h2>
                                <p class="text-gray-500">Pahami langkah-langkah pengajuan bebas masalah berikut ini</p>
                            </div>
                            
                            <div class="group relative rounded-xl border-2 border-dashed border-[#99cc33]/50 bg-[#f3fff3]/50 p-4 transition hover:border-[#00637b]/50">
                                <div v-if="settings?.alur_image_path">
                                    <img
                                        :src="settings.alur_image_path" 
                                        alt="Diagram Alur"
                                        class="mx-auto w-full max-w-4xl rounded-lg shadow-sm transition-transform duration-500 group-hover:scale-[1.01]"
                                    />
                                </div>
                                <div v-else class="flex h-64 items-center justify-center text-gray-400">
                                    <p>Gambar alur belum tersedia</p>
                                </div>
                            </div>
                            
                            <div class="bg-[#e6ffe6] rounded-lg p-4 border-l-4 border-[#00637b]">
                                <div class="flex gap-3">
                                    <Info class="w-6 h-6 text-[#00637b] flex-shrink-0" />
                                    <p class="text-sm text-[#0f3800] font-medium">
                                        {{ settings?.alur_description || 'Silakan ikuti alur di atas dengan seksama.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div v-if="activeTab === 'persyaratan'" class="space-y-6 animate-fade-in-up">
                            <h2 class="text-2xl font-bold text-[#0f3800] mb-6 border-b border-[#99cc33]/30 pb-2 inline-block">
                                Daftar Persyaratan
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    v-for="(item, index) in requirements"
                                    :key="item.id"
                                    class="group flex items-start gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:border-[#99cc33] hover:bg-[#f3fff3]"
                                >
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#e6ffe6] text-[#00637b] group-hover:bg-[#00637b] group-hover:text-white transition-colors">
                                        <CheckCircle class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-[#0f3800] text-lg mb-1">{{ item.title }}</h3>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="requirements.length === 0" class="text-center text-gray-400 py-10">Belum ada data persyaratan.</div>
                        </div>

                        <div v-if="activeTab === 'panduan'" class="space-y-6 animate-fade-in-up">
                             <h2 class="text-2xl font-bold text-[#0f3800] mb-6 border-b border-[#99cc33]/30 pb-2 inline-block">
                                Panduan Langkah demi Langkah
                            </h2>
                            <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-[#99cc33] before:to-transparent">
                                <div v-for="(item, index) in guides" :key="item.id" class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                                    
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-[#99cc33] bg-white text-[#00637b] font-bold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                        {{ index + 1 }}
                                    </div>
                                    
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:border-[#99cc33]">
                                        <div class="flex items-center justify-between mb-1">
                                            <h3 class="font-bold text-[#0f3800] text-lg">{{ item.title }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="guides.length === 0" class="text-center text-gray-400 py-10">Belum ada data panduan.</div>
                        </div>

                        <div v-if="activeTab === 'template' || activeTab === 'watermark'" class="animate-fade-in-up">
                            <div class="max-w-3xl mx-auto">
                                <div class="text-center mb-8">
                                    <h2 class="text-2xl font-bold text-[#0f3800]">
                                        Unduh {{ activeTab === 'template' ? 'Template Dokumen' : 'Watermark Logo' }}
                                    </h2>
                                    <p class="text-gray-500 mt-2">Gunakan file resmi di bawah ini untuk kelengkapan tugas akhir Anda.</p>
                                </div>

                                <div class="bg-gradient-to-br from-white to-[#f9fff9] rounded-2xl p-8 border border-[#99cc33]/30 shadow-lg relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-[#99cc33]/10 rounded-full blur-3xl group-hover:bg-[#99cc33]/20 transition"></div>

                                    <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                                        <div class="flex-shrink-0">
                                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#e6ffe6] to-white border border-[#99cc33]/30 flex items-center justify-center shadow-inner">
                                                <FileText v-if="activeTab === 'template'" class="w-10 h-10 text-[#00637b]" />
                                                <ImageIcon v-else class="w-10 h-10 text-[#00637b]" />
                                            </div>
                                        </div>

                                        <div class="flex-1 text-center md:text-left space-y-3">
                                            <h3 class="text-xl font-bold text-[#0f3800]">
                                                {{ settings?.[activeTab + '_title'] }}
                                            </h3>
                                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-[#00637b]/10 text-[#00637b] text-xs font-semibold border border-[#00637b]/20">
                                                {{ settings?.[activeTab + '_info'] }}
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                {{ settings?.[activeTab + '_instruction'] }}
                                            </p>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <button
                                                @click="downloadFile(settings?.[activeTab + (activeTab === 'template' ? '_file_path' : '_image_path')])"
                                                class="flex items-center justify-center px-6 py-3 bg-[#00637b] hover:bg-[#0f3800] text-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 font-bold"
                                            >
                                                <Download class="mr-2 h-5 w-5" />
                                                Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="mt-8 text-center">
                     <p class="text-xs text-gray-400">
                        © Perpustakaan Politeknik Negeri Bandung. Jika ada kendala, hubungi staf perpustakaan.
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* Animasi Halus saat ganti tab */
.animate-fade-in-up {
    animation: fadeInUp 0.5s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>