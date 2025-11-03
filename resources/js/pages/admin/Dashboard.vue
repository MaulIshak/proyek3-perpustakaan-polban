<template>
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div
                class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h2 class="text-sm text-gray-500">Total Berita</h2>
                <div class="mt-1 text-3xl font-bold text-gray-800">24</div>
                <p class="mt-1 text-xs text-emerald-600">+3 bulan ini</p>
            </div>

            <div
                class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h2 class="text-sm text-gray-500">Pengumuman</h2>
                <div class="mt-1 text-3xl font-bold text-gray-800">12</div>
                <p class="mt-1 text-xs text-emerald-600">+2 minggu ini</p>
            </div>

            <div
                class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h2 class="text-sm text-gray-500">Foto Galeri</h2>
                <div class="mt-1 text-3xl font-bold text-gray-800">156</div>
                <p class="mt-1 text-xs text-emerald-600">+15 foto baru</p>
            </div>

            <div
                class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h2 class="text-sm text-gray-500">Booking Buku</h2>
                <div class="mt-1 text-3xl font-bold text-gray-800">8</div>
                <p class="mt-1 text-xs text-orange-600">Menunggu konfirmasi</p>
            </div>
        </div>

        <!-- Activity + Quick Actions -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <!-- Activity -->
            <div
                class="col-span-2 rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h3 class="mb-3 text-lg font-semibold text-gray-800">
                    Aktivitas Terkini
                </h3>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center gap-2 text-sm">
                            <span
                                class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs text-emerald-700"
                                >Berita</span
                            >
                            <span
                                class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-emerald-600"
                                >Published</span
                            >
                        </div>
                        <p class="mt-1 font-medium text-gray-800">
                            Workshop Literasi Digital 2024
                        </p>
                        <p class="mt-0.5 text-xs text-gray-500">2 jam lalu</p>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-sm">
                            <span
                                class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs text-emerald-700"
                                >Pengumuman</span
                            >
                            <span
                                class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-emerald-600"
                                >Published</span
                            >
                        </div>
                        <p class="mt-1 font-medium text-gray-800">
                            Perpanjangan Waktu Peminjaman
                        </p>
                        <p class="mt-0.5 text-xs text-gray-500">5 jam lalu</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
            >
                <h3 class="mb-3 text-lg font-semibold text-gray-800">
                    Quick Actions
                </h3>
                <p class="mb-4 text-sm text-gray-500">
                    Akses cepat fitur utama
                </p>

                <button
                    class="mb-2 w-full rounded-lg bg-emerald-500 px-4 py-2 font-medium text-white transition hover:bg-emerald-600"
                >
                    Buat Berita Baru
                </button>

                <button
                    class="mb-2 w-full rounded-lg bg-gray-100 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-200"
                >
                    Buat Pengumuman
                </button>

                <button
                    class="w-full rounded-lg bg-gray-100 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-200"
                >
                    Upload Foto Galeri
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Dashboard',
                subTitle: 'Ringkasan aktivitas dan statistik terbaru',
            },
            { default: () => page },
        ),
});
</script>
