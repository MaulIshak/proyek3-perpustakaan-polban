<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Library, 
    ExternalLink, 
    Smartphone, 
    Apple, 
    UserPlus, 
    Info,
    CheckCircle2,
    Sparkles 
} from 'lucide-vue-next';

const breadcrumb = [{ label: 'Layanan' }, { label: 'E-Collection' }];
</script>

<template>
    <Head title="E-Collection" />

    <Layout :page="true" :breadcrumb="breadcrumb" title="E-Collection">

        <div class="fixed inset-0 -z-10 h-full w-full bg-slate-50">
            <div class="absolute top-0 right-0 h-[500px] w-[500px] rounded-full bg-lime-400/10 blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-teal-400/10 blur-[100px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[800px] w-[800px] bg-[url('/images/grid-pattern.svg')] opacity-[0.03]"></div>
        </div>

        <div class="relative container mx-auto px-4 py-8 sm:px-6 lg:px-8">
            
            <div class="mx-auto max-w-5xl overflow-hidden rounded-3xl bg-white shadow-xl shadow-slate-200/60 border border-slate-100">
                
                <div class="h-2 w-full bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"></div>

                <div class="p-8 md:p-10">
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-3 rounded-xl bg-lime-100 text-lime-700">
                            <Library class="w-8 h-8" />
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">E-Journal Nasional</h1>
                            <p class="text-slate-500">Koleksi digital Perpustakaan Politeknik Negeri Bandung</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        
                        <div class="lg:col-span-4 flex flex-col gap-6 sticky top-24 self-start">
                            <div class="relative group rounded-2xl bg-slate-50 border border-slate-200 p-8 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-lime-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                <img src="E-Collection.png" 
                                     alt="E-Journal Cover" 
                                     class="relative z-10 w-40 h-auto object-contain drop-shadow-xl transform group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.style.display='none'" />
                                
                                <div class="absolute inset-0 flex items-center justify-center text-slate-300 opacity-20">
                                    <Library class="w-32 h-32" />
                                </div>
                            </div>

                            <div class="w-full flex items-center justify-center gap-2 bg-slate-100 text-slate-500 font-medium py-3 px-6 rounded-xl border border-slate-200 cursor-default">
                                <Smartphone class="w-4 h-4" />
                                <span>Akses via Aplikasi Mobile</span>
                            </div>
                        </div>

                        <div class="lg:col-span-8 space-y-8">
                            
                            <div class="prose prose-slate max-w-none">
                                <p class="text-lg leading-relaxed text-slate-600">
                                    Merupakan koleksi digital berupa <span class="font-semibold text-slate-800">buku, fiksi, majalah, dan koran</span> dari Perpustakaan POLBAN. Pemustaka dapat meminjam, membaca, dan mengembalikan koleksi digital kapanpun dan dimanapun tanpa harus datang fisik ke perpustakaan.
                                </p>
                            </div>

                            <div class="h-px bg-slate-100"></div>

                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <Sparkles class="w-5 h-5 text-amber-500" />
                                    Akses & Pendaftaran
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
                                    <div class="relative p-5 rounded-xl border border-slate-200 bg-gradient-to-b from-white to-emerald-50/30 hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-100/50 transition flex flex-col group overflow-hidden">
                                        
                                        <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity transform translate-x-2 -translate-y-2">
                                            <Smartphone class="w-24 h-24 text-emerald-500 rotate-12" />
                                        </div>

                                        <div class="relative z-10 h-full flex flex-col">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="p-2 bg-white shadow-sm border border-emerald-100 rounded-lg text-emerald-600">
                                                    <Smartphone class="w-6 h-6" />
                                                </div>
                                                <span class="text-[10px] font-bold px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full">App Mobile</span>
                                            </div>
                                            
                                            <h4 class="font-bold text-slate-800 mb-1">Pengguna Android</h4>
                                            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                                                Unduh dan instal aplikasi langsung melalui Google PlayStore.
                                            </p>

                                            <a href="https://play.google.com/store/apps/details?id=com.eperpus.saas.ecoll&hl=id" target="_blank" 
                                            class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-lg bg-white border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50 hover:border-emerald-300 transition-all">
                                                Buka PlayStore
                                                <ExternalLink class="w-3 h-3" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="relative p-5 rounded-xl border border-slate-200 bg-gradient-to-b from-white to-sky-50/30 hover:border-sky-400 hover:shadow-lg hover:shadow-sky-100/50 transition flex flex-col group overflow-hidden">
                                        
                                        <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity transform translate-x-2 -translate-y-2">
                                            <Apple class="w-24 h-24 text-sky-500 rotate-12" />
                                        </div>

                                        <div class="relative z-10 h-full flex flex-col">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="p-2 bg-white shadow-sm border border-sky-100 rounded-lg text-sky-600">
                                                    <Apple class="w-6 h-6" />
                                                </div>
                                                <span class="text-[10px] font-bold px-2 py-1 bg-sky-100 text-sky-700 rounded-full">Web Form</span>
                                            </div>
                                            
                                            <h4 class="font-bold text-slate-800 mb-1">Pengguna iOS</h4>
                                            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                                                Pendaftaran akun baru khusus perangkat Apple (iPhone/iPad).
                                            </p>

                                            <a href="https://bit.ly/daftar-ecollpolban" target="_blank" 
                                            class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-lg bg-white border border-sky-200 px-4 py-2 text-sm font-semibold text-sky-700 shadow-sm hover:bg-sky-50 hover:border-sky-300 transition-all">
                                                Isi Formulir
                                                <ExternalLink class="w-3 h-3" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="md:col-span-2 relative p-5 rounded-xl border border-slate-200 bg-gradient-to-r from-white to-purple-50/50 hover:border-purple-400 hover:shadow-lg hover:shadow-purple-100/50 transition group overflow-hidden flex flex-col sm:flex-row items-center gap-4">
                                        <div class="p-2 bg-white shadow-sm border border-purple-100 rounded-lg text-purple-600 shrink-0">
                                            <UserPlus class="w-6 h-6" />
                                        </div>
                                        <div class="flex-1 text-center sm:text-left">
                                            <h4 class="font-bold text-slate-800">Dosen & Tenaga Kependidikan</h4>
                                            <p class="text-sm text-slate-500">Link pendaftaran khusus untuk staf Polban.</p>
                                        </div>
                                        <a href="https://bit.ly/staf-ecollpolban" target="_blank" class="shrink-0 px-5 py-2.5 rounded-lg bg-white border border-purple-200 text-purple-700 text-sm font-semibold hover:bg-purple-50 transition shadow-sm">
                                            Daftar Sekarang
                                        </a>
                                    </div>

                                </div>
                            </div>

                            <div class="rounded-xl bg-amber-50 border border-amber-100 p-4 flex items-start gap-3">
                                <Info class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" />
                                <div class="text-sm text-amber-800">
                                    <span class="font-semibold">Info Penting:</span> Panduan Akses E-Coll Polban akan dikirimkan secara otomatis melalui email setelah Anda berhasil melakukan pendaftaran.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border-t border-slate-100 py-4 px-8 flex justify-center">
                    <p class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                        &copy; Perpustakaan Politeknik Negeri Bandung
                    </p>
                </div>
            </div>

        </div>
    </Layout>
</template>