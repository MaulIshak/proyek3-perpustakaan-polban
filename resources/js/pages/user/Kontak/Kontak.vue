<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import {
    Clock,
    Facebook,
    Instagram,
    Mail,
    MapPin,
    MessageCircle,
    Phone,
    Youtube,
} from 'lucide-vue-next';

defineProps<{
    title: string;
    subjudul: string;
}>();

// --- Data Informasi Kontak ---
const kontak = {
    alamat: ' Perpustakaan Politeknik Negeri Bandung, Jl. Gegerkalong Hilir, Ciwaruga, Bandung Barat, Jawa Barat 40559',
    telepon: '(022) 2013788',
    email: 'lib@polban.ac.id',
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
        hover: 'hover:bg-emerald-100',
    },
    {
        name: 'Instagram',
        icon: Instagram,
        url: 'https://instagram.com/perpustakaanpolban',
        color: 'text-pink-600',
        bg: 'bg-pink-50',
        hover: 'hover:bg-pink-100',
    },
    {
        name: 'Facebook',
        icon: Facebook,
        url: 'https://facebook.com/perpustakaanpolban',
        color: 'text-blue-600',
        bg: 'bg-blue-50',
        hover: 'hover:bg-blue-100',
    },
    {
        name: 'YouTube',
        icon: Youtube,
        url: 'https://youtube.com/perpustakaanpolban',
        color: 'text-red-600',
        bg: 'bg-red-50',
        hover: 'hover:bg-red-100',
    },
];

const breadcrumb = [{ label: 'Home', link: '/' }, { label: 'Kontak' }];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <!-- Background decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div
            class="relative container mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8"
        >
            <!-- Header Section -->
            <!-- <div class="mb-10 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    {{ title }}
                </h1>
                <div class="flex justify-center mt-4">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Kolom Kiri: Informasi Kontak & Sosmed -->
                <div class="space-y-8">
                    <!-- Kartu Informasi -->
                    <div
                        class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/60"
                    >
                        <!-- Decorative Line -->
                        <div
                            class="absolute top-0 left-0 h-1.5 w-full bg-[#99cc33]"
                        ></div>

                        <h3 class="mb-6 text-2xl font-bold text-slate-800">
                            Hubungi Kami
                        </h3>

                        <div class="space-y-6">
                            <!-- Alamat -->
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]"
                                >
                                    <MapPin class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="mb-1 font-bold text-slate-800">
                                        Alamat
                                    </h4>
                                    <p
                                        class="text-sm leading-relaxed text-slate-600"
                                    >
                                        {{ kontak.alamat }}
                                    </p>
                                </div>
                            </div>

                            <!-- Telepon & Email -->
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]"
                                >
                                    <Phone class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="mb-1 font-bold text-slate-800">
                                        Telepon
                                    </h4>
                                    <p
                                        class="text-sm font-medium text-slate-600"
                                    >
                                        {{ kontak.telepon }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]"
                                >
                                    <Mail class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="mb-1 font-bold text-slate-800">
                                        Email
                                    </h4>
                                    <a
                                        :href="'mailto:' + kontak.email"
                                        class="text-sm font-medium text-[#99cc33] underline decoration-dotted underline-offset-4 transition-colors hover:text-[#88b82d]"
                                    >
                                        {{ kontak.email }}
                                    </a>
                                </div>
                            </div>

                            <!-- Jam Operasional -->
                            <div
                                class="flex items-start gap-4 border-t border-slate-100 pt-4"
                            >
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500"
                                >
                                    <Clock class="h-6 w-6" />
                                </div>
                                <div>
                                    <h4 class="mb-1 font-bold text-slate-800">
                                        Jam Operasional
                                    </h4>
                                    <div
                                        class="space-y-1 text-sm text-slate-600"
                                    >
                                        <div class="flex justify-between gap-8">
                                            <span>Senin - Jumat</span>
                                            <span
                                                class="font-semibold text-slate-800"
                                                >{{
                                                    kontak.jamOperasional
                                                        .seninJumat
                                                }}</span
                                            >
                                        </div>
                                        <div class="flex justify-between gap-8">
                                            <span>Sabtu</span>
                                            <span
                                                class="font-semibold text-slate-800"
                                                >{{
                                                    kontak.jamOperasional.sabtu
                                                }}</span
                                            >
                                        </div>
                                        <div
                                            class="mt-1 flex justify-between gap-8 text-xs font-medium text-red-500"
                                        >
                                            <span>Minggu / Libur</span>
                                            <span>Tutup</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Social Media -->
                    <div
                        class="rounded-3xl border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50"
                    >
                        <h3 class="mb-4 text-lg font-bold text-slate-800">
                            Ikuti Media Sosial Kami
                        </h3>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <a
                                v-for="social in socialMedia"
                                :key="social.name"
                                :href="social.url"
                                target="_blank"
                                class="group flex flex-col items-center justify-center gap-2 rounded-2xl border border-transparent p-4 transition-all duration-300 hover:shadow-md"
                                :class="[social.bg, social.hover]"
                            >
                                <component
                                    :is="social.icon"
                                    class="h-8 w-8 transition-transform group-hover:scale-110"
                                    :class="social.color"
                                />
                                <span
                                    class="text-xs font-semibold text-slate-600 group-hover:text-slate-900"
                                    >{{ social.name }}</span
                                >
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Peta -->
                <div class="h-full min-h-[400px] lg:min-h-auto">
                    <div
                        class="relative h-full w-full overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"
                    >
                        <div
                            class="absolute top-4 left-4 z-10 rounded-xl border border-slate-200 bg-white/90 px-4 py-2 shadow-sm backdrop-blur-sm"
                        >
                            <h4
                                class="flex items-center gap-2 text-sm font-bold text-slate-800"
                            >
                                <MapPin class="h-4 w-4 text-[#99cc33]" />
                                Lokasi Kampus
                            </h4>
                        </div>

                        <!-- Map Iframe cleaned up (Removed spam links and inline CSS) -->
                        <iframe
                            title="Lokasi Perpustakaan Polban"
                            class="h-full w-full border-0 grayscale-[20%] transition-all duration-700 hover:grayscale-0"
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
