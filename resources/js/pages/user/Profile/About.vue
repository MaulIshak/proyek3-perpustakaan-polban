<script setup lang="ts">
import RemahanRoti from '@/layouts/RemahanRoti.vue';
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: String,
    subjudul_1: String,
    subjudul_2: String,
    subjudul_3: String,
    description: String,
    visi: String,
    misi: Array as () => string[],
});

const breadcrumb = [
    { label: 'Profil' },
    { label: 'Tentang Perpustakaan' }
];
</script>

<template>
    <Layout>
        <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8 max-w-4xl leading-relaxed">
            <!-- Breadcrumb -->
            <RemahanRoti :itemRoti="breadcrumb" />

            <!-- Judul Halaman -->
            <h1 class="text-4xl font-extrabold text-gray-900 pb-2">
                {{ title }}
            </h1>
            <p class="mb-8">Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            

            <div class="bg-white rounded-2xl shadow-lg p-8 space-y-10">
                <!-- Sejarah -->
                <section>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-6 w-6 text-green-600 mr-3" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ subjudul_1 }}
                    </h2>

                    <div class="text-gray-700 text-justify space-y-4 pl-9">
                        <p>
                            Perpustakaan Polban hadir bersamaan dengan berdirinya Politeknik ITB pada tahun 1982. 
                            Awalnya, perpustakaan berlokasi di Gedung Direktorat lantai 3 dengan koleksi sebanyak 
                            3000 eksemplar yang diperoleh melalui bantuan Bank Dunia dan Project SIAPP 
                            (Second Indonesia Australia Polytechnic Project).
                        </p>
                        <p>
                            Tahun 1992, perpustakaan mendapatkan bantuan dari PT. Dirgantara Indonesia (d/h IPTN) 
                            dan Yayasan Asia untuk pengembangan koleksi. Sejak saat itu, perpustakaan mulai memiliki 
                            anggaran sendiri dan pelayanan berbasis komputer hasil bantuan project SIAPP.
                        </p>
                        <p>
                            Pada tahun 2004, Perpustakaan Polban mengikuti hibah kompetisi TPSDP dari 
                            Asia Development Bank dan berhasil mengembangkannya menjadi sistem manajemen 
                            berbasis digital. Sistem ini memudahkan proses pengelolaan serta pelayanan.
                        </p>
                        <p>
                            Sejak April 2016, perpustakaan menempati Gedung H lantai 1. Kini, pengguna dapat mengakses 
                            katalog buku dan koleksi digital selama 24 jam. Koleksi e-book, e-journal, dan repositori 
                            dapat diunduh secara gratis.
                        </p>
                    </div>
                </section>

                <!-- Visi -->
                <section>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-6 w-6 text-green-600 mr-3" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10l4.55-4.55a2 2 0 012.83 0l.42.42a2 2 0 010 2.83L17.83 14H18a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2a2 2 0 012-2h.17l-4.22-4.22a2 2 0 010-2.83l.42-.42a2 2 0 012.83 0L9 10z" />
                        </svg>
                        {{ subjudul_2 }}
                    </h2>
                    <p class="text-gray-700 text-justify pl-9">
                        Menjadi Pusat Sumber Belajar (Learning Resource Centre) yang mampu memenuhi beragam informasi mutakhir melalui beragam media dalam upaya membantu meningkatkan kualitas dan kemampuan kerja para lulusan Politeknik Negeri Bandung.
                    </p>
                </section>

                <!-- Misi -->
                <section>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-6 w-6 text-green-600 mr-3" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ subjudul_3 }}
                    </h2>
                    <ul class="text-gray-700 space-y-3 pl-12 list-disc">
                        <li v-for="(item, index) in misi" :key="index">
                            {{ item }}
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </Layout>
</template>
