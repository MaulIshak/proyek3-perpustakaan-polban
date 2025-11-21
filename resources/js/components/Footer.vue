<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Youtube } from 'lucide-vue-next';

const quickLinks = [
    { name: 'Politeknik Negeri Bandung', href: 'https://www.polban.ac.id/' },
    { name: 'Digilib', href: 'https://digilib.polban.ac.id/' },
    { name: 'Elib', href: 'https://elib.polban.ac.id/' },
    { name: 'Repositori', href: '#' },
    { name: 'Bebas Masalah', href: '/bebas_masalah' },
    { name: 'Usulan Buku', href: '/usulan_buku' },
];

const socialMedia = [
    { icon: Instagram, url: 'https://instagram.com/perpustakaanpolban' },
    { icon: Facebook, url: 'https://facebook.com/perpustakaanpolban' },
    { icon: Youtube, url: 'https://youtube.com/@perpustakaanpolban' },
];
</script>

<template>
    <footer
        class="text-md bg-[var(--background-green)] pt-16 pb-10 font-sans text-slate-600"
    >
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between gap-5">
                <!-- COL 2: JADWAL PELAYANAN (Lebar: 4/12) -->
                <div class="lg:col-span-4">
                    <h3
                        class="mb-6 text-lg font-extrabold tracking-tight text-slate-900"
                    >
                        Jadwal Pelayanan
                    </h3>

                    <div class="flex flex-col gap-6">
                        <!-- Perpustakaan -->
                        <div>
                            <h4 class="mb-1 font-bold text-slate-800">
                                Perpustakaan
                            </h4>
                            <div class="space-y-1 text-slate-600">
                                <p>Senin - Jumat : 08.00 - 16.00 WIB</p>
                                <p class="text-slate-500">
                                    (Istirahat Jumat: 11.00 - 13.00 WIB)
                                </p>
                            </div>
                        </div>

                        <!-- Ruang Belajar -->
                        <div>
                            <h4 class="mb-1 font-bold text-slate-800">
                                Ruang Belajar Mandiri
                            </h4>
                            <p>Senin - Jumat : 08.00 - 19.00 WIB</p>
                        </div>

                        <!-- Tutup -->
                        <div>
                            <h4 class="mb-1 font-bold text-slate-800">Tutup</h4>
                            <p class="leading-relaxed text-slate-500">
                                Sabtu, Minggu, Libur Nasional, dan Cuti Bersama.
                                <br />
                                <span class="text-[#99cc33] italic"
                                    >*Libur semester tetap buka sesuai
                                    jadwal.</span
                                >
                            </p>
                        </div>
                    </div>
                </div>

                <!-- COL 3: LINK & SOCIAL (Lebar: 2/12) -->
                <div class="flex flex-col gap-8 lg:col-span-2">
                    <!-- Links -->
                    <div>
                        <h3
                            class="mb-6 text-lg font-extrabold tracking-tight text-slate-900"
                        >
                            Tautan Singkat
                        </h3>
                        <ul class="space-y-3">
                            <li v-for="link in quickLinks" :key="link.name">
                                <Link
                                    :href="link.href"
                                    class="group flex items-center gap-2 text-slate-600 transition-colors hover:text-[#99cc33]"
                                >
                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-slate-300 transition-colors group-hover:bg-[#99cc33]"
                                    ></span>
                                    {{ link.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Socials
                    <div>
                        <h3 class="mb-4 text-sm font-bold text-slate-900">
                            Ikuti Kami
                        </h3>
                        <div class="flex items-center gap-3">
                            <a
                                v-for="(social, idx) in socialMedia"
                                :key="idx"
                                :href="social.url"
                                target="_blank"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 shadow-sm ring-1 ring-slate-100 transition-all hover:-translate-y-1 hover:bg-[#99cc33] hover:text-white hover:shadow-md"
                            >
                                <component :is="social.icon" class="h-5 w-5" />
                            </a>
                        </div>
                    </div> -->
                </div>

                <!-- COL 4: CONTACT (Lebar: 3/12) -->
                <div class="lg:col-span-3">
                    <h3
                        class="mb-6 text-lg font-extrabold tracking-tight text-slate-900"
                    >
                        Hubungi Kami
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <h4 class="leading-snug font-bold text-slate-800">
                                Perpustakaan Politeknik Negeri Bandung
                            </h4>
                            <span class="text-slate-500"
                                >NPP 321702200000001</span
                            >
                            <p class="mt-2 leading-relaxed text-slate-500">
                                Gedung H, Lantai 1<br />
                                Jl. Gegerkalong Hilir, Ds. Ciwaruga<br />
                                Bandung Barat, Jawa Barat 40559
                            </p>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-16 shrink-0 font-medium text-slate-400"
                                    >Telepon</span
                                >
                                <div class="flex flex-col">
                                    <span>022 - 2013789</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-16 shrink-0 font-medium text-slate-400"
                                    >Fax</span
                                >
                                <div class="flex flex-col">
                                    <span>022 - 2013889</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <span
                                    class="w-16 shrink-0 font-medium text-slate-400"
                                    >Email</span
                                >
                                <div class="flex flex-col">
                                    <a
                                        href="mailto:lib@polban.ac.id"
                                        class="text-[#99cc33] hover:underline"
                                        >lib@polban.ac.id</a
                                    >
                                </div>
                            </div>
                            <!-- Socials -->
                            <div>
                                <h3
                                    class="mb-4 text-sm font-bold text-slate-900"
                                >
                                    Ikuti Kami
                                </h3>
                                <div class="flex items-center gap-3">
                                    <a
                                        v-for="(social, idx) in socialMedia"
                                        :key="idx"
                                        :href="social.url"
                                        target="_blank"
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-600 shadow-sm ring-1 ring-slate-100 transition-all hover:-translate-y-1 hover:bg-[#99cc33] hover:text-white hover:shadow-md"
                                    >
                                        <component
                                            :is="social.icon"
                                            class="h-5 w-5"
                                        />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright Footer -->
            <div
                class="mt-16 border-t border-slate-200/60 pt-8 text-center text-sm"
            >
                <p class="font-medium text-slate-500">
                    &copy; {{ new Date().getFullYear() }} Perpustakaan
                    Politeknik Negeri Bandung.
                    <span class="hidden sm:inline"
                        >Designed & Developed with precision.</span
                    >
                </p>
            </div>
        </div>
    </footer>
</template>
