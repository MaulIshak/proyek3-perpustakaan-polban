<template>
    <div
        class="rounded-xl border bg-card p-6 text-card-foreground shadow transition-shadow hover:shadow-lg"
    >
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200"
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
                        class="lucide lucide-calendar h-8 w-8 text-emerald-600"
                        aria-hidden="true"
                    >
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm text-gray-500">2025-01-20</span>
                </div>
                <h3 class="mb-2 text-xl font-bold text-gray-800">
                    Libur Perpustakaan pada Hari Raya Imlek 2025
                </h3>
                <p class="mb-4 text-gray-600">
                    UPT Perpustakaan POLBAN akan tutup pada tanggal 29 Januari
                    2025 dalam rangka perayaan Imlek.
                </p>
                <a href="/pengumuman/1" data-discover="true"
                    ><button
                        class="[&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 inline-flex h-8 items-center justify-center gap-2 rounded-md border border-emerald-600 px-3 text-xs font-medium whitespace-nowrap text-emerald-600 shadow-sm transition-colors hover:bg-emerald-50 hover:text-accent-foreground focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                    >
                        Baca Selengkapnya
                    </button></a
                >
            </div>
        </div>
    </div>
</template>
