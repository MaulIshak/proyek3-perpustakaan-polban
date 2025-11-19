<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    pdf_url: {
        type: String,
    }
});

const breadcrumb = [{ label: 'Profil' }, { label: 'Rencana Strategi' }];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="bg-gray-50/50 py-8 px-4 sm:px-6 lg:px-8">
            
            <div class="max-w-6xl mx-auto">
                
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border-t-4 border-green-600">
                    
                    <div v-if="pdf_url" class="bg-green-50 px-6 py-4 border-b border-green-100 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-semibold text-sm uppercase tracking-wide">Pratinjau Dokumen</span>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Read Only
                        </span>
                    </div>

                    <div class="p-4 sm:p-6 bg-gray-50">
                        <div v-if="pdf_url" class="rounded-xl overflow-hidden shadow-inner border border-gray-200 bg-white">
                            <iframe 
                                :src="`${pdf_url}#toolbar=0&navpanes=0&scrollbar=0`" 
                                class="w-full h-[80vh] sm:h-[85vh]"
                                title="PDF Viewer"
                            ></iframe>
                        </div>

                        <div v-else class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="bg-green-50 p-4 rounded-full mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Dokumen Belum Tersedia</h3>
                            <p class="text-gray-500 max-w-sm mt-2">
                                Mohon maaf, saat ini file Rencana Strategi belum diunggah oleh administrator. Silakan cek kembali nanti.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Layout>
</template>