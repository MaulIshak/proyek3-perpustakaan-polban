<script setup lang="ts">
import { ArrowRight, BookPlus, CalendarCheck } from 'lucide-vue-next';

const props = defineProps({
    data: {
        type: Array<{
            id: Number;
            image_path: string;
        }>,
        default: [],
    },
});
</script>

<template>
    <section class="w-full py-8">
        <div class="mx-auto max-w-7xl">
            <!-- 1. Header Section -->
            <div
                class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end"
            >
                <div>
                    <div class="mb-2 flex items-center gap-3">
                        <div
                            class="rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                        >
                            <BookPlus class="h-6 w-6" />
                        </div>
                        <h2
                            class="text-3xl font-black tracking-tight text-slate-900"
                        >
                            Koleksi Buku Terbaru
                        </h2>
                    </div>
                    <div
                        class="ml-1 h-1.5 w-24 rounded-full bg-[#99cc33] shadow-sm shadow-[#99cc33]/50"
                    ></div>
                </div>

                <a
                    href="https://elib.polban.ac.id"
                    target="_blank"
                    class="group flex items-center gap-2 rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:border-[#99cc33] hover:text-[#99cc33] hover:shadow-md"
                >
                    Lihat Katalog Digital
                    <ArrowRight
                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                    />
                </a>
            </div>

            <!-- 2. Grid Container (PERBAIKAN UTAMA) -->
            <!-- Mengganti horizontal scroll dengan CSS Grid -->
            <!-- Mobile: 2 kolom, Tablet: 3 kolom, Desktop: 6 kolom -->
            <div
                class="grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-6"
            >
                <a
                    v-for="(book, index) in data"
                    :key="index"
                    :href="`/storage/${book.image_path}`"
                    class="group relative flex w-full cursor-pointer flex-col"
                >
                    <!-- Book Cover -->
                    <!-- Aspect Ratio 2/3 (Standar Buku) -->
                    <div
                        class="relative aspect-[2/3] w-full overflow-hidden rounded-xl bg-slate-200 shadow-lg shadow-slate-300/60 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-[#99cc33]/30"
                    >
                        <img
                            :src="`/storage/${book.image_path}`"
                            :alt="'cover buku' + book.id"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy"
                        />
                        <!-- Overlay on Hover -->
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        >
                            <div
                                class="rounded-full bg-white/20 p-2 backdrop-blur-md"
                            >
                                <ArrowRight class="h-6 w-6 text-white" />
                            </div>
                        </div>
                    </div>

                    <!-- Judul Buku (Opsional: Agar user tahu judul tanpa hover) -->
                    <!-- <div class="mt-3 text-center">
                        <h3 class="text-sm font-bold text-slate-700 line-clamp-1 group-hover:text-[#99cc33] transition-colors">{{ book.title }}</h3>
                    </div> -->
                </a>
            </div>

            <!-- 3. CTA Section (Fixed & Improved Style) -->
            <div
                class="relative mx-auto mt-8 w-full max-w-7xl overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#99cc33] to-[#7da929] shadow-2xl shadow-[#99cc33]/30"
            >
                <!-- Decorative Blobs (Untuk efek modern) -->
                <div
                    class="pointer-events-none absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/20 blur-3xl"
                ></div>
                <div
                    class="pointer-events-none absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-black/10 blur-3xl"
                ></div>

                <!-- Content -->
                <div
                    class="relative z-10 px-6 py-12 text-center sm:px-12 md:py-16"
                >
                    <h2
                        class="mb-4 text-3xl font-black tracking-tight text-white drop-shadow-sm md:text-4xl"
                    >
                        Usulkan atau Booking Buku
                    </h2>

                    <p
                        class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed font-medium text-white/90"
                    >
                        Tidak menemukan buku yang dicari? Usulkan pengadaan buku
                        baru atau booking buku yang tersedia agar tidak
                        kehabisan.
                    </p>

                    <div
                        class="flex flex-col items-center justify-center gap-4 sm:flex-row"
                    >
                        <!-- Tombol Booking (Primary White) -->
                        <a
                            href="/book-reservation"
                            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-white px-8 py-4 text-sm font-bold text-[#99cc33] shadow-lg shadow-black/10 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl sm:w-auto"
                        >
                            <CalendarCheck
                                class="h-5 w-5 transition-transform group-hover:scale-110"
                            />
                            Booking Buku
                        </a>

                        <!-- Tombol Usulkan (Secondary Glass/Darker) -->
                        <a
                            href="/usulan_buku"
                            class="group flex w-full items-center justify-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-8 py-4 text-sm font-bold text-white backdrop-blur-sm transition-all duration-300 hover:border-white/50 hover:bg-white/20 sm:w-auto"
                        >
                            <BookPlus
                                class="h-5 w-5 transition-transform group-hover:scale-110"
                            />
                            Usulkan Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
