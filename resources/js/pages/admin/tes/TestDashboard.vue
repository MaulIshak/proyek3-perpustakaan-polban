<template>
  <div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between">
      <div>
        <div class="px-6 py-6 font-bold text-emerald-700 text-xl">Perpustakaan POLBAN</div>
        <nav class="px-4 space-y-2">
          <SidebarLink icon="home" label="Dashboard" active />
          <SidebarLink icon="book-open" label="Berita" />
          <SidebarLink icon="megaphone" label="Pengumuman" />
          <SidebarLink icon="image" label="Galeri" />
          <SidebarLink icon="bookmark" label="Booking Buku" />
        </nav>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Header Section -->
      <div class="bg-emerald-100 rounded-2xl flex justify-between items-center p-6 overflow-hidden relative">
        <div>
          <h1 class="text-2xl font-bold text-emerald-900">Trending Books This Month</h1>
          <p class="text-emerald-700 mt-2 max-w-md">
            Jelajahi buku-buku yang paling banyak dibaca di bulan ini.
          </p>
          <button
            class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl font-medium shadow">
            Lihat Sekarang
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import SidebarLink from './SidebarLink.vue'
</script>
