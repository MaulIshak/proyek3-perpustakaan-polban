<script setup>
import Layout from '@/layouts/UserAppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Download, FileText, Image, CheckCircle } from 'lucide-vue-next'

// tab aktif
const activeTab = ref('alur')
</script>

<template>
  <Layout>
    <div class="min-h-screen py-12 bg-gray-50">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
          <nav class="text-sm text-gray-500 mb-4">
            <Link href="/" class="hover:text-[var(--primary-green)]">Home</Link>
            <span class="mx-2">/</span>
            <span class="text-gray-800">Bebas Masalah</span>
          </nav>
          <h1 class="text-4xl font-bold text-gray-800">Bebas Masalah Perpustakaan</h1>
          <p class="text-gray-600 mt-2">Informasi dan persyaratan untuk wisudawan</p>
        </div>

        <!-- Tabs -->
        <div class="p-6 bg-white shadow rounded-lg">
          <!-- Tab Header -->
          <div class="grid grid-cols-5 mb-6 border-b border-gray-200">
            <button
              v-for="tab in ['alur', 'persyaratan', 'panduan', 'SP3KTI', 'watermark']"
              :key="tab"
              class="py-2 text-center text-gray-600 font-medium hover:text-[var(--primary-green)]"
              :class="{ 'border-b-2 border-[var(--primary-green)] text-[var(--primary-green)]': activeTab === tab }"
              @click="activeTab = tab"
            >
              {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
            </button>
          </div>

          <!-- Tab Content -->
          <div v-if="activeTab === 'alur'" class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Diagram Alur Bebas Masalah</h2>
            <div class="bg-gradient-to-br from-emerald-50 to-white p-8 rounded-lg border border-emerald-200 transition duration-300 hover:shadow-2xl hover:bg-gradient-to-br hover:from-green-100 hover:to-green-200 hover:scale-101">
              <img
                src="/Images/Diagram_Alur.png"
                alt="Diagram Alur"
                class="w-full max-w-3xl mx-auto rounded-lg shadow-md"
              />
              <p class="text-center text-gray-600 mt-4 text-sm">Alur proses Bebas Masalah Perpustakaan</p>
            </div>
          </div>

          <div v-if="activeTab === 'persyaratan'" class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Persyaratan Bebas Masalah</h2>
            <div class="space-y-4">
              <div
                v-for="(item, index) in [
                  { title: '1. Pengembalian Buku', desc: 'Mengembalikan seluruh buku yang dipinjam dan memastikan tidak ada tunggakan denda.' },
                  { title: '2. Penyerahan Tugas Akhir', desc: 'Menyerahkan 1 (satu) eksemplar hard copy tugas akhir yang telah dijilid hardcover.' },
                  { title: '3. Upload Soft Copy', desc: 'Mengunggah file PDF tugas akhir ke Repository POLBAN sesuai format yang ditentukan.' },
                  { title: '4. Surat Pernyataan', desc: 'Mengisi dan menandatangani surat pernyataan publikasi karya ilmiah di atas meterai.' },
                  { title: '5. Watermark Logo POLBAN', desc: 'Menempelkan watermark logo POLBAN pada halaman judul tugas akhir.' }
                ]"
                :key="index"
                class="p-5 border border-emerald-200 rounded-lg flex items-start gap-3 bg-white transition hover:scale-102 duration-300 hover:-translate-y-1 hover:bg-gradient-to-br hover:from-green-100 hover:to-green-300"
              >
                <CheckCircle class="w-6 h-6 text-[var(--primary-green)] flex-shrink-0 mt-0.5" />
                <div>
                  <h3 class="font-semibold text-gray-800 mb-1">{{ item.title }}</h3>
                  <p class="text-gray-600 text-sm">{{ item.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <div v-if="activeTab === 'panduan'" class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Panduan Pengiriman Karya Tulis</h2>
            <div class="p-6 bg-gray-50 rounded-lg">
              <ol class="space-y-4 text-gray-700">
                <li
                  v-for="(item, index) in [
                    { step: '1.', title: 'Persiapan Dokumen', desc: 'Pastikan file PDF tugas akhir telah final dan sesuai format. Nama file: NIM_NamaLengkap_Judul.pdf' },
                    { step: '2.', title: 'Akses Repository', desc: 'Login ke Repository POLBAN menggunakan akun mahasiswa (NIM dan password).' },
                    { step: '3.', title: 'Upload File', desc: 'Pilih menu Submit New Item dan ikuti petunjuk upload. Isi metadata dengan lengkap dan benar.' },
                    { step: '4.', title: 'Verifikasi', desc: 'Tunggu proses verifikasi oleh pustakawan (maksimal 3 hari kerja).' },
                    { step: '5.', title: 'Cetak Bukti', desc: 'Setelah disetujui, cetak bukti upload sebagai persyaratan Bebas Masalah.' }
                  ]"
                  :key="index"
                  class="flex items-start gap-3"
                >
                  <span class="font-bold text-[var(--primary-green)] text-lg">{{ item.step }}</span>
                  <div>
                    <p class="font-medium">{{ item.title }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ item.desc }}</p>
                  </div>
                </li>
              </ol>
            </div>
          </div>

          <div v-if="activeTab === 'SP3KTI'" class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Template Surat Pernyataan</h2>
            <div class="p-6 bg-white rounded-lg shadow">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center">
                  <FileText class="w-8 h-8 text-[var(--primary-green)]" />
                </div>
                <div>
                  <h3 class="font-bold text-lg text-gray-800">Surat Pernyataan Publikasi</h3>
                  <p class="text-sm text-gray-600">Format PDF - Ukuran: 150 KB</p>
                </div>
              </div>
              <button class="bg-[var(--primary-green)] hover:bg-emerald-700 text-white px-4 py-2 rounded-md flex items-center">
                <Download class="w-4 h-4 mr-2" />
                Download Template
              </button>
              <p class="text-sm text-gray-600 mt-4">
                Cetak template, isi data diri, tandatangani di atas meterai Rp 10.000, dan serahkan ke perpustakaan.
              </p>
            </div>
          </div>

          <div v-if="activeTab === 'watermark'" class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Watermark Logo Kampus</h2>
            <div class="p-6 bg-white rounded-lg shadow">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center">
                  <Image class="w-8 h-8 text-[var(--primary-green)]" />
                </div>
                <div>
                  <h3 class="font-bold text-lg text-gray-800">Logo POLBAN Watermark</h3>
                  <p class="text-sm text-gray-600">Format PNG Transparan - Ukuran: 2 MB</p>
                </div>
              </div>
              <button class="bg-[var(--primary-green)] hover:bg-emerald-700 text-white px-4 py-2 rounded-md flex items-center">
                <Download class="w-4 h-4 mr-2" />
                Download Watermark
              </button>
              <p class="text-sm text-gray-600 mt-4">
                Tempelkan watermark pada halaman judul tugas akhir dengan posisi di tengah dan opacity 30%.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
