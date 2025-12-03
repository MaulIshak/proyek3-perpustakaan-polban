<script setup lang="ts">
import ScrollReveal from '@/components/ScrollReveal.vue';
import Layout from '@/layouts/UserAppLayout.vue';
import { CheckCircle2, Eye, History, Target } from 'lucide-vue-next';

defineProps({
    title: {
        type: String,
        required: true,
    },
    subjudul_1: String,
    subjudul_2: String,
    subjudul_3: String,
    description: String,
    visi: String,
    misi: Array as () => string[],
});

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profil' },
    { label: 'Tentang Perpustakaan' },
];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <!-- Wrapper Responsif -->
        <div
            class="relative w-full sm:container sm:mx-auto sm:px-6 sm:py-8 lg:px-8"
        >
            <div class="grid grid-cols-1 gap-0 sm:gap-8 xl:grid-cols-12">
                <!-- SEJARAH -->
                <div class="xl:col-span-12">
                    <ScrollReveal animation="slide-left" :duration="600">
                        <div
                            class="group relative overflow-hidden rounded-[2rem] border border-y border-slate-100 bg-white shadow-none transition-all duration-300 sm:shadow-xl sm:shadow-slate-200/60 sm:hover:shadow-2xl"
                        >
                            <!-- Decorative top border -->
                            <div
                                class="absolute top-0 left-0 h-1.5 w-full bg-gradient-to-r from-[#99cc33] to-[var(--dark-green)]"
                            ></div>

                            <div class="p-6 sm:p-10">
                                <div class="mb-8 flex items-center gap-5">
                                    <div
                                        class="rounded-2xl bg-[#99cc33]/10 p-3.5 transition-colors duration-300 group-hover:bg-[#99cc33]"
                                    >
                                        <History
                                            class="h-8 w-8 text-[#99cc33] transition-colors duration-300 group-hover:text-white"
                                        />
                                    </div>
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl"
                                    >
                                        {{ subjudul_1 }}
                                    </h2>
                                </div>
                                <div
                                    class="prose max-w-none space-y-5 text-justify leading-loose text-slate-600 prose-slate"
                                >
                                    <p>
                                        Perpustakaan Polban hadir bersamaan
                                        dengan berdirinya Politeknik ITB pada
                                        tahun 1982. Awalnya, perpustakaan
                                        berlokasi di Gedung Direktorat lantai 3
                                        dengan koleksi sebanyak 3000 eksemplar
                                        yang diperoleh melalui bantuan Bank
                                        Dunia dan Project SIAPP (Second
                                        Indonesia Australia Polytechnic
                                        Project).
                                    </p>
                                    <p>
                                        Tahun 1992, perpustakaan mendapatkan
                                        bantuan dari PT. Dirgantara Indonesia
                                        (d/h IPTN) dan Yayasan Asia untuk
                                        pengembangan koleksi. Sejak saat itu,
                                        perpustakaan mulai memiliki anggaran
                                        sendiri dan pelayanan berbasis komputer
                                        hasil bantuan project SIAPP.
                                    </p>
                                    <p>
                                        Pada tahun 2004, Perpustakaan Polban
                                        mengikuti hibah kompetisi TPSDP dari
                                        Asia Development Bank dan berhasil
                                        mengembangkannya menjadi sistem
                                        manajemen berbasis digital.
                                    </p>
                                    <p>
                                        Sejak April 2016, perpustakaan menempati
                                        Gedung H lantai 1. Kini, pengguna dapat
                                        mengakses katalog buku dan koleksi
                                        digital selama 24 jam. Koleksi e-book,
                                        e-journal, dan repositori dapat diunduh
                                        secara gratis.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </ScrollReveal>
                </div>

                <!-- VISI -->
                <div class="mt-4 flex sm:mt-0 xl:col-span-5">
                    <ScrollReveal
                        animation="slide-left"
                        :duration="600"
                        class="w-full"
                    >
                        <div
                            class="group relative w-full rounded-[2rem] border-y border-[#99cc33]/10 border-slate-100 bg-white p-8 shadow-none transition-all duration-300 sm:bg-gradient-to-br sm:from-white sm:to-[#99cc33]/5 sm:shadow-lg"
                        >
                            <div class="relative z-10 flex h-full flex-col">
                                <div class="mb-6 flex items-center gap-4">
                                    <div
                                        class="rounded-xl bg-white p-3 text-[#99cc33] shadow-sm ring-1 ring-slate-100"
                                    >
                                        <Eye class="h-7 w-7" />
                                    </div>
                                    <h2
                                        class="text-2xl font-bold text-slate-800"
                                    >
                                        {{ subjudul_2 }}
                                    </h2>
                                </div>
                                <div class="flex flex-grow items-center">
                                    <p
                                        class="text-justify text-lg leading-relaxed text-slate-600"
                                    >
                                        Menjadi Pusat Sumber Belajar (Learning
                                        Resource Centre) yang mampu memenuhi
                                        beragam informasi mutakhir melalui
                                        beragam media dalam upaya membantu
                                        meningkatkan kualitas dan kemampuan
                                        kerja para lulusan Politeknik Negeri
                                        Bandung.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </ScrollReveal>
                </div>

                <!-- MISI -->
                <div class="mt-4 flex sm:mt-0 xl:col-span-7">
                    <ScrollReveal
                        animation="slide-left"
                        :duration="600"
                        class="w-full"
                    >
                        <div
                            class="group relative w-full overflow-hidden rounded-[2rem] border border-y border-slate-100 bg-white p-8 shadow-none transition-all duration-300 sm:shadow-lg"
                        >
                            <!-- Decorative element -->
                            <div
                                class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-[#99cc33]/5 blur-2xl transition-all group-hover:bg-[#99cc33]/10"
                            ></div>

                            <div class="relative z-10">
                                <div class="mb-8 flex items-center gap-4">
                                    <div
                                        class="rounded-xl bg-[#99cc33]/10 p-3 text-[#99cc33]"
                                    >
                                        <Target class="h-7 w-7" />
                                    </div>
                                    <h2
                                        class="text-2xl font-bold text-slate-800"
                                    >
                                        {{ subjudul_3 }}
                                    </h2>
                                </div>

                                <ul class="space-y-4">
                                    <li
                                        v-for="(item, index) in misi"
                                        :key="index"
                                        class="group/item flex items-start gap-4"
                                    >
                                        <div
                                            class="mt-1 rounded-full bg-white p-0.5 shadow-sm shadow-[#99cc33]/30"
                                        >
                                            <CheckCircle2
                                                class="h-6 w-6 fill-[#99cc33]/10 text-[#99cc33]"
                                            />
                                        </div>
                                        <span
                                            class="text-[1.05rem] leading-relaxed text-slate-700 transition-colors group-hover/item:text-slate-900"
                                        >
                                            {{ item }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </ScrollReveal>
                </div>
            </div>
        </div>
    </Layout>
</template>
