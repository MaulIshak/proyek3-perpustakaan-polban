<script setup>
import Layout from '@/layouts/UserAppLayout.vue';
import { CheckCircle, Download, FileText, Image } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumb = [{ label: 'Bebas Masalah' }];
// tab aktif
const activeTab = ref('alur');
</script>

<template>
    <Layout :page="true" title="Bebas Masalah" :breadcrumb="breadcrumb">
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <!-- <div class="mb-8">
                    <p class="mt-2 text-gray-600">
                        Informasi dan persyaratan untuk wisudawan
                    </p>
                </div> -->

                <!-- Tabs -->
                <div class="rounded-lg bg-white p-6 shadow">
                    <!-- Tab Header -->
                    <div class="mb-6 grid grid-cols-5 border-b border-gray-200">
                        <button
                            v-for="tab in [
                                'alur',
                                'persyaratan',
                                'panduan',
                                'template',
                                'watermark',
                            ]"
                            :key="tab"
                            class="py-2 text-center font-medium text-gray-600 hover:text-emerald-600"
                            :class="{
                                'border-b-2 border-emerald-600 text-emerald-600':
                                    activeTab === tab,
                            }"
                            @click="activeTab = tab"
                        >
                            {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div v-if="activeTab === 'alur'" class="space-y-4">
                        <h2 class="mb-4 text-2xl font-bold text-gray-800">
                            Diagram Alur Bebas Masalah
                        </h2>
                        <div
                            class="rounded-lg border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-8"
                        >
                            <img
                                src="/Images/Diagram_Alur.png"
                                alt="Diagram Alur"
                                class="mx-auto w-full max-w-3xl rounded-lg shadow-md"
                            />
                            <p class="mt-4 text-center text-sm text-gray-600">
                                Alur proses Bebas Masalah Perpustakaan
                            </p>
                        </div>
                    </div>

                    <div v-if="activeTab === 'persyaratan'" class="space-y-4">
                        <h2 class="mb-4 text-2xl font-bold text-gray-800">
                            Persyaratan Bebas Masalah
                        </h2>
                        <div class="space-y-4">
                            <div
                                v-for="(item, index) in [
                                    {
                                        title: '1. Pengembalian Buku',
                                        desc: 'Mengembalikan seluruh buku yang dipinjam dan memastikan tidak ada tunggakan denda.',
                                    },
                                    {
                                        title: '2. Penyerahan Tugas Akhir',
                                        desc: 'Menyerahkan 1 (satu) eksemplar hard copy tugas akhir yang telah dijilid hardcover.',
                                    },
                                    {
                                        title: '3. Upload Soft Copy',
                                        desc: 'Mengunggah file PDF tugas akhir ke Repository POLBAN sesuai format yang ditentukan.',
                                    },
                                    {
                                        title: '4. Surat Pernyataan',
                                        desc: 'Mengisi dan menandatangani surat pernyataan publikasi karya ilmiah di atas meterai.',
                                    },
                                    {
                                        title: '5. Watermark Logo POLBAN',
                                        desc: 'Menempelkan watermark logo POLBAN pada halaman judul tugas akhir.',
                                    },
                                ]"
                                :key="index"
                                class="flex items-start gap-3 rounded-lg border border-emerald-200 bg-white p-5"
                            >
                                <CheckCircle
                                    class="mt-0.5 h-6 w-6 flex-shrink-0 text-emerald-600"
                                />
                                <div>
                                    <h3
                                        class="mb-1 font-semibold text-gray-800"
                                    >
                                        {{ item.title }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ item.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab === 'panduan'" class="space-y-4">
                        <h2 class="mb-4 text-2xl font-bold text-gray-800">
                            Panduan Pengiriman Karya Tulis
                        </h2>
                        <div class="rounded-lg bg-gray-50 p-6">
                            <ol class="space-y-4 text-gray-700">
                                <li
                                    v-for="(item, index) in [
                                        {
                                            step: '1.',
                                            title: 'Persiapan Dokumen',
                                            desc: 'Pastikan file PDF tugas akhir telah final dan sesuai format. Nama file: NIM_NamaLengkap_Judul.pdf',
                                        },
                                        {
                                            step: '2.',
                                            title: 'Akses Repository',
                                            desc: 'Login ke Repository POLBAN menggunakan akun mahasiswa (NIM dan password).',
                                        },
                                        {
                                            step: '3.',
                                            title: 'Upload File',
                                            desc: 'Pilih menu Submit New Item dan ikuti petunjuk upload. Isi metadata dengan lengkap dan benar.',
                                        },
                                        {
                                            step: '4.',
                                            title: 'Verifikasi',
                                            desc: 'Tunggu proses verifikasi oleh pustakawan (maksimal 3 hari kerja).',
                                        },
                                        {
                                            step: '5.',
                                            title: 'Cetak Bukti',
                                            desc: 'Setelah disetujui, cetak bukti upload sebagai persyaratan Bebas Masalah.',
                                        },
                                    ]"
                                    :key="index"
                                    class="flex items-start gap-3"
                                >
                                    <span
                                        class="text-lg font-bold text-emerald-600"
                                        >{{ item.step }}</span
                                    >
                                    <div>
                                        <p class="font-medium">
                                            {{ item.title }}
                                        </p>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ item.desc }}
                                        </p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div v-if="activeTab === 'template'" class="space-y-4">
                        <h2 class="mb-4 text-2xl font-bold text-gray-800">
                            Template Surat Pernyataan
                        </h2>
                        <div class="rounded-lg bg-white p-6 shadow">
                            <div class="mb-4 flex items-center gap-4">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200"
                                >
                                    <FileText
                                        class="h-8 w-8 text-emerald-600"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        Surat Pernyataan Publikasi
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Format PDF - Ukuran: 150 KB
                                    </p>
                                </div>
                            </div>
                            <button
                                class="flex items-center rounded-md bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700"
                            >
                                <Download class="mr-2 h-4 w-4" />
                                Download Template
                            </button>
                            <p class="mt-4 text-sm text-gray-600">
                                Cetak template, isi data diri, tandatangani di
                                atas meterai Rp 10.000, dan serahkan ke
                                perpustakaan.
                            </p>
                        </div>
                    </div>

                    <div v-if="activeTab === 'watermark'" class="space-y-4">
                        <h2 class="mb-4 text-2xl font-bold text-gray-800">
                            Watermark Logo Kampus
                        </h2>
                        <div class="rounded-lg bg-white p-6 shadow">
                            <div class="mb-4 flex items-center gap-4">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200"
                                >
                                    <Image class="h-8 w-8 text-emerald-600" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        Logo POLBAN Watermark
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Format PNG Transparan - Ukuran: 2 MB
                                    </p>
                                </div>
                            </div>
                            <button
                                class="flex items-center rounded-md bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700"
                            >
                                <Download class="mr-2 h-4 w-4" />
                                Download Watermark
                            </button>
                            <p class="mt-4 text-sm text-gray-600">
                                Tempelkan watermark pada halaman judul tugas
                                akhir dengan posisi di tengah dan opacity 30%.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
