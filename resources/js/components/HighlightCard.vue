<template>
    <section
        class="bg-gradient-to-br from-[var(--background-green)] to-white py-12"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                <div
                    class="rounded-xl border border-[var(--primary-green)] bg-card p-6 text-center text-card-foreground shadow transition-shadow hover:shadow-lg"
                >
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
                        class="lucide lucide-book-open mx-auto mb-3 h-12 w-12 text-[var(--primary-green)]"
                        aria-hidden="true"
                    >
                        <path d="M12 7v14"></path>
                        <path
                            d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"
                        ></path>
                    </svg>
                    <h3 class="text-3xl font-bold text-[var(--dark-green)]">
                        25,000+
                    </h3>
                    <p class="text-gray-600">Koleksi Buku</p>
                </div>
                <div
                    class="rounded-xl border border-[var(--primary-green)] bg-card p-6 text-center text-card-foreground shadow transition-shadow hover:shadow-lg"
                >
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
                        class="lucide lucide-users mx-auto mb-3 h-12 w-12 text-[var(--primary-green)]"
                        aria-hidden="true"
                    >
                        <path
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                        ></path>
                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                    <h3 class="text-3xl font-bold text-[var(--dark-green)]">
                        8,000+
                    </h3>
                    <p class="text-gray-600">Anggota Aktif</p>
                </div>
                <div
                    class="rounded-xl border border-[var(--primary-green)] bg-card p-6 text-center text-card-foreground shadow transition-shadow hover:shadow-lg"
                >
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
                        class="lucide lucide-library mx-auto mb-3 h-12 w-12 text-[var(--primary-green)]"
                        aria-hidden="true"
                    >
                        <path d="m16 6 4 14"></path>
                        <path d="M12 6v14"></path>
                        <path d="M8 8v12"></path>
                        <path d="M4 4v16"></path>
                    </svg>
                    <h3 class="text-3xl font-bold text-[var(--dark-green)]">
                        150
                    </h3>
                    <p class="text-gray-600">Kapasitas Ruang Baca</p>
                </div>
                <div
                    class="rounded-xl border border-[var(--primary-green)] bg-card p-6 text-center text-card-foreground shadow transition-shadow hover:shadow-lg"
                >
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
                        class="lucide lucide-calendar mx-auto mb-3 h-12 w-12 text-[var(--primary-green)]"
                        aria-hidden="true"
                    >
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                    <h3 class="text-3xl font-bold text-[var(--dark-green)]">
                        5 Hari
                    </h3>
                    <p class="text-gray-600">Layanan Seminggu</p>
                </div>
            </div>
        </div>
    </section>
</template>
