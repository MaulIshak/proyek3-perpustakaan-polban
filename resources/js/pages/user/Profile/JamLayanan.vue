<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import ScrollReveal from '@/components/ScrollReveal.vue'; // [CRITICAL] Jangan lupa import ini
import { Armchair, BookOpen, Calendar, Clock, Info } from 'lucide-vue-next';

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profil' },
    { label: 'Jam Layanan' },
];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-slate-50/50">
            <div class="absolute top-0 right-0 h-[300px] w-[300px] sm:h-[600px] sm:w-[600px] rounded-full bg-[#99cc33]/10 blur-3xl opacity-60"></div>
            <div class="absolute bottom-0 left-0 h-[250px] w-[250px] sm:h-[500px] sm:w-[500px] rounded-full bg-blue-100/50 blur-3xl opacity-60"></div>
        </div>

        <div class="relative container mx-auto px-4 py-8 sm:py-12 sm:px-6 lg:px-8">

            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-8">

                <ScrollReveal
                    animation="fade-up"
                    :duration="600"
                    class="h-full"
                >
                    <div class="group relative h-full overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-100 bg-white shadow-lg shadow-slate-200/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-[#99cc33]/30">
                        <div class="h-1.5 sm:h-2 w-full bg-[#99cc33]"></div>

                        <div class="p-6 sm:p-8">
                            <div class="mb-6 sm:mb-8 flex items-center gap-4">
                                <div class="shrink-0 rounded-xl bg-[#99cc33]/10 p-3 text-[#99cc33] transition-colors duration-300 group-hover:bg-[#99cc33] group-hover:text-white">
                                    <BookOpen class="h-6 w-6 sm:h-8 sm:w-8" />
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
                                    Perpustakaan
                                </h2>
                            </div>

                            <div class="space-y-5 sm:space-y-6">
                                <div class="flex flex-col gap-2 border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                    <div class="flex items-center gap-3">
                                        <Calendar class="h-5 w-5 text-slate-400" />
                                        <span class="font-medium text-slate-700">Senin - Kamis</span>
                                    </div>
                                    <div class="flex w-fit items-center gap-2 rounded-lg bg-slate-50 px-3 py-1.5 text-sm sm:text-base text-slate-600">
                                        <Clock class="h-4 w-4 text-[#99cc33]" />
                                        <span>08.00 - 16.00 WIB</span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-3 border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-start sm:justify-between sm:gap-0">
                                    <div class="mt-1 flex items-center gap-3">
                                        <Calendar class="h-5 w-5 text-slate-400" />
                                        <span class="font-medium text-slate-700">Jumat</span>
                                    </div>

                                    <div class="flex flex-col items-start gap-1 sm:items-end">
                                        <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-1.5 text-sm sm:text-base text-slate-600">
                                            <Clock class="h-4 w-4 text-[#99cc33]" />
                                            <span>08.00 - 16.30 WIB</span>
                                        </div>
                                        <span class="rounded bg-amber-50 px-2 py-0.5 text-[10px] sm:text-xs font-bold uppercase tracking-wide text-amber-600 border border-amber-100">
                                            Istirahat: 11.00 - 13.00
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                    <div class="flex items-center gap-3">
                                        <Calendar class="h-5 w-5 text-slate-400" />
                                        <span class="text-sm sm:text-base font-medium text-slate-700">Sabtu, Minggu, Libur</span>
                                    </div>
                                    <span class="w-fit rounded-lg bg-red-50 px-3 py-1 text-xs sm:text-sm font-bold text-red-500 border border-red-100">
                                        TUTUP
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </ScrollReveal>

                <ScrollReveal
                    animation="fade-up"
                    :delay="150"
                    :duration="600"
                    class="h-full"
                >
                    <div class="group relative h-full overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-100 bg-white shadow-lg shadow-slate-200/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-[#99cc33]/30">
                        <div class="h-1.5 sm:h-2 w-full bg-slate-300 transition-colors duration-500 group-hover:bg-[#99cc33]"></div>

                        <div class="p-6 sm:p-8">
                            <div class="mb-6 sm:mb-8 flex items-center gap-4">
                                <div class="shrink-0 rounded-xl bg-slate-100 p-3 text-slate-500 transition-colors duration-300 group-hover:bg-[#99cc33] group-hover:text-white">
                                    <Armchair class="h-6 w-6 sm:h-8 sm:w-8" />
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
                                    Ruang Belajar Mandiri
                                </h2>
                            </div>

                            <div class="space-y-5 sm:space-y-6">
                                <div class="flex flex-col gap-2 border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                    <div class="flex items-center gap-3">
                                        <Calendar class="h-5 w-5 text-slate-400" />
                                        <span class="font-medium text-slate-700">Senin - Jumat</span>
                                    </div>
                                    <div class="flex w-fit items-center gap-2 rounded-lg bg-[#99cc33]/5 px-3 py-1.5 text-sm sm:text-base text-slate-600 border border-[#99cc33]/20">
                                        <Clock class="h-4 w-4 text-[#99cc33]" />
                                        <span class="font-bold text-[#99cc33]">08.00 - 19.00 WIB</span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                    <div class="flex items-center gap-3">
                                        <Calendar class="h-5 w-5 text-slate-400" />
                                        <span class="text-sm sm:text-base font-medium text-slate-700">Sabtu, Minggu, Libur</span>
                                    </div>
                                    <span class="w-fit rounded-lg bg-red-50 px-3 py-1 text-xs sm:text-sm font-bold text-red-500 border border-red-100">
                                        TUTUP
                                    </span>
                                </div>
                            </div>

                            <div class="absolute -right-6 -bottom-6 sm:-right-10 sm:-bottom-10 z-0 h-24 w-24 sm:h-32 sm:w-32 rounded-full bg-slate-50 pointer-events-none"></div>
                        </div>
                    </div>
                </ScrollReveal>
            </div>

            <ScrollReveal
                animation="fade-in"
                :delay="300"
                :duration="700"
                class="mx-auto mt-6 sm:mt-8 max-w-6xl"
            >
                <div class="flex flex-col sm:flex-row items-start gap-4 rounded-2xl border border-[#99cc33]/20 bg-[#99cc33]/5 p-5 sm:p-6">
                    <div class="shrink-0 rounded-full bg-white p-2 text-[#99cc33] shadow-sm ring-1 ring-[#99cc33]/10">
                        <Info class="h-5 w-5 sm:h-6 sm:w-6" />
                    </div>
                    <div>
                        <h4 class="mb-1 text-base sm:text-lg font-bold text-slate-800">
                            Catatan Penting
                        </h4>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">
                            Selama libur semester ganjil dan genap, Perpustakaan dan Ruang Belajar Mandiri
                            <span class="font-bold text-[#99cc33] underline decoration-2 underline-offset-2">tetap buka</span>.
                        </p>
                    </div>
                </div>
            </ScrollReveal>

        </div>
    </Layout>
</template>
