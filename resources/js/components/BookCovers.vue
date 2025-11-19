<script setup lang="ts">
import BookCoverLink from './BookCoverLink.vue';
const books = [
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300',
    },
];
</script>

<template>
    <section class="py-12">
        <div class="mx-auto">
            <!-- Title -->
            <div class="mb-8 flex items-center justify-between">
                <div class="inline-block">
                    <h2
                        class="relative text-3xl font-bold text-[var(--dark-green)]"
                    >
                        Koleksi Buku Terbaru
                    </h2>
                    <span
                        class="mt-1 block h-1 w-16 rounded-full bg-[var(--primary-green)]"
                    ></span>
                </div>

                <a
                    href="/koleksi/elib"
                    data-discover="true"
                    class="flex items-center gap-1 rounded-3xl bg-[var(--primary-green)] px-4 py-2 text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                >
                    Lihat Katalog
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="lucide lucide-arrow-right h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Cover Buku (Centered) -->
            <div class="mt-8 grid place-items-stretch">
                <div class="flex justify-evenly gap-4 pb-4">
                    <BookCoverLink
                        v-for="(book, index) in books"
                        :key="index"
                        :href="book.href"
                        :src="book.src"
                    />
                </div>
            </div>
            <section
                class="mt-10 w-full rounded-3xl bg-[var(--primary-green)] bg-gradient-to-b from-[var(--primary-green)] to-[#0b7e5e] py-10 text-center text-white"
            >
                <div class="mx-auto max-w-3xl px-4">
                    <!-- Judul -->
                    <h2 class="text-3xl font-bold md:text-4xl">
                        Usulkan atau Booking Buku
                    </h2>

                    <!-- Subjudul -->
                    <p class="mt-4 text-base opacity-90 md:text-lg">
                        Usulkan buku atau booking buku yang tersedia di katalog
                        online!
                    </p>

                    <!-- Tombol Aksi -->
                    <div
                        class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-6"
                    >
                        <!-- Tombol 1 -->
                        <a
                            href="#"
                            class="flex items-center gap-2 rounded-xl bg-white px-6 py-3 font-semibold text-[var(--primary-green)] shadow transition duration-300 hover:bg-gray-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>
                            Booking Buku
                        </a>

                        <!-- Tombol 2 -->
                        <a
                            href="#"
                            class="flex items-center gap-2 rounded-xl border border-white px-6 py-3 font-semibold text-white transition duration-300 hover:bg-white hover:text-[var(--primary-green)]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 4h18v2H3zM6 8h12v12H6z"
                                />
                            </svg>
                            Usulkan Buku
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </section>
</template>

<style scoped>
/* ===== Auto Scroll Animation ===== */

.animate-scroll {
    display: flex;
    animation: scroll-horizontal 30s linear infinite;
}

/* ===== Custom Scrollbar (Themed) ===== */
.scroll-container::-webkit-scrollbar {
    height: 8px;
}

.scroll-container::-webkit-scrollbar-track {
    background: var(--background-green);
    border-radius: 10px;
}

.scroll-container::-webkit-scrollbar-thumb {
    background: var(--primary-green);
    border-radius: 10px;
    transition: background 0.3s ease;
}

.scroll-container::-webkit-scrollbar-thumb:hover {
    background: var(--dark-green);
}

/* Untuk Firefox */
.scroll-container {
    scrollbar-color: var(--primary-green) var(--background-green);
    scrollbar-width: thin;
}
</style>
