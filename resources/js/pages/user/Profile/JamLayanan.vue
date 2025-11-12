<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const breadcrumb = [{ label: 'Profil' }, { label: 'Jam Layanan' }];
</script>
<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="container mx-auto px-4 py-10 leading-relaxed sm:px-6 lg:px-8">
            <!-- Header -->
            <!-- Kartu Jadwal -->
            <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- Header Kartu -->

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-gray-700">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold border-b border-gray-200 w-1/2">Hari</th>
                                <th class="px-6 py-3 text-left font-semibold border-b border-gray-200 w-1/2">Jam Operasional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Perpustakaan -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 border-b border-gray-200 font-medium">Perpustakaan</td>
                                <td class="px-6 py-3 border-b border-gray-200 text-gray-600">-</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 border-b border-gray-200">Senin - Kamis</td>
                                <td class="px-6 py-3 border-b border-gray-200">08.00 - 16.00 WIB</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 border-b border-gray-200">Jumat</td>
                                <td class="px-6 py-3 border-b border-gray-200">
                                    08.00 - 16.00 WIB <br>
                                    <span class="text-sm text-gray-500">Istirahat: 11.00 - 13.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 border-b border-gray-200">Sabtu, Minggu, Libur Nasional, Cuti Bersama</td>
                                <td class="px-6 py-3 border-b border-gray-200 text-gray-500 italic">Tutup</td>
                            </tr>

                            <!-- Ruang Belajar Mandiri -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 border-b border-gray-200 font-medium">Ruang Belajar Mandiri</td>
                                <td class="px-6 py-3 border-b border-gray-200 text-gray-600">-</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 border-b border-gray-200">Senin - Jumat</td>
                                <td class="px-6 py-3 border-b border-gray-200">08.00 - 19.00 WIB</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 border-b border-gray-200">Sabtu, Minggu, Libur Nasional, Cuti Bersama</td>
                                <td class="px-6 py-3 border-b border-gray-200 text-gray-500 italic">Tutup</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Catatan -->
                <div class="bg-green-50 px-5 py-3 border-t border-gray-200">
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold text-green-700">Catatan:</span>
                        Selama libur semester ganjil dan genap, Perpustakaan dan Ruang Belajar Mandiri tetap buka.
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>