<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import {
    MapPin,
    Phone,
    Mail,
    Clock,
    Facebook,
    Instagram,
    Youtube,
    MessageCircle
} from 'lucide-vue-next';

defineProps<{
    title: string;
    subjudul: string;
}>();

// --- Data Informasi Kontak ---
const kontak = {
    alamat: 'UPT Perpustakaan Politeknik Negeri Bandung, Jl. Gegerkalong Hilir, Ciwaruga, Bandung Barat, Jawa Barat 40559',
    telepon: '(022) 2013788',
    email: 'perpustakaan@polban.ac.id',
    jamOperasional: {
        seninJumat: '08:00 - 18:00 WIB',
        sabtu: '08:00 - 12:00 WIB',
    },
};

// --- Data Media Sosial ---
const socialMedia = [
    {
        name: 'WhatsApp',
        icon: MessageCircle,
        url: 'https://wa.me/6281234567890', // Ganti dengan nomor WA asli
        color: 'text-emerald-600',
        bg: 'bg-emerald-50',
        hover: 'hover:bg-emerald-100'
    },
    {
        name: 'Instagram',
        icon: Instagram,
        url: 'https://instagram.com/perpustakaanpolban',
        color: 'text-pink-600',
        bg: 'bg-pink-50',
        hover: 'hover:bg-pink-100'
    },
    {
        name: 'Facebook',
        icon: Facebook,
        url: 'https://facebook.com/perpustakaanpolban',
        color: 'text-blue-600',
        bg: 'bg-blue-50',
        hover: 'hover:bg-blue-100'
    },
    {
        name: 'YouTube',
        icon: Youtube,
        url: 'https://youtube.com/perpustakaanpolban',
        color: 'text-red-600',
        bg: 'bg-red-50',
        hover: 'hover:bg-red-100'
    }
];

const breadcrumb = [{ label: 'Profil' }, { label: 'Kontak' }];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <!-- Background decoration (Consistent Theme) -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 relative">

            <!-- Header Section -->
            <!-- <div class="mb-10 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    {{ title }}
                </h1>
                <div class="flex justify-center mt-4">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Kolom Kiri: Informasi Kontak & Sosmed -->
                <div class="space-y-8">
                    <!-- Kartu Informasi -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 overflow-hidden relative group">
                        <!-- Decorative Line -->
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-[#99cc33]"></div>

                        <h3 class="text-2xl font-bold text-slate-800 mb-6">Hubungi Kami</h3>

                        <div class="space-y-6">
                            <!-- Alamat -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                    <MapPin class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Alamat</h4>
                                    <p class="text-slate-600 leading-relaxed text-sm">{{ kontak.alamat }}</p>
                                </div>
                            </div>

                            <!-- Telepon & Email -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                    <Phone class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Telepon</h4>
                                    <p class="text-slate-600 text-sm font-medium">{{ kontak.telepon }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                    <Mail class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Email</h4>
                                    <a :href="'mailto:' + kontak.email" class="text-[#99cc33] hover:text-[#88b82d] font-medium text-sm underline decoration-dotted underline-offset-4 transition-colors">
                                        {{ kontak.email }}
                                    </a>
                                </div>
                            </div>

                            <!-- Jam Operasional -->
                            <div class="flex items-start gap-4 pt-4 border-t border-slate-100">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                    <Clock class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Jam Operasional</h4>
                                    <div class="space-y-1 text-sm text-slate-600">
                                        <div class="flex justify-between gap-8">
                                            <span>Senin - Jumat</span>
                                            <span class="font-semibold text-slate-800">{{ kontak.jamOperasional.seninJumat }}</span>
                                        </div>
                                        <div class="flex justify-between gap-8">
                                            <span>Sabtu</span>
                                            <span class="font-semibold text-slate-800">{{ kontak.jamOperasional.sabtu }}</span>
                                        </div>
                                        <div class="flex justify-between gap-8 text-red-500 text-xs mt-1 font-medium">
                                            <span>Minggu / Libur</span>
                                            <span>Tutup</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Social Media -->
                    <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Ikuti Media Sosial Kami</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <a
                                v-for="social in socialMedia"
                                :key="social.name"
                                :href="social.url"
                                target="_blank"
                                class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl transition-all duration-300 border border-transparent hover:shadow-md group"
                                :class="[social.bg, social.hover]"
                            >
                                <component :is="social.icon" class="w-8 h-8 transition-transform group-hover:scale-110" :class="social.color" />
                                <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-900">{{ social.name }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Peta -->
                <div class="h-full min-h-[400px] lg:min-h-auto">
                    <div class="w-full h-full bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden relative">
                        <div class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-sm border border-slate-200">
                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <MapPin class="w-4 h-4 text-[#99cc33]" />
                                Lokasi Kampus
                            </h4>
                        </div>

                        <!-- Map Iframe cleaned up (Removed spam links and inline CSS) -->
                        <iframe
                            title="Lokasi Perpustakaan Polban"
                            class="w-full h-full border-0 grayscale-[20%] hover:grayscale-0 transition-all duration-700"
                            src="https://maps.google.com/maps?width=100%&height=100%&hl=en&q=Politeknik%20Negeri%20Bandung&t=&z=15&ie=UTF8&iwloc=B&output=embed"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>

            </div>
        </div>
    </UserAppLayout>
</template>
