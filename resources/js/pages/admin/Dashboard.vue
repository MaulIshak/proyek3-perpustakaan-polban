<template>
  <AdminLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">
          Selamat datang di Admin Panel UPT Perpustakaan Polban
        </p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div
          class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col"
        >
          <h2 class="text-sm text-gray-500">Total Berita</h2>
          <div class="text-3xl font-bold text-gray-800 mt-1">24</div>
          <p class="text-xs text-emerald-600 mt-1">+3 bulan ini</p>
        </div>

        <div
          class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col"
        >
          <h2 class="text-sm text-gray-500">Pengumuman</h2>
          <div class="text-3xl font-bold text-gray-800 mt-1">12</div>
          <p class="text-xs text-emerald-600 mt-1">+2 minggu ini</p>
        </div>

        <div
          class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col"
        >
          <h2 class="text-sm text-gray-500">Foto Galeri</h2>
          <div class="text-3xl font-bold text-gray-800 mt-1">156</div>
          <p class="text-xs text-emerald-600 mt-1">+15 foto baru</p>
        </div>

        <div
          class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col"
        >
          <h2 class="text-sm text-gray-500">Booking Buku</h2>
          <div class="text-3xl font-bold text-gray-800 mt-1">8</div>
          <p class="text-xs text-orange-600 mt-1">Menunggu konfirmasi</p>
        </div>
      </div>

      <!-- Activity + Quick Actions -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Activity -->
        <div
          class="col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5"
        >
          <h3 class="text-lg font-semibold text-gray-800 mb-3">
            Aktivitas Terkini
          </h3>

          <div class="space-y-4">
            <div>
              <div class="flex items-center gap-2 text-sm">
                <span
                  class="px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full"
                  >Berita</span
                >
                <span
                  class="px-2 py-0.5 text-xs bg-emerald-50 text-emerald-600 rounded-full"
                  >Published</span
                >
              </div>
              <p class="font-medium text-gray-800 mt-1">
                Workshop Literasi Digital 2024
              </p>
              <p class="text-xs text-gray-500 mt-0.5">2 jam lalu</p>
            </div>

            <div>
              <div class="flex items-center gap-2 text-sm">
                <span
                  class="px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full"
                  >Pengumuman</span
                >
                <span
                  class="px-2 py-0.5 text-xs bg-emerald-50 text-emerald-600 rounded-full"
                  >Published</span
                >
              </div>
              <p class="font-medium text-gray-800 mt-1">
                Perpanjangan Waktu Peminjaman
              </p>
              <p class="text-xs text-gray-500 mt-0.5">5 jam lalu</p>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div
          class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex flex-col"
        >
          <h3 class="text-lg font-semibold text-gray-800 mb-3">
            Quick Actions
          </h3>
          <p class="text-sm text-gray-500 mb-4">
            Akses cepat fitur utama
          </p>

          <button
            class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg px-4 py-2 mb-2 transition"
          >
            Buat Berita Baru
          </button>

          <button
            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg px-4 py-2 mb-2 transition"
          >
            Buat Pengumuman
          </button>

          <button
            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg px-4 py-2 transition"
          >
            Upload Foto Galeri
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>
