<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Briefcase, Users, BadgeCheck } from 'lucide-vue-next';

// Definisi props
defineProps<{
    title: string;
    manajemen?: {
        id_team: number | string;
        nama: string;
        gelar: string;
        jabatan: string;
    }[];
}>();

const breadcrumb = [{ label: 'Profil' }, { label: 'Manajemen' }];
</script>

<template>
    <Layout :page="true" :title="title" :breadcrumb="breadcrumb">
        <!-- Background decoration (Consistent Theme) -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative">
            <!-- Header Section -->
            <!-- <div class="mb-12 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                {{ title }}
                </h1>
                <p class="text-slate-600 text-lg">
                    Struktur organisasi dan tim manajemen perpustakaan.
                </p>
                <div class="flex justify-center mt-6">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <!-- Content Grid -->
            <div
                v-if="manajemen && manajemen.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
            >
                <div
                    v-for="item in manajemen"
                    :key="item.id_team"
                    class="group relative bg-white rounded-2xl p-8 shadow-lg shadow-slate-200/60 border border-slate-100 hover:border-[#99cc33]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center"
                >
                    <!-- Decorative corner icon (optional, adds subtle branding) -->
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <BadgeCheck class="w-5 h-5 text-[#99cc33]/40" />
                    </div>

                    <!-- Name & Title Combined -->
                    <h3 class="text-xl font-bold text-slate-800 mb-4 group-hover:text-[#99cc33] transition-colors leading-snug">
                        {{ item.nama }} {{ item.gelar }}
                    </h3>

                    <!-- Divider -->
                    <div class="w-12 h-0.5 bg-[#99cc33]/30 mb-4 rounded-full"></div>

                    <!-- Jabatan -->
                    <div class="flex items-center gap-2 text-slate-600 bg-slate-50 px-4 py-2 rounded-lg w-full justify-center border border-slate-100 group-hover:bg-[#99cc33]/5 group-hover:border-[#99cc33]/10 transition-all">
                        <Briefcase class="w-4 h-4 text-[#99cc33] shrink-0" />
                        <span class="font-medium text-sm">{{ item.jabatan }}</span>
                    </div>
                </div>
            </div>

            <!-- Empty State (Jika data kosong) -->
            <div v-else class="flex flex-col items-center justify-center py-16 bg-white rounded-3xl border border-dashed border-slate-300 text-center">
                <div class="p-4 bg-slate-50 rounded-full mb-4">
                    <Users class="w-12 h-12 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum ada data</h3>
                <p class="text-slate-500 max-w-xs mx-auto mt-1">
                    Data manajemen perpustakaan belum tersedia saat ini.
                </p>
            </div>
        </div>
    </Layout>
</template>
