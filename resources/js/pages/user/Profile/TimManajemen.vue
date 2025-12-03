<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { BadgeCheck, Briefcase, Users } from 'lucide-vue-next';

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

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profil' },
    { label: 'Manajemen' },
];
</script>

<template>
    <Layout :page="true" :title="title" :breadcrumb="breadcrumb">
        <!-- Background decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header Section (Commented out in original, kept commented) -->
            <!-- <div class="mb-12 text-center max-w-3xl mx-auto">
                ...
            </div> -->

            <!-- Content Grid -->
            <div
                v-if="manajemen && manajemen.length > 0"
                class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8"
            >
                <!--
                    IMPLEMENTASI: ScrollReveal Wrapper
                    - Animation: fade-up (standar untuk grid items)
                    - Staggering: index * 100ms delay per item
                -->
                <ScrollReveal
                    v-for="(item, index) in manajemen"
                    :key="item.id_team"
                    animation="fade-up"
                    :delay="index * 100"
                    class="h-full"
                >
                    <div
                        class="group relative flex h-full flex-col items-center rounded-2xl border border-slate-100 bg-white p-8 text-center shadow-lg shadow-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/30"
                    >
                        <!-- Decorative corner icon (optional, adds subtle branding) -->
                        <div
                            class="absolute top-4 right-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        >
                            <BadgeCheck class="h-5 w-5 text-[#99cc33]/40" />
                        </div>

                        <!-- Name & Title Combined -->
                        <h3
                            class="mb-4 text-xl leading-snug font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                        >
                            {{ item.nama }} {{ item.gelar }}
                        </h3>

                        <!-- Divider -->
                        <div
                            class="mb-4 h-0.5 w-12 rounded-full bg-[#99cc33]/30"
                        ></div>

                        <!-- Jabatan -->
                        <div
                            class="mt-auto flex w-full items-center justify-center gap-2 rounded-lg border border-slate-100 bg-slate-50 px-4 py-2 text-slate-600 transition-all group-hover:border-[#99cc33]/10 group-hover:bg-[#99cc33]/5"
                        >
                            <Briefcase
                                class="h-4 w-4 shrink-0 text-[#99cc33]"
                            />
                            <span class="text-sm font-medium">{{
                                item.jabatan
                            }}</span>
                        </div>
                    </div>
                </ScrollReveal>
            </div>

            <!-- Empty State (Jika data kosong) -->
            <ScrollReveal
                v-else
                animation="fade-in"
                class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white py-16 text-center"
            >
                <div class="mb-4 rounded-full bg-slate-50 p-4">
                    <Users class="h-12 w-12 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum ada data</h3>
                <p class="mx-auto mt-1 max-w-xs text-slate-500">
                    Data manajemen perpustakaan belum tersedia saat ini.
                </p>
            </ScrollReveal>
        </div>
    </Layout>
</template>
