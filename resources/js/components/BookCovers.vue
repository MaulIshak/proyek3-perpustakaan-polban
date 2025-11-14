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
    <section class="py-16">
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
                    class="flex w-35 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                    href="/koleksi/elib"
                    data-discover="true"
                >
                    Lihat Katalog
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-arrow-right h-5 w-5"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <!-- Scroll Container -->
            <div class="relative overflow-x-auto">
                <div class="flex gap-4 pb-4">
                    <BookCoverLink
                        v-for="(book, index) in books"
                        :key="index"
                        :href="book.href"
                        :src="book.src"
                    />
                    <!-- Usulkan Buku -->
                    <a
                        href="#"
                        class="flex h-[220px] w-[150px] flex-col items-center justify-center rounded-3xl border bg-[var(--primary-green)] p-4 text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mb-2 h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        <span class="text-lg font-semibold">Usulkan Buku</span>
                        <p class="text-center text-xs opacity-80">
                            Ajukan judul baru ke perpustakaan
                        </p>
                    </a>

                    <!-- Booking Buku -->
                    <a
                        href="#"
                        class="flex h-[220px] w-[150px] flex-col items-center justify-center rounded-3xl border bg-[var(--primary-green)] p-4 text-white transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mb-2 h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M3 4h18v2H3zM6 8h12v12H6z" />
                        </svg>
                        <span class="text-lg font-semibold">Booking Buku</span>
                        <p class="text-center text-xs opacity-80">
                            Pesan buku sebelum dipinjam
                        </p>
                    </a>
                </div>
            </div>
            <!-- Action Buttons -->
            <div
                class="mx-auto mt-6 grid max-w-md grid-cols-2 gap-4 text-center"
            ></div>
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
