<script setup>
import { ArrowLeft, ArrowRight } from 'lucide-vue-next';
import { ref } from 'vue';
import BookCoverLink from './BookCoverLink.vue';

const scrollContainer = ref(null);

const scrollLeft = () => {
    scrollContainer.value.scrollBy({
        left: -300,
        behavior: 'smooth',
    });
};

const scrollRight = () => {
    scrollContainer.value.scrollBy({
        left: 300,
        behavior: 'smooth',
    });
};
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
        src: 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=300',
    },
    {
        href: '#',
        src: 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=300',
    },
];
</script>

<template>
    <section
        class="bg-gradient-to-b from-white to-[var(--background-green)] py-16"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
                    class="flex w-35 items-center justify-evenly gap-1 rounded-3xl border border-transparent bg-[var(--primary-green)] p-2 text-center text-sm font-medium text-[var(--dark-green)] transition-all duration-300 hover:border-[var(--primary-green)] hover:bg-white hover:text-[var(--primary-green)]"
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
            <div class="group relative">
                <!-- Tombol panah kiri -->
                <button
                    @click="scrollLeft"
                    class="absolute top-1/2 left-0 z-10 -translate-y-1/2 rounded-full bg-white p-2 opacity-0 shadow-md transition-opacity duration-300 group-hover:opacity-100 hover:bg-[var(--primary-green)] hover:text-white"
                >
                    <ArrowLeft class="h-5 w-5" />
                </button>

                <!-- Scroll Container -->
                <div
                    ref="scrollContainer"
                    class="scroll-container relative overflow-x-hidden scroll-smooth px-8"
                >
                    <div class="flex gap-4 pb-4">
                        <BookCoverLink
                            v-for="(book, index) in books
                                .concat(books)
                                .concat(books)"
                            :key="index"
                            :href="book.href"
                            :src="book.src"
                        />
                    </div>
                </div>

                <!-- Tombol panah kanan -->
                <button
                    @click="scrollRight"
                    class="absolute top-1/2 right-0 z-10 -translate-y-1/2 rounded-full bg-white p-2 opacity-0 shadow-md transition-opacity duration-300 group-hover:opacity-100 hover:bg-[var(--primary-green)] hover:text-white"
                >
                    <ArrowRight class="h-5 w-5" />
                </button>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* ===== Auto Scroll Animation ===== */
@keyframes scroll-horizontal {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

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
