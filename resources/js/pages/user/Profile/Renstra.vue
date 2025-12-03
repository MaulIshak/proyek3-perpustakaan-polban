<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { AlertTriangle, Eye, FileText, Lock, Shield } from 'lucide-vue-next';

defineProps<{
    title: string;
    pdf_url?: string;
}>();

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profil' },
    { label: 'Rencana Strategis' },
];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
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
            <!-- Header Section (Commented out in original) -->
            <!-- <div class="mx-auto mb-10 max-w-3xl text-center"> ... </div> -->

            <!-- Document Viewer Container -->
            <!--
                IMPLEMENTASI: Mengganti div wrapper biasa menjadi ScrollReveal.
                Duration diperlambat (800ms) untuk kesan elegan pada elemen besar.
            -->
            <ScrollReveal
                animation="fade-up"
                :duration="800"
                :delay="200"
                class="mx-auto max-w-6xl"
            >
                <div
                    class="relative flex h-[85vh] flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-2xl shadow-slate-200/60"
                >
                    <!-- Custom "Secure" Toolbar -->
                    <div
                        v-if="pdf_url"
                        class="z-10 flex shrink-0 flex-col items-center justify-between gap-4 border-b border-slate-200 bg-slate-50/80 p-4 backdrop-blur-sm sm:flex-row"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="rounded-lg border border-slate-200 bg-white p-2 text-[#99cc33] shadow-sm"
                            >
                                <FileText class="h-5 w-5" />
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-sm font-bold text-slate-700 sm:text-base"
                                    >Pratinjau Dokumen</span
                                >
                                <span
                                    class="flex items-center gap-1 text-xs text-slate-500"
                                >
                                    <Shield class="h-3 w-3 text-[#99cc33]" />
                                    Terproteksi
                                </span>
                            </div>
                        </div>

                        <!-- Badge Read Only -->
                        <div
                            class="flex items-center gap-2 rounded-full border border-amber-100 bg-amber-50 px-3 py-1.5 text-amber-700"
                        >
                            <Lock class="h-3.5 w-3.5" />
                            <span
                                class="text-xs font-bold tracking-wide uppercase"
                                >Read Only Mode</span
                            >
                        </div>
                    </div>

                    <!-- PDF Iframe Area -->
                    <div class="relative flex-grow bg-slate-100">
                        <div v-if="pdf_url" class="h-full w-full">
                            <!--
                                Security Note:
                                #toolbar=0&navpanes=0&scrollbar=0 menyembunyikan UI native browser
                            -->
                            <iframe
                                :src="`${pdf_url}#toolbar=0&navpanes=0&scrollbar=0&view=FitH`"
                                class="h-full w-full border-0"
                                title="PDF Viewer"
                            ></iframe>
                        </div>

                        <!-- Empty State -->
                        <div
                            v-else
                            class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center"
                        >
                            <div
                                class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-slate-50 shadow-inner"
                            >
                                <AlertTriangle
                                    class="h-10 w-10 text-slate-300"
                                />
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-slate-800">
                                Dokumen Belum Tersedia
                            </h3>
                            <p class="max-w-md leading-relaxed text-slate-500">
                                Mohon maaf, saat ini file Rencana Strategi belum
                                diunggah atau sedang dalam pembaruan oleh
                                administrator.
                            </p>
                            <button
                                class="mt-8 rounded-xl border border-slate-200 bg-white px-6 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition-colors hover:border-[#99cc33] hover:text-[#99cc33]"
                            >
                                Kembali ke Profil
                            </button>
                        </div>
                    </div>

                    <!-- Footer Status Bar -->
                    <div
                        class="flex shrink-0 items-center justify-between border-t border-slate-200 bg-white px-4 py-2 text-xs text-slate-400"
                    >
                        <span>Peninjau PDF</span>
                        <span class="flex items-center gap-1">
                            <Eye class="h-3 w-3" />
                            Viewing Mode
                        </span>
                    </div>
                </div>
            </ScrollReveal>
        </div>
    </Layout>
</template>
