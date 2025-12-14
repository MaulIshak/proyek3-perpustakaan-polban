<script setup lang="ts">
import ScrollReveal from '@/components/ScrollReveal.vue';
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
    ExternalLink
} from 'lucide-vue-next';

defineProps<{
    title: string;
    subjudul: string;
}>();

// --- Data Informasi Kontak ---
const kontak = {
    alamat: 'Gedung H, Lantai 1, Jl. Gegerkalong Hilir, Ds. Ciwaruga Bandung Barat, Jawa Barat 40559',
    telepon: '(022) 2013788',
    fax: '(022) 2013789',
    email: 'lib@polban.ac.id',
    jamOperasional: {
        seninJumat: '08:00 - 16:00 WIB',
        istirahatJumat: '12:00 - 13:00 WIB',
    },
};

// --- Data Media Sosial ---
const socialMedia = [
    {
        name: 'WhatsApp',
        icon: MessageCircle,
        url: 'https://wa.me/6281234567890',
        color: 'text-emerald-600',
        bg: 'bg-emerald-50',
        hover: 'hover:bg-emerald-100',
        border: 'group-hover:border-emerald-200'
    },
    {
        name: 'Instagram',
        icon: Instagram,
        url: 'https://instagram.com/perpustakaanpolban',
        color: 'text-pink-600',
        bg: 'bg-pink-50',
        hover: 'hover:bg-pink-100',
        border: 'group-hover:border-pink-200'
    },
    {
        name: 'Facebook',
        icon: Facebook,
        url: 'https://facebook.com/perpustakaanpolban',
        color: 'text-blue-600',
        bg: 'bg-blue-50',
        hover: 'hover:bg-blue-100',
        border: 'group-hover:border-blue-200'
    },
    {
        name: 'YouTube',
        icon: Youtube,
        url: 'https://youtube.com/perpustakaanpolban',
        color: 'text-red-600',
        bg: 'bg-red-50',
        hover: 'hover:bg-red-100',
        border: 'group-hover:border-red-200'
    },
];

