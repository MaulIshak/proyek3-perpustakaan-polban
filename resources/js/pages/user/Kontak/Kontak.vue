<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

// --- Data Halaman dari Controller ---
defineProps<{
    title: string;
    subjudul: string;
}>();

// --- Data & State untuk Formulir Kirim Pesan ---
const form = useForm({
    nama_lengkap: '',
    email: '',
    pesan: '',
});

// --- Data Dummy Informasi Kontak ---
const kontak = {
    alamat: 'UPT Perpustakaan Politeknik Negeri Bandung, Jl. Gegerkalong Hilir, Ciwaruga, Bandung Barat, Jawa Barat 40559',
    telepon: '(022) 2013788',
    email: 'perpustakaan@polban.ac.id',
    jamOperasional: {
        seninJumat: '08:00 - 18:00 WIB',
        sabtu: '08:00 - 12:00 WIB',
    },
};

const breadcrumb = [{ label: 'Profil' }, { label: 'Kontak' }];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col items-start gap-8 lg:flex-row">
                <!-- Informasi Kontak Card -->
                <div
                    class="w-full rounded-lg border bg-white shadow-sm lg:w-1/2"
                >
                    <div class="p-6">
                        <h3 class="text-xl font-bold">Informasi Kontak</h3>
                    </div>
                    <div class="space-y-6 p-6 pt-0 text-sm text-gray-700">
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-emerald-100/50"
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
                                    class="lucide lucide-map-pin h-6 w-6 text-emerald-600"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"
                                    ></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="mt-1">
                                <h4 class="font-semibold text-gray-900">
                                    Alamat
                                </h4>
                                <p>{{ kontak.alamat }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-linear-to-br from-emerald-100 to-emerald-200"
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
                                    class="lucide lucide-phone h-6 w-6 text-emerald-600"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="mt-1">
                                <h4 class="font-semibold text-gray-900">
                                    Telepon
                                </h4>
                                <p>{{ kontak.telepon }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-linear-to-br from-emerald-100 to-emerald-200"
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
                                    class="lucide lucide-mail h-6 w-6 text-emerald-600"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"
                                    ></path>
                                    <rect
                                        x="2"
                                        y="4"
                                        width="20"
                                        height="16"
                                        rx="2"
                                    ></rect>
                                </svg>
                            </div>
                            <div class="mt-1">
                                <h4 class="font-semibold text-gray-900">
                                    Email
                                </h4>
                                <a
                                    :href="'mailto:' + kontak.email"
                                    class="text-blue-600 hover:underline"
                                    >{{ kontak.email }}</a
                                >
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-linear-to-br from-emerald-100 to-emerald-200"
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
                                    class="lucide lucide-clock h-6 w-6 text-emerald-600"
                                    aria-hidden="true"
                                >
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline
                                        points="12 6 12 12 16 14"
                                    ></polyline>
                                </svg>
                            </div>
                            <div class="mt-1">
                                <h4 class="font-semibold text-gray-900">
                                    Jam Operasional
                                </h4>
                                <p>
                                    Senin - Jumat:
                                    {{ kontak.jamOperasional.seninJumat }}
                                </p>
                                <p>Sabtu: {{ kontak.jamOperasional.sabtu }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi Kami Card -->
                <div
                    class="w-full rounded-lg border bg-white shadow-sm lg:w-1/2"
                >
                    <div class="p-6">
                        <h3 class="text-xl font-bold">Lokasi Kami</h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div
                            class="flex h-[300px] w-full items-center justify-center rounded-md border bg-gray-50"
                        >
                            <div class="embed-map-responsive">
                                <div class="embed-map-container">
                                    <iframe
                                        title=""
                                        class="embed-map-frame"
                                        src="https://maps.google.com/maps?width=600&height=400&hl=en&q=Politeknik%20Negeri%20Bandung&t=&z=15&ie=UTF8&iwloc=B&output=embed"
                                    ></iframe
                                    ><a
                                        href="https://sprunkiretake.net"
                                        style="
                                            font-size: 2px !important;
                                            color: gray !important;
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            z-index: 1;
                                            max-height: 1px;
                                            overflow: hidden;
                                        "
                                        >sprunki retake</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
    </UserAppLayout>
</template>
<style>
.embed-map-responsive {
    position: relative;
    text-align: right;
    width: 100%;
    height: 0;
    padding-bottom: 66.66666666666666%;
}
.embed-map-container {
    overflow: hidden;
    background: none !important;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}
.embed-map-frame {
    width: 100% !important;
    height: 100% !important;
    position: absolute;
    top: 0;
    left: 0;
}
</style>
