<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { Building2 } from 'lucide-vue-next';

// Props definition remains exactly as requested
defineProps<{
    title: string;
    subtitle: string;
    facilities: {
        subjudul: string;
        description: string;
        image: string;
    }[];
}>();

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Profile' },
    { label: 'Fasilitas' },
];
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <!-- Background decoration (Consistent with LibraryAbout) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <!-- Header Section (Commented out as per original code) -->
            <!-- <div class="mb-10 text-center max-w-3xl mx-auto">
                ...
            </div> -->

            <!-- Facilities Grid -->
            <div
                class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8 xl:grid-cols-3"
            >
                <!--
                    IMPLEMENTASI: ScrollReveal sebagai Wrapper.
                    :delay="index * 100" membuat efek muncul berurutan (staggered).
                    class="h-full" penting agar wrapper mengisi tinggi grid cell sepenuhnya.
                -->
                <ScrollReveal
                    v-for="(facility, index) in facilities"
                    :key="index"
                    animation="fade-up"
                    :delay="index * 100"
                    class="h-full"
                >
                    <!-- Kartu Fasilitas -->
                    <div
                        class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-lg shadow-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/40 hover:shadow-xl hover:shadow-[#99cc33]/10"
                    >
                        <!-- Image Container -->
                        <div class="relative h-52 overflow-hidden">
                            <img
                                :src="facility.image"
                                :alt="'Gambar ' + facility.subjudul"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            ></div>

                            <!-- Floating Icon Badge -->
                            <div
                                class="absolute top-4 right-4 translate-y-2 rounded-xl bg-white/90 p-2 text-[#99cc33] opacity-0 shadow-sm backdrop-blur-sm transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                            >
                                <Building2 class="h-5 w-5" />
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="flex flex-grow flex-col p-6">
                            <h3
                                class="mb-3 flex items-start gap-2 text-xl font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                            >
                                {{ facility.subjudul }}
                            </h3>

                            <div
                                class="prose prose-sm flex-grow text-justify leading-relaxed text-slate-600 prose-slate"
                            >
                                {{ facility.description }}
                            </div>

                            <!-- Decorative bottom line
                            <div
                                class="mt-6 h-1 w-full overflow-hidden rounded-full bg-slate-100"
                            >
                                <div
                                    class="h-full w-0 bg-[#99cc33] transition-all duration-500 ease-out group-hover:w-full"
                                ></div>
                            </div> -->
                        </div>
                    </div>
                </ScrollReveal>
            </div>
        </div>
    </Layout>
</template>