const breadcrumb = [{ label: 'Home', link: '/' }, { label: 'Kontak' }];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-slate-50/50">
            <div class="absolute top-0 right-0 h-[300px] w-[300px] sm:h-[600px] sm:w-[600px] rounded-full bg-[#99cc33]/10 blur-3xl opacity-60"></div>
            <div class="absolute bottom-0 left-0 h-[250px] w-[250px] sm:h-[500px] sm:w-[500px] rounded-full bg-blue-100/50 blur-3xl opacity-60"></div>
        </div>

        <div class="relative container mx-auto max-w-7xl px-4 py-8 sm:py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-10">

                <div class="space-y-6 sm:space-y-8 h-full flex flex-col">

                    <ScrollReveal animation="fade-up" :duration="500" class="flex-1">
                        <div class="group relative h-full overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:shadow-2xl hover:shadow-slate-200/60">
                            <div class="absolute top-0 left-0 h-1.5 w-full bg-[#99cc33]"></div>

                            <h3 class="mb-6 text-xl sm:text-2xl font-bold text-slate-800 flex items-center gap-3">
                                Hubungi Kami
                            </h3>

                            <div class="space-y-6">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                        <MapPin class="h-5 w-5 sm:h-6 sm:w-6" />
                                    </div>
                                    <div>
                                        <h4 class="mb-1 font-bold text-slate-800 text-sm sm:text-base">Alamat</h4>
                                        <p class="text-sm sm:text-base leading-relaxed text-slate-600">
                                            {{ kontak.alamat }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                        <Phone class="h-5 w-5 sm:h-6 sm:w-6" />
                                    </div>
                                    <div>
                                        <h4 class="mb-1 font-bold text-slate-800 text-sm sm:text-base">Telepon & Fax</h4>
                                        <div class="flex flex-col sm:flex-row sm:gap-6">
                                            <p class="text-sm sm:text-base font-medium text-slate-600">
                                                <span class="text-slate-400 font-normal mr-1">Telp:</span> {{ kontak.telepon }}
                                            </p>
                                            <p class="text-sm sm:text-base font-medium text-slate-600">
                                                <span class="text-slate-400 font-normal mr-1">Fax:</span> {{ kontak.fax }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-[#99cc33]/10 text-[#99cc33]">
                                        <Mail class="h-5 w-5 sm:h-6 sm:w-6" />
                                    </div>
                                    <div>
                                        <h4 class="mb-1 font-bold text-slate-800 text-sm sm:text-base">Email</h4>
                                        <a :href="'mailto:' + kontak.email" class="text-sm sm:text-base font-medium text-[#99cc33] underline decoration-dotted underline-offset-4 transition-colors hover:text-[#88b82d]">
                                            {{ kontak.email }}
                                        </a>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 sm:gap-4 border-t border-slate-100 pt-6 mt-2">
                                    <div class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                        <Clock class="h-5 w-5 sm:h-6 sm:w-6" />
                                    </div>
                                    <div class="w-full">
                                        <h4 class="mb-2 font-bold text-slate-800 text-sm sm:text-base">Jam Operasional</h4>
                                        <div class="space-y-2 text-sm sm:text-base text-slate-600">
                                            <div class="flex justify-between border-b border-dashed border-slate-200 pb-1">
                                                <span>Senin - Jumat</span>
                                                <span class="font-bold text-slate-800">{{ kontak.jamOperasional.seninJumat }}</span>
                                            </div>
                                            <div class="flex justify-between border-b border-dashed border-slate-200 pb-1">
                                                <span>Istirahat Jumat</span>
                                                <span class="font-bold text-slate-800">{{ kontak.jamOperasional.istirahatJumat }}</span>
                                            </div>
                                            <div class="flex justify-between text-xs sm:text-sm font-semibold text-red-500 pt-1">
                                                <span>Sabtu, Minggu / Libur</span>
                                                <span class="px-2 py-0.5 bg-red-50 rounded text-red-600 border border-red-100">Tutup</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ScrollReveal>

                    <ScrollReveal animation="fade-up" :duration="500" :delay="200">
                        <div class="rounded-2xl sm:rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-lg shadow-slate-200/50">
                            <h3 class="mb-4 text-lg font-bold text-slate-800">Ikuti Media Sosial Kami</h3>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
                                <a
                                    v-for="social in socialMedia"
                                    :key="social.name"
                                    :href="social.url"
                                    target="_blank"
                                    class="group flex flex-col items-center justify-center gap-2 rounded-xl border border-transparent p-3 sm:p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-1"
                                    :class="[social.bg, social.hover, social.border]"
                                >
                                    <component
                                        :is="social.icon"
                                        class="h-6 w-6 sm:h-8 sm:w-8 transition-transform group-hover:scale-110"
                                        :class="social.color"
                                    />
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-900">{{ social.name }}</span>
                                        <ExternalLink class="w-3 h-3 opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 text-slate-400" />
                                    </div>
                                </a>
                            </div>
                        </div>
                    </ScrollReveal>
                </div>

                <div class="h-[350px] sm:h-[450px] lg:h-full lg:min-h-auto">
                    <ScrollReveal animation="fade-up" :duration="500" :delay="300" class="h-full">
                        <div class="relative h-full w-full overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60 group">

                            <div class="absolute top-4 left-4 z-10 rounded-xl border border-slate-200 bg-white/90 px-3 py-1.5 sm:px-4 sm:py-2 shadow-sm backdrop-blur-sm">
                                <h4 class="flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-800">
                                    <MapPin class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-[#99cc33]" />
                                    Lokasi Kampus
                                </h4>
                            </div>

                            <iframe
                                title="Lokasi Perpustakaan Polban"
                                class="h-full w-full border-0 grayscale-[20%] transition-all duration-700 group-hover:grayscale-0"
                                src="https://maps.google.com/maps?width=100%&height=100%&hl=en&q=perpustakaan%20politeknik%20negeri%20bandung&t=&z=15&ie=UTF8&iwloc=B&output=embed"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                    </ScrollReveal>
                </div>

            </div>
        </div>
    </UserAppLayout>
</template>
