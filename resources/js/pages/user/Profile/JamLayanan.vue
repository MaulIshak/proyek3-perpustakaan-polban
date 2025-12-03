<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
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
        <!-- Background decoration (Consistent theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header Section (Commented out as per original) -->
            <!-- <div class="mb-12 text-center max-w-3xl mx-auto"> ... </div> -->

            <!-- Content Grid -->
            <div
                class="mx-auto grid max-w-6xl grid-cols-1 gap-8 lg:grid-cols-2"
            >
                <!-- Kartu 1: Perpustakaan -->
                <!-- IMPLEMENTATION: ScrollReveal Wrapper with no delay (first item) -->
                <ScrollReveal
                    animation="fade-up"
                    :duration="600"
                    class="h-full"
                >
                    <div
                        class="group relative h-full overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60 transition-all duration-300 hover:border-[#99cc33]/30"
                    >
                        <!-- Decorative Top Bar -->
                        <div class="h-2 w-full bg-[#99cc33]"></div>

                        <div class="p-8">
                            <div class="mb-8 flex items-center gap-4">
                                <div
                                    class="rounded-xl bg-[#99cc33]/10 p-3 text-[#99cc33] transition-colors duration-300 group-hover:bg-[#99cc33] group-hover:text-white"
                                >
                                    <BookOpen class="h-8 w-8" />
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">
                                    Perpustakaan
                                </h2>
                            </div>

                            <div class="space-y-6">
                                <!-- Item Jadwal -->
                                <div
                                    class="flex flex-col border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <div
                                        class="mb-2 flex items-center gap-3 sm:mb-0"
                                    >
                                        <Calendar
                                            class="h-5 w-5 text-slate-400"
                                        />
                                        <span class="font-medium text-slate-700"
                                            >Senin - Kamis</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-1 text-slate-600"
                                    >
                                        <Clock class="h-4 w-4 text-[#99cc33]" />
                                        <span>08.00 - 16.00 WIB</span>
                                    </div>
                                </div>

                                <!-- Item Jadwal -->
                                <div
                                    class="flex flex-col border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-start sm:justify-between"
                                >
                                    <div
                                        class="mt-1 mb-2 flex items-center gap-3 sm:mb-0"
                                    >
                                        <Calendar
                                            class="h-5 w-5 text-slate-400"
                                        />
                                        <span class="font-medium text-slate-700"
                                            >Jumat</span
                                        >
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <div
                                            class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-1 text-slate-600"
                                        >
                                            <Clock
                                                class="h-4 w-4 text-[#99cc33]"
                                            />
                                            <span>08.00 - 16.00 WIB</span>
                                        </div>
                                        <span
                                            class="rounded bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-600"
                                        >
                                            Istirahat: 11.00 - 13.00
                                        </span>
                                    </div>
                                </div>

                                <!-- Item Jadwal -->
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <div
                                        class="mb-2 flex items-center gap-3 sm:mb-0"
                                    >
                                        <Calendar
                                            class="h-5 w-5 text-slate-400"
                                        />
                                        <span
                                            class="text-sm font-medium text-slate-700 sm:text-base"
                                            >Sabtu, Minggu, Libur</span
                                        >
                                    </div>
                                    <span
                                        class="rounded-lg bg-red-50 px-3 py-1 text-sm font-semibold text-red-500"
                                    >
                                        Tutup
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </ScrollReveal>

                <!-- Kartu 2: Ruang Belajar Mandiri -->
                <!-- IMPLEMENTATION: ScrollReveal Wrapper with delay (second item) -->
                <ScrollReveal
                    animation="fade-up"
                    :delay="150"
                    :duration="600"
                    class="h-full"
                >
                    <div
                        class="group relative h-full overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60 transition-all duration-300 hover:border-[#99cc33]/30"
                    >
                        <!-- Decorative Top Bar -->
                        <div
                            class="h-2 w-full bg-slate-400 transition-colors duration-500 group-hover:bg-[#99cc33]"
                        ></div>

                        <div class="p-8">
                            <div class="mb-8 flex items-center gap-4">
                                <div
                                    class="rounded-xl bg-slate-100 p-3 text-slate-500 transition-colors duration-300 group-hover:bg-[#99cc33] group-hover:text-white"
                                >
                                    <Armchair class="h-8 w-8" />
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">
                                    Ruang Belajar Mandiri
                                </h2>
                            </div>

                            <div class="space-y-6">
                                <!-- Item Jadwal -->
                                <div
                                    class="flex flex-col border-b border-dashed border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <div
                                        class="mb-2 flex items-center gap-3 sm:mb-0"
                                    >
                                        <Calendar
                                            class="h-5 w-5 text-slate-400"
                                        />
                                        <span class="font-medium text-slate-700"
                                            >Senin - Jumat</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-1 text-slate-600"
                                    >
                                        <Clock class="h-4 w-4 text-[#99cc33]" />
                                        <span
                                            class="font-semibold text-[#99cc33]"
                                            >08.00 - 19.00 WIB</span
                                        >
                                    </div>
                                </div>

                                <!-- Item Jadwal -->
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <div
                                        class="mb-2 flex items-center gap-3 sm:mb-0"
                                    >
                                        <Calendar
                                            class="h-5 w-5 text-slate-400"
                                        />
                                        <span
                                            class="text-sm font-medium text-slate-700 sm:text-base"
                                            >Sabtu, Minggu, Libur</span
                                        >
                                    </div>
                                    <span
                                        class="rounded-lg bg-red-50 px-3 py-1 text-sm font-semibold text-red-500"
                                    >
                                        Tutup
                                    </span>
                                </div>
                            </div>

                            <!-- Decoration Circle inside card -->
                            <div
                                class="absolute -right-10 -bottom-10 z-0 h-32 w-32 rounded-full bg-slate-50"
                            ></div>
                        </div>
                    </div>
                </ScrollReveal>
            </div>

            <!-- Footer Note -->
            <!-- IMPLEMENTATION: ScrollReveal for Footer Note -->
            <ScrollReveal
                animation="fade-in"
                :delay="300"
                :duration="700"
                class="mx-auto mt-8 max-w-6xl"
            >
                <div
                    class="flex items-start gap-4 rounded-2xl border border-[#99cc33]/20 bg-[#99cc33]/10 p-5"
                >
                    <div
                        class="shrink-0 rounded-full bg-white p-2 text-[#99cc33] shadow-sm"
                    >
                        <Info class="h-5 w-5" />
                    </div>
                    <div>
                        <h4 class="mb-1 font-bold text-slate-800">
                            Catatan Penting
                        </h4>
                        <p
                            class="text-sm leading-relaxed text-slate-600 sm:text-base"
                        >
                            Selama libur semester ganjil dan genap, Perpustakaan
                            dan Ruang Belajar Mandiri
                            <span class="font-semibold text-[#99cc33]"
                                >tetap buka</span
                            >.
                        </p>
                    </div>
                </div>
            </ScrollReveal>
        </div>
    </Layout>
</template>
