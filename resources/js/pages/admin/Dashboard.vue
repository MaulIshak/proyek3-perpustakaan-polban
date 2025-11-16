<template>
    <div class="space-y-8">
        <!-- Stats Section -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-[var(--primary-green)] text-white"
                >
                    <Newspaper class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-sm font-medium text-[var(--dark-green)]">
                        Total Berita
                    </h2>
                    <div class="mt-0.5 text-3xl font-bold text-gray-800">
                        24
                    </div>
                    <p class="mt-1 text-xs text-[var(--primary-green)]">
                        +3 bulan ini
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-br from-emerald-100/40 to-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white"
                >
                    <Megaphone class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-sm font-medium text-[var(--dark-green)]">
                        Pengumuman
                    </h2>
                    <div class="mt-0.5 text-3xl font-bold text-gray-800">
                        12
                    </div>
                    <p class="mt-1 text-xs text-[var(--primary-green)]">
                        +2 minggu ini
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-br from-yellow-50 to-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-400 text-white"
                >
                    <Image class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-sm font-medium text-[var(--dark-green)]">
                        Foto Galeri
                    </h2>
                    <div class="mt-0.5 text-3xl font-bold text-gray-800">
                        156
                    </div>
                    <p class="mt-1 text-xs text-[var(--primary-green)]">
                        +15 foto baru
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-gradient-to-br from-orange-50 to-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-400 text-white"
                >
                    <BookOpen class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-sm font-medium text-[var(--dark-green)]">
                        Booking Buku
                    </h2>
                    <div class="mt-0.5 text-3xl font-bold text-gray-800">8</div>
                    <p class="mt-1 text-xs text-orange-600">
                        Menunggu konfirmasi
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <h3
                class="rounded-xl bg-[var(--background-green)] p-2 text-lg font-bold text-[var(--dark-green)]"
            >
                Aksi Cepat
            </h3>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                <a
                    href="/admin/berita/create"
                    class="flex flex-col items-center justify-center rounded-xl bg-[var(--primary-green)] p-6 text-white shadow-sm transition hover:brightness-110"
                >
                    <Newspaper class="mb-2 h-7 w-7" />
                    <span class="text-sm font-medium">Buat Berita</span>
                </a>

                <a
                    href="/admin/pengumuman/create"
                    class="flex flex-col items-center justify-center rounded-xl bg-emerald-100 p-6 text-[var(--dark-green)] shadow-sm transition hover:bg-emerald-200"
                >
                    <Megaphone class="mb-2 h-7 w-7" />
                    <span class="text-sm font-medium">Buat Pengumuman</span>
                </a>

                <button
                    class="flex flex-col items-center justify-center rounded-xl bg-yellow-100 p-6 text-yellow-700 shadow-sm transition hover:bg-yellow-200"
                >
                    <Image class="mb-2 h-7 w-7" />
                    <span class="text-sm font-medium">Upload Foto</span>
                </button>

                <button
                    class="flex flex-col items-center justify-center rounded-xl bg-orange-100 p-6 text-orange-700 shadow-sm transition hover:bg-orange-200"
                >
                    <BookOpen class="mb-2 h-7 w-7" />
                    <span class="text-sm font-medium">Booking Buku</span>
                </button>

                <button
                    class="flex flex-col items-center justify-center rounded-xl bg-gray-100 p-6 text-gray-700 shadow-sm transition hover:bg-gray-200"
                >
                    <LibraryBig class="mb-2 h-7 w-7" />
                    <span class="text-sm font-medium">Usulan Buku</span>
                </button>
            </div>
        </div>

        <!-- Activity -->
        <h3
            class="mb-2 rounded-xl bg-[var(--background-green)] p-2 text-lg font-bold text-[var(--dark-green)]"
        >
            Aktivitas Terkini
        </h3>
        <div
            class="mb-5 rounded-xl border border-gray-100 bg-white/90 p-5 shadow-sm backdrop-blur-sm"
        >
            <div class="space-y-4">
                <div>
                    <div class="flex items-center gap-2 text-sm">
                        <span
                            class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs text-emerald-700"
                            >Berita</span
                        >
                        <span
                            class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-[var(--primary-green)]"
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
                            class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-[var(--primary-green)]"
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
    </div>
</template>

<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import {
    BookOpen,
    Image,
    LibraryBig,
    Megaphone,
    Newspaper,
} from 'lucide-vue-next';

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
