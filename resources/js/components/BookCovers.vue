<script setup lang="ts">
import { ArrowRight, BookPlus, CalendarCheck } from 'lucide-vue-next';

// Data Buku Dummy
const books = [
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=300&q=80',
        title: 'Principles of Science',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=300&q=80',
        title: 'Modern Architecture',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300&q=80',
        title: 'The Art of Design',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=300&q=80',
        title: 'Advanced Mathematics',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=300&q=80',
        title: 'Programming 101',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=300&q=80',
        title: 'History of World',
    },
];
</script>

<template>
    <section class="w-full py-6">
        <div class="mx-auto max-w-7xl">
            <!-- 1. Header Section (Konsisten) -->
            <div
                class="mb-10 flex flex-col justify-between gap-4 md:flex-row md:items-end"
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

            <!-- 2. Horizontal Scroll Container -->
            <!-- pb-10 added to prevent shadow clipping -->
            <div class="relative -mx-4 px-4 sm:mx-0 sm:px-0">
                <div
                    class="scrollbar-hide flex snap-x snap-mandatory gap-6 overflow-x-auto px-2 pt-2 pb-10"
                >
                    <a
                        v-for="(book, index) in books"
                        :key="index"
                        :href="book.href"
                        class="group relative w-[160px] flex-shrink-0 cursor-pointer snap-center sm:w-[180px]"
                    >
                        <!-- Book Cover -->
                        <div
                            class="relative aspect-[2/3] overflow-hidden rounded-xl bg-slate-200 shadow-lg shadow-slate-300/60 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-[#99cc33]/30"
                        >
                            <img
                                :src="book.src"
                                :alt="book.title"
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

                        <!-- Title (Optional, if you want text below) -->
                        <!-- <p class="mt-4 text-center text-sm font-bold text-slate-700 group-hover:text-[#99cc33] transition-colors line-clamp-2 px-2">
                            {{ book.title }}
                        </p> -->
                    </a>

                    <!-- Spacer for right padding scroll -->
                    <div class="w-2 flex-shrink-0"></div>
                </div>
            </div>

            <!-- 3. CTA Section (Usulkan / Booking) -->
            <div
                class="relative mt-8 w-full overflow-hidden rounded-[2.5rem] bg-[#99cc33] shadow-xl shadow-[#99cc33]/20"
            >
                <!-- Background Pattern (Blobs) -->
                <div
                    class="pointer-events-none absolute top-0 right-0 h-64 w-64 translate-x-1/2 -translate-y-1/2 rounded-full bg-white/10 blur-3xl"
                ></div>
                <div
                    class="pointer-events-none absolute bottom-0 left-0 h-64 w-64 -translate-x-1/2 translate-y-1/2 rounded-full bg-black/5 blur-3xl"
                ></div>

                <div
                    class="relative z-10 px-6 py-12 text-center sm:px-12 md:py-16"
                >
                    <h2
                        class="mb-4 text-3xl font-extrabold tracking-tight text-white drop-shadow-sm md:text-4xl"
                    >
                        Usulkan atau Booking Buku
                    </h2>
                    <p
                        class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed text-white/90"
                    >
                        Tidak menemukan buku yang dicari? Usulkan pengadaan buku
                        baru atau booking buku yang tersedia agar tidak
                        kehabisan.
                    </p>

                    <div
                        class="flex flex-col items-center justify-center gap-4 sm:flex-row"
                    >
                        <!-- Tombol Booking -->
                        <a
                            href="/book-reservation"
                            class="flex items-center gap-2 rounded-xl bg-white px-8 py-3.5 text-sm font-bold text-[#99cc33] shadow-lg shadow-black/5 transition-all duration-300 hover:scale-105 hover:bg-slate-50"
                        >
                            <CalendarCheck class="h-5 w-5" />
                            Booking Buku
                        </a>

                        <!-- Tombol Usulkan -->
                        <a
                            href="/usulan_buku"
                            class="flex items-center gap-2 rounded-xl border border-white/30 bg-[#88b82d] px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-black/5 transition-all duration-300 hover:bg-[#7da929]"
                        >
                            <BookPlus class="h-5 w-5" />
                            Usulkan Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Hide Scrollbar but allow scrolling */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
