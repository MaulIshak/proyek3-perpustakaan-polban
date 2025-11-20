<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Youtube } from 'lucide-vue-next';

const quickLinks = [
    { name: 'Tentang', href: '/about' },
    { name: 'Fasilitas', href: '/facilities' },
    { name: 'e-Lib', href: '/e-lib' },
    { name: 'Repository', href: '/repository' },
    { name: 'Kontak', href: '/contact' },
];

const socialMedia = [
    { icon: Instagram, url: 'https://instagram.com/perpustakaanpolban' },
    { icon: Facebook, url: 'https://facebook.com/perpustakaanpolban' },
    { icon: Youtube, url: 'https://youtube.com/perpustakaanpolban' },
];
</script>

<template>
    <footer
        class="bg-[var(--background-green)] pt-12 pb-8 font-sans text-sm text-slate-600"
    >
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Grid Layout (Sesuai Gambar) -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-6">
                <!-- COL 1: LOGO & BRAND (Lebar: 2/12) -->
                <div class="flex flex-col items-start lg:col-span-2">
                    <div class="mb-4">
                        <img
                            src="/logo-polban.png"
                            alt="Logo Politeknik Negeri Bandung"
                            class="h-68 w-auto object-contain"
                        />
                    </div>
                </div>

                <!-- COL 2: JADWAL PELAYANAN (Lebar: 4/12) -->
                <div class="lg:col-span-4">
                    <h3 class="mb-4 text-base font-bold text-slate-900">
                        Jadwal Pelayanan
                    </h3>

                    <!-- Perpustakaan -->
                    <div
                        class="mb-3 border-b border-dashed border-slate-300 pb-3"
                    >
                        <h4 class="mb-1 font-bold text-slate-800">
                            Perpustakaan
                        </h4>
                        <p>Senin - Jumat : 08.00 - 16.00 WIB</p>
                        <p>Istirahat Jumat Tutup : 11.00 - 13.00 WIB</p>
                    </div>

                    <!-- Ruang Belajar -->
                    <div
                        class="mb-3 border-b border-dashed border-slate-300 pb-3"
                    >
                        <h4 class="mb-1 font-bold text-slate-800">
                            Ruang Belajar Mandiri
                        </h4>
                        <p>Senin - Jumat : 08.00 - 19.00 WIB</p>
                    </div>

                    <!-- Tutup -->
                    <div
                        class="mb-3 border-b border-dashed border-slate-300 pb-3"
                    >
                        <h4 class="mb-1 font-bold text-slate-800">Tutup</h4>
                        <p>
                            Tutup Hari Sabtu, Minggu, Libur Nasional, dan Cuti
                            Bersama
                        </p>
                    </div>

                    <!-- Note -->
                    <div class="pt-1">
                        <p class="text-xs text-slate-500 italic">
                            Libur semester ganjil dan genap tetap buka sesuai
                            jadwal
                        </p>
                    </div>
                </div>

                <!-- COL 3: LINK (Lebar: 1.5/12) -->
                <div class="lg:col-span-1">
                    <h3 class="mb-4 text-base font-bold text-slate-900">
                        Link
                    </h3>
                    <ul class="space-y-2">
                        <li v-for="link in quickLinks" :key="link.name">
                            <Link
                                :href="link.href"
                                class="inline-block text-slate-600 transition-all hover:translate-x-1 hover:text-[#99cc33]"
                            >
                                • {{ link.name }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- COL 4: FOLLOW US (Lebar: 1.5/12) -->
                <div class="lg:col-span-2">
                    <h3 class="mb-4 text-base font-bold text-slate-900">
                        Follow Us
                    </h3>
                    <div class="flex items-center gap-3">
                        <a
                            v-for="(social, idx) in socialMedia"
                            :key="idx"
                            :href="social.url"
                            target="_blank"
                            class="rounded-lg bg-slate-100 p-2 text-slate-600 transition-colors hover:bg-[#99cc33] hover:text-white"
                        >
                            <component :is="social.icon" class="h-6 w-6" />
                        </a>
                    </div>
                </div>

                <!-- COL 5: CONTACT (Lebar: 3/12) -->
                <div class="lg:col-span-3">
                    <h3 class="mb-4 text-base font-bold text-slate-900">
                        Contact
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <h4 class="font-bold text-slate-800">
                                Perpustakaan Politeknik Negeri Bandung
                            </h4>
                            <p>NPP 321702200000001</p>
                            <p>Gedung H Lantai 1</p>
                            <p class="mt-1 leading-relaxed">
                                Jln. Gegerkalong Hilir, Desa Ciwaruga, Kec.
                                Parongpong, Kab. Bandung Barat, Jawa Barat
                                Indonesia, Kode Pos 40559
                            </p>
                        </div>

                        <div
                            class="border-t border-dashed border-slate-300 pt-2"
                        >
                            <div class="flex justify-between">
                                <span>Telepon</span>
                                <span>: 022 - 2013789</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Fax</span>
                                <span>: 022 - 2013889</span>
                            </div>
                        </div>

                        <div
                            class="border-t border-dashed border-slate-300 pt-2"
                        >
                            <div class="flex gap-2">
                                <span>Email</span>
                                <span
                                    >:
                                    <a
                                        href="mailto:lib@polban.ac.id"
                                        class="text-[#99cc33] hover:underline"
                                        >lib@polban.ac.id</a
                                    ></span
                                >
                            </div>
                        </div>

                        <div
                            class="border-t border-dashed border-slate-300 pt-2"
                        >
                            <div class="flex gap-2">
                                <span>WhatsApp</span>
                                <span>: ......</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright Footer -->
            <div class="mt-12 border-t border-slate-200 pt-6 text-center">
                <p class="text-xs text-slate-500">
                    &copy; {{ new Date().getFullYear() }} Perpustakaan
                    Politeknik Negeri Bandung. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</template>
