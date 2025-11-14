<script setup>
import Layout from '@/layouts/UserAppLayout.vue';

// 1. Definisikan breadcrumb untuk layout
const breadcrumb = [
    { label: 'Pelayanan' }, // Anda bisa sesuaikan label ini
    { label: 'E-Journal' },
];

// 2. Data untuk tabel e-journal (diambil dari file React Anda)
const data = [
  {
    nama: "Emerald Insight",
    link: "https://www.emerald.com/insight/",
    subjek: "Manajemen, Ekonomi, Bisnis",
    imgUrl: "https://placehold.co/120x50/00644D/FFFFFF?text=Emerald"
  },
  {
    nama: "ProQuest",
    link: "https://www.proquest.com/",
    subjek: "Multi-disiplin",
    imgUrl: "https://placehold.co/120x50/002D72/FFFFFF?text=ProQuest"
  },
  {
    nama: "ScienceDirect",
    link: "https://www.sciencedirect.com/",
    subjek: "Sains, Teknologi, Medis",
    imgUrl: "https://placehold.co/120x50/FF6C28/FFFFFF?text=ScienceDirect"
  },
  {
    nama: "IEEE Xplore",
    link: "https://ieeexplore.ieee.org/",
    subjek: "Teknik Elektro, Ilmu Komputer",
    imgUrl: "/hero-bg.jpg"
  },
  {
    nama: "JSTOR",
    link: "https://www.jstor.org/",
    subjek: "Humaniora, Ilmu Sosial",
    imgUrl: ""
  },
  // -- CONTOH BARU UNTUK LINK TEKS --
  {
    nama: "Garuda Portal",
    link: "https://garuda.kemdikbud.go.id/",
    subjek: "Publikasi Ilmiah Indonesia",
    imgUrl: ""
  },
];
</script>

<template>
    <!-- 3. Gunakan komponen Layout dengan props yang sesuai -->
    <Layout :page="true" :breadcrumb="breadcrumb" title="Daftar E-Journal">

        <!-- 4. Gunakan struktur container dari template -->
        <div class="py-12">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">

                <!-- 5. Gunakan struktur card dari template -->
                <div class="flex justify-center">
                    <div class="bg-white rounded-xl shadow-xl p-10 w-full max-w-7xl border border-[var(--primary-green)]">

                        <!-- 6. TITLE (Diadaptasi dari template) -->
                        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
                            Daftar E-Journal
                        </h1>

                        <!-- 7. KONTEN TABEL (Diambil dari React, diubah ke v-for) -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm mb-10">
                            <table class="w-full border-collapse">
                                <thead class="bg-gray-200">
                                    <tr class="text-left">
                                        <th class="p-3 font-semibold text-gray-700">Nama</th>
                                        <!-- Judul diubah agar lebih umum -->
                                        <th class="p-3 font-semibold text-gray-700">Link</th>
                                        <th class="p-3 font-semibold text-gray-700">Subjek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Gunakan v-for untuk iterasi data -->
                                    <tr v-for="(item, index) in data" :key="index" class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="p-3 font-medium text-gray-800 text-center">
                                            {{ item.nama }}
                                        </td>
                                        <td class="p-3 flex justify-center">
                                            <!-- 1. Tampilkan gambar JIKA item.imgUrl ADA -->
                                            <a v-if="item.imgUrl" :href="item.link" target="_blank" rel="noopener noreferrer" :title="'Buka ' + item.nama">
                                                <img :src="item.imgUrl" :alt="item.nama + ' Logo'" class="h-30 w-70 rounded-md hover:opacity-80 transition-opacity" />
                                            </a>
                                            
                                            <!-- 2. Tampilkan link teks JIKA item.imgUrl TIDAK ADA -->
                                            <a v-else :href="item.link" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline hover:text-blue-800">
                                                {{ item.link }}
                                            </a>
                                        </td>
                                        <td class="p-3 text-gray-700">
                                            {{ item.subjek }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- 8. KONTEN ATURAN -->
                        <h2 class="text-2xl font-semibold mt-10 mb-3 text-gray-800">
                            Aturan Akses E-Journal
                        </h2>
                        <ul class="list-disc ml-6 space-y-2 text-gray-700 leading-relaxed">
                            <li>E-Journal hanya dapat diakses menggunakan jaringan kampus.</li>
                            <li>Dilarang membagikan akun akses kepada pihak luar.</li>
                            <li>Pengguna wajib mematuhi lisensi dan aturan penggunaan database.</li>
                            <li>Download artikel hanya untuk keperluan akademik.</li>
                            <li>Menyebarkan file hasil download tanpa izin adalah pelanggaran.</li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
        
    </Layout>
</template>