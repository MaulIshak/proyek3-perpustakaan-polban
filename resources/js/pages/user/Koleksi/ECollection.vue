<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    Apple,
    ExternalLink,
    Info,
    Library,
    Smartphone,
    Sparkles,
    UserPlus,
} from 'lucide-vue-next';

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Layanan' },
    { label: 'E-Collection' },
];

</script>

<template>
    <Head title="E-Collection" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Collection">
        <div class="fixed inset-0 -z-10 h-full w-full bg-slate-50">
            <div
                class="absolute top-0 right-0 h-[500px] w-[500px] rounded-full bg-lime-400/10 blur-[100px]"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-teal-400/10 blur-[100px]"
            ></div>
            <div
                class="absolute top-1/2 left-1/2 h-[800px] w-[800px] -translate-x-1/2 -translate-y-1/2 bg-[url('/images/grid-pattern.svg')] opacity-[0.03]"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div
                class="mx-auto max-w-5xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"
            >
                <div
                    class="h-2 w-full bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
                ></div>

                <div class="p-8 md:p-10">
                    <div class="mb-8 flex items-center gap-4">
                        <div class="rounded-xl bg-lime-100 p-3 text-lime-700">
                            <Library class="h-8 w-8" />
                        </div>
                        <div>
                            <h1
                                class="text-2xl font-bold tracking-tight text-slate-800 md:text-3xl"
                            >
                                E-Collection Nasional
                            </h1>
                            <p class="text-slate-500">
                                Koleksi digital Perpustakaan Politeknik Negeri
                                Bandung
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
                        <div
                            class="sticky top-24 flex flex-col gap-6 self-start lg:col-span-4"
                        >
                            <div
                                class="group relative flex items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-8"
                            >
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-lime-500/10 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                                ></div>

                                <img
                                    src="E-Collection.png"
                                    alt="E-Journal Cover"
                                    class="relative z-10 h-auto w-40 transform object-contain drop-shadow-xl transition-transform duration-500 group-hover:scale-105"
                                    onerror="this.style.display='none'"
                                />

                                <div
                                    class="absolute inset-0 flex items-center justify-center text-slate-300 opacity-20"
                                >
                                    <Library class="h-32 w-32" />
                                </div>
                            </div>

                            <div
                                class="flex w-full cursor-default items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-6 py-3 font-medium text-slate-500"
                            >
                                <Smartphone class="h-4 w-4" />
                                <span>Akses via Aplikasi Mobile</span>
                            </div>
                        </div>

                        <div class="space-y-8 lg:col-span-8">
                            <div class="prose max-w-none prose-slate">
                                <p
                                    class="text-lg leading-relaxed text-slate-600"
                                >
                                    Merupakan koleksi digital berupa
                                    <span class="font-semibold text-slate-800"
                                        >buku, fiksi, majalah, dan koran</span
                                    >
                                    dari Perpustakaan POLBAN. Pemustaka dapat
                                    meminjam, membaca, dan mengembalikan koleksi
                                    digital kapanpun dan dimanapun tanpa harus
                                    datang fisik ke perpustakaan.
                                </p>
                            </div>

                            <div class="h-px bg-slate-100"></div>

                            <div>
                                <h3
                                    class="mb-4 flex items-center gap-2 text-lg font-bold text-slate-800"
                                >
                                    <Sparkles class="h-5 w-5 text-amber-500" />
                                    Akses & Pendaftaran
                                </h3>

                                <div
                                    class="grid grid-cols-1 gap-4 md:grid-cols-2"
                                >
                                    <div
                                        class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-b from-white to-emerald-50/30 p-5 transition hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-100/50"
                                    >
                                        <div
                                            class="absolute top-0 right-0 translate-x-2 -translate-y-2 transform p-3 opacity-10 transition-opacity group-hover:opacity-20"
                                        >
                                            <Smartphone
                                                class="h-24 w-24 rotate-12 text-emerald-500"
                                            />
                                        </div>

                                        <div
                                            class="relative z-10 flex h-full flex-col"
                                        >
                                            <div
                                                class="mb-3 flex items-start justify-between"
                                            >
                                                <div
                                                    class="rounded-lg border border-emerald-100 bg-white p-2 text-emerald-600 shadow-sm"
                                                >
                                                    <Smartphone
                                                        class="h-6 w-6"
                                                    />
                                                </div>
                                                <span
                                                    class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-700"
                                                    >App Mobile</span
                                                >
                                            </div>

                                            <h4
                                                class="mb-1 font-bold text-slate-800"
                                            >
                                                Pengguna Android
                                            </h4>
                                            <p
                                                class="mb-6 text-sm leading-relaxed text-slate-500"
                                            >
                                                Unduh dan instal aplikasi
                                                langsung melalui Google
                                                PlayStore.
                                            </p>

                                            <a
                                                href="https://play.google.com/store/apps/details?id=com.eperpus.saas.ecoll&hl=id"
                                                target="_blank"
                                                class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-lg border border-emerald-200 bg-white px-4 py-2 text-sm font-semibold text-emerald-700 shadow-sm transition-all hover:border-emerald-300 hover:bg-emerald-50"
                                            >
                                                Buka PlayStore
                                                <ExternalLink class="h-3 w-3" />
                                            </a>
                                        </div>
                                    </div>

                                    <div
                                        class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-b from-white to-sky-50/30 p-5 transition hover:border-sky-400 hover:shadow-lg hover:shadow-sky-100/50"
                                    >
                                        <div
                                            class="absolute top-0 right-0 translate-x-2 -translate-y-2 transform p-3 opacity-10 transition-opacity group-hover:opacity-20"
                                        >
                                            <Apple
                                                class="h-24 w-24 rotate-12 text-sky-500"
                                            />
                                        </div>

                                        <div
                                            class="relative z-10 flex h-full flex-col"
                                        >
                                            <div
                                                class="mb-3 flex items-start justify-between"
                                            >
                                                <div
                                                    class="rounded-lg border border-sky-100 bg-white p-2 text-sky-600 shadow-sm"
                                                >
                                                    <Apple class="h-6 w-6" />
                                                </div>
                                                <span
                                                    class="rounded-full bg-sky-100 px-2 py-1 text-[10px] font-bold text-sky-700"
                                                    >Web Form</span
                                                >
                                            </div>

                                            <h4
                                                class="mb-1 font-bold text-slate-800"
                                            >
                                                Pengguna iOS
                                            </h4>
                                            <p
                                                class="mb-6 text-sm leading-relaxed text-slate-500"
                                            >
                                                Pendaftaran akun baru khusus
                                                perangkat Apple (iPhone/iPad).
                                            </p>

                                            <a
                                                href="https://bit.ly/daftar-ecollpolban"
                                                target="_blank"
                                                class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-sky-700 shadow-sm transition-all hover:border-sky-300 hover:bg-sky-50"
                                            >
                                                Isi Formulir
                                                <ExternalLink class="h-3 w-3" />
                                            </a>
                                        </div>
                                    </div>

                                    <div
                                        class="group relative flex flex-col items-center gap-4 overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-r from-white to-purple-50/50 p-5 transition hover:border-purple-400 hover:shadow-lg hover:shadow-purple-100/50 sm:flex-row md:col-span-2"
                                    >
                                        <div
                                            class="shrink-0 rounded-lg border border-purple-100 bg-white p-2 text-purple-600 shadow-sm"
                                        >
                                            <UserPlus class="h-6 w-6" />
                                        </div>
                                        <div
                                            class="flex-1 text-center sm:text-left"
                                        >
                                            <h4
                                                class="font-bold text-slate-800"
                                            >
                                                Dosen & Tenaga Kependidikan
                                            </h4>
                                            <p class="text-sm text-slate-500">
                                                Link pendaftaran khusus untuk
                                                staf Polban.
                                            </p>
                                        </div>
                                        <a
                                            href="https://bit.ly/staf-ecollpolban"
                                            target="_blank"
                                            class="shrink-0 rounded-lg border border-purple-200 bg-white px-5 py-2.5 text-sm font-semibold text-purple-700 shadow-sm transition hover:bg-purple-50"
                                        >
                                            Daftar Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex items-start gap-3 rounded-xl border border-amber-100 bg-amber-50 p-4"
                            >
                                <Info
                                    class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                                />
                                <div class="text-sm text-amber-800">
                                    <span class="font-semibold"
                                        >Info Penting:</span
                                    >
                                    Panduan Akses E-Coll Polban akan dikirimkan
                                    secara otomatis melalui email setelah Anda
                                    berhasil melakukan pendaftaran.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex justify-center border-t border-slate-100 bg-slate-50 px-8 py-4"
                >
                    <p
                        class="flex items-center gap-1.5 text-xs font-medium text-slate-400"
                    >
                        &copy; Perpustakaan Politeknik Negeri Bandung
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>
