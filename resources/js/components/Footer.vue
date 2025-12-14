<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Youtube, MapPin, Phone, Mail, Printer } from 'lucide-vue-next';

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
    <footer class="bg-[var(--background-green)] pt-12 pb-8 sm:pt-16 sm:pb-10 font-sans text-slate-600 border-t border-slate-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-12 lg:gap-8">

                <div class="lg:col-span-4">
                    <h3 class="mb-5 sm:mb-6 text-lg font-extrabold tracking-tight text-slate-900 border-l-4 border-[#99cc33] pl-3">
                        Jadwal Pelayanan
                    </h3>

                    <div class="flex flex-col gap-5 sm:gap-6">
                        <div class="bg-white/50 p-4 rounded-xl border border-slate-100 sm:bg-transparent sm:p-0 sm:border-0">
                            <h4 class="mb-1 font-bold text-slate-800 text-sm uppercase tracking-wide">Perpustakaan</h4>
                            <div class="text-sm sm:text-base space-y-1 text-slate-600">
                                <p>Senin - Jumat : 08.00 - 16.00 WIB</p>
                                <p class="text-slate-500 text-xs sm:text-sm italic">
                                    (Istirahat Jumat: 11.00 - 13.00 WIB)
                                </p>
                            </div>
                        </div>

                        <div class="bg-white/50 p-4 rounded-xl border border-slate-100 sm:bg-transparent sm:p-0 sm:border-0">
                            <h4 class="mb-1 font-bold text-slate-800 text-sm uppercase tracking-wide">Ruang Belajar Mandiri</h4>
                            <p class="text-sm sm:text-base">Senin - Jumat : 08.00 - 19.00 WIB</p>
                        </div>

                        <div>
                            <h4 class="mb-1 font-bold text-slate-800 text-sm uppercase tracking-wide">Tutup</h4>
                            <p class="text-sm sm:text-base leading-relaxed text-slate-500">
                                Sabtu, Minggu, Libur Nasional, & Cuti Bersama.
                                <br />
                                <span class="text-[#99cc33] font-medium block mt-1">
                                    *Libur semester tetap buka sesuai jadwal.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h3 class="mb-5 sm:mb-6 text-lg font-extrabold tracking-tight text-slate-900 border-l-4 border-[#99cc33] pl-3">
                        Tautan Singkat
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="link in quickLinks" :key="link.name">
                            <Link
                                :href="link.href"
                                class="group flex items-center gap-3 text-sm sm:text-base text-slate-600 transition-all hover:text-[#99cc33] hover:translate-x-1"
                            >
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-300 transition-colors group-hover:bg-[#99cc33] ring-2 ring-transparent group-hover:ring-[#99cc33]/20"></span>
                                {{ link.name }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-2 lg:col-span-5">
                    <h3 class="mb-5 sm:mb-6 text-lg font-extrabold tracking-tight text-slate-900 border-l-4 border-[#99cc33] pl-3">
                        Hubungi Kami
                    </h3>

                    <div class="space-y-6 bg-white/60 p-5 rounded-2xl border border-white sm:bg-transparent sm:p-0 sm:border-0">
                        <div class="flex gap-4">
                            <div class="shrink-0 mt-1 text-[#99cc33]">
                                <MapPin class="w-5 h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 leading-snug">
                                    Perpustakaan Politeknik Negeri Bandung
                                </h4>
                                <span class="font-mono text-slate-400 block mb-1">NPP 321702200000001</span>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Gedung H, Lantai 1, Jl. Gegerkalong Hilir, Ds. Ciwaruga, Bandung Barat, Jawa Barat 40559
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4 group">
                                <div class="shrink-0 text-slate-400 group-hover:text-[#99cc33] transition-colors">
                                    <Phone class="w-5 h-5" />
                                </div>
                                <span class="text-sm font-medium text-slate-600">022 - 2013789</span>
                            </div>

                            <div class="flex items-center gap-4 group">
                                <div class="shrink-0 text-slate-400 group-hover:text-[#99cc33] transition-colors">
                                    <Printer class="w-5 h-5" />
                                </div>
                                <span class="text-sm font-medium text-slate-600">022 - 2013889</span>
                            </div>

                            <div class="flex items-center gap-4 group">
                                <div class="shrink-0 text-slate-400 group-hover:text-[#99cc33] transition-colors">
                                    <Mail class="w-5 h-5" />
                                </div>
                                <a href="mailto:lib@polban.ac.id" class="text-sm font-bold text-[#99cc33] hover:underline hover:text-[#8ebf2f]">
                                    lib@polban.ac.id
                                </a>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200/50">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ikuti Kami</h4>
                            <div class="flex gap-3">
                                <a
                                    v-for="(social, idx) in socialMedia"
                                    :key="idx"
                                    :href="social.url"
                                    target="_blank"
                                    class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm border border-slate-100 transition-all hover:-translate-y-1 hover:bg-[#99cc33] hover:text-white hover:shadow-md hover:border-[#99cc33]"
                                >
                                    <component :is="social.icon" class="h-5 w-5" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 sm:mt-16 border-t border-slate-200 pt-8 text-center">
                <p class="text-xs sm:text-sm font-medium text-slate-500">
                    &copy; {{ new Date().getFullYear() }} Perpustakaan Politeknik Negeri Bandung.
                    <span class="block sm:inline mt-1 sm:mt-0 text-slate-400">All rights reserved.</span>
                </p>
            </div>
        </div>
    </footer>
</template>
