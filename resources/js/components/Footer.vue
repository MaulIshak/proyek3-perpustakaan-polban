<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const quickLinks = [
    { name: 'Tentang Perpustakaan', href: '/about' },
    { name: 'Fasilitas', href: '/facilities' },
    { name: 'e-Lib POLBAN', href: '/e-lib' },
    { name: 'Repository POLBAN', href: '/repository' },
    { name: 'Kontak', href: '/contact' },
];
</script>

<template>
    <footer class="bg-[var(--background-green)] text-[var(--dark-green)]">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- About -->
                <div>
                    <h2 class="mb-2 text-lg font-bold">
                        PERPUSTAKAAN POLITEKNIK NEGERI BANDUNG
                    </h2>
                    <p class="mb-4 text-sm">NPP: 321702200000001</p>
                    <p class="mb-2 text-sm">
                        Pusat informasi dan layanan perpustakaan untuk mendukung
                        kegiatan akademik Politeknik Negeri Bandung.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h2 class="mb-4 text-xl font-semibold">Link</h2>
                    <ul class="space-y-2">
                        <li v-for="link in quickLinks" :key="link.name">
                            <Link
                                :href="link.href"
                                class="text-sm hover:text-green-300"
                            >
                                {{ link.name }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h2 class="mb-4 text-xl font-semibold">Hubungi Kami</h2>
                    <div class="space-y-2 text-sm">
                        <p>Jl. Gegerkalong Hilir, Ciwaruga</p>
                        <p>Bandung Barat, Jawa Barat 40559</p>
                        <p>perpustakaan@polban.ac.id</p>
                    </div>
                </div>
            </div>

            <div
                class="mt-8 border-t border-[var(--primary-green)] pt-8 text-center text-sm"
            >
                <p>
                    © 2025 UPT Perpustakaan Politeknik Negeri Bandung. All
                    rights reserved.
                </p>
            </div>
        </div>
    </footer>
</template>
