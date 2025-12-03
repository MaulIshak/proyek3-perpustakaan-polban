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
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/10 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
        </div>

        <div
            class="relative w-full py-4 sm:container sm:mx-auto sm:px-6 sm:py-8 lg:px-8"
        >
            <div class="grid grid-cols-1 gap-6 sm:gap-8 xl:grid-cols-12">
                <div class="xl:col-span-12">
                    <ScrollReveal animation="fade-up" :duration="600">
                        <div
                            class="group relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50 transition-all duration-300 hover:border-[#99cc33]/40 hover:shadow-[#99cc33]/10"
                        >
                            <div
                                class="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-[#99cc33]/10 blur-3xl transition-all duration-500 group-hover:bg-[#99cc33]/20"
                            ></div>

                            <div
                                class="relative border-b border-slate-100 bg-gradient-to-r from-[#99cc33]/10 to-transparent px-6 py-6 sm:px-10 sm:py-8"
                            >
                                <div class="flex items-center gap-5">
                                    <div
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/40 transition-transform duration-300 group-hover:scale-110"
                                    >
                                        <History class="h-7 w-7" />
                                    </div>
                                    <div>
                                        <h2
                                            class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl"
                                        >
                                            {{ subjudul_1 }}
                                        </h2>
                                        <div
                                            class="mt-2 h-1 w-20 rounded-full bg-[#99cc33]/40"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 sm:p-10">
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

                <div class="flex xl:col-span-5">
                    <ScrollReveal
                        animation="slide-left"
                        :duration="600"
                        class="w-full"
                    >
                        <div
                            class="group relative flex h-full w-full flex-col overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/40"
                        >
                            <div
                                class="relative border-b border-slate-100 bg-orange-50/80 px-8 py-6"
                            >
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500 text-white shadow-lg shadow-orange-500/30"
                                    >
                                        <Eye class="h-6 w-6" />
                                    </div>
                                    <h2
                                        class="text-2xl font-bold text-slate-800"
                                    >
                                        {{ subjudul_2 }}
                                    </h2>
                                </div>
                            </div>

                            <div
                                class="flex flex-grow items-center bg-gradient-to-b from-white to-orange-50/30 p-8"
                            >
                                <p
                                    class="text-justify text-lg leading-relaxed font-medium text-slate-700"
                                >
                                    "Menjadi Pusat Sumber Belajar (Learning
                                    Resource Centre) yang mampu memenuhi beragam
                                    informasi mutakhir melalui beragam media
                                    dalam upaya membantu meningkatkan kualitas
                                    dan kemampuan kerja para lulusan Politeknik
                                    Negeri Bandung."
                                </p>
                            </div>
                        </div>
                    </ScrollReveal>
                </div>

                <div class="flex xl:col-span-7">
                    <ScrollReveal
                        animation="slide-left"
                        :duration="600"
                        class="w-full"
                    >
                        <div
                            class="group relative flex h-full w-full flex-col overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-blue-500/40"
                        >
                            <div
                                class="absolute -right-10 -bottom-10 h-48 w-48 rounded-full bg-blue-500/10 blur-3xl transition-all group-hover:bg-blue-500/20"
                            ></div>

                            <div
                                class="relative border-b border-slate-100 bg-blue-500/10 px-8 py-6"
                            >
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white shadow-lg shadow-blue-500/30"
                                    >
                                        <Target class="h-6 w-6" />
                                    </div>
                                    <h2
                                        class="text-2xl font-bold text-slate-800"
                                    >
                                        {{ subjudul_3 }}
                                    </h2>
                                </div>
                            </div>

                            <div class="relative z-10 p-8">
                                <ul class="space-y-4">
                                    <li
                                        v-for="(item, index) in misi"
                                        :key="index"
                                        class="group/item flex items-start gap-4 rounded-xl p-2 transition-colors hover:bg-blue-500/5"
                                    >
                                        <div class="mt-1 shrink-0">
                                            <CheckCircle2
                                                class="h-6 w-6 text-blue-500 drop-shadow-sm transition-transform duration-300 group-hover/item:scale-110"
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
