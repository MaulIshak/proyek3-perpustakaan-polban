<script setup>
import Layout from '@/layouts/UserAppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { X } from 'lucide-vue-next'

// Data galeri (nanti bisa diganti import dari file JS atau dari backend)
const galeriData = [
  { id: 1, image: '/Images/galeri1.jpg', caption: 'Kegiatan Literasi 2024' },
  { id: 2, image: '/Images/galeri2.jpg', caption: 'Ruang Baca Mahasiswa' },
  { id: 3, image: '/Images/galeri3.jpg', caption: 'Workshop Referensi' },
  { id: 4, image: '/Images/galeri4.jpg', caption: 'Pelatihan Mendeley' },
  { id: 5, image: '/Images/galeri5.jpg', caption: 'Koleksi Buku Baru' },
  { id: 6, image: '/Images/galeri6.jpg', caption: 'Layanan Pustakawan' }
]

// Gambar yang sedang dipilih
const selectedImage = ref(null)
</script>

<template>
  <Layout>
    <div class="min-h-screen py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
          <nav class="text-sm text-gray-500 mb-4">
            <Link href="/" class="hover:text-[var(--primary-green)]">Home</Link>
            <span class="mx-2">/</span>
            <span class="text-gray-800">Galeri</span>
          </nav>
          <h1 class="text-4xl font-bold text-gray-800">Galeri Foto</h1>
          <p class="text-gray-600 mt-2">
            Dokumentasi kegiatan dan fasilitas UPT Perpustakaan POLBAN
          </p>
        </div>

        <!-- Grid Galeri -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          <div
            v-for="item in galeriData"
            :key="item.id"
            class="relative overflow-hidden rounded-lg cursor-pointer group"
            @click="selectedImage = item.image"
          >
            <img
              :src="item.image"
              :alt="item.caption"
              class="w-full h-64 object-cover transition-transform group-hover:scale-110"
            />
            <div
              class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center"
            >
              <span
                class="text-white opacity-0 group-hover:opacity-100 transition-opacity font-medium"
              >
                Klik untuk memperbesar
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Lightbox -->
      <div
        v-if="selectedImage"
        class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
        @click="selectedImage = null"
      >
        <button
          class="absolute top-4 right-4 text-white hover:text-gray-300"
          @click.stop="selectedImage = null"
        >
          <X class="w-8 h-8" />
        </button>
        <img
          :src="selectedImage"
          alt="Preview"
          class="max-w-full max-h-full object-contain"
          @click.stop
        />
      </div>
    </div>
  </Layout>
</template>
