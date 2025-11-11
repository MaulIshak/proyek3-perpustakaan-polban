<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';

defineProps({
    title: {
        type: String,
        default: '',
    },
    manajemen: Array,
});
const breadcrumb = [{ label: 'Profile' }, { label: 'Fasilitas' }];
</script>

<template>
    <Layout :page="true" :title="title" :breadcrumb="breadcrumb">
        <div
            class="container mx-auto px-4 py-10 leading-relaxed sm:px-6 lg:px-8"
        >
            <!-- <RemahanRoti :itemRoti="breadcrumb" /> -->
            <div class="p-6">
                <!-- <h1 class="mb-4 text-2xl font-bold">{{ title }}</h1>
                <h3 class="mb-3 text-xl">
                    Pengenalan tim manajemen perpustakaan
                </h3> -->
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="min-w-full border border-gray-200 bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    Nama
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    Jabatan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-if="manajemen && manajemen.length > 0"
                                v-for="item in manajemen"
                                :key="item.id_team"
                                class="hover:bg-gray-50"
                            >
                                <td
                                    class="px-6 py-4 text-sm font-medium whitespace-nowrap text-gray-900"
                                >
                                    {{ item.nama }} {{ item.gelar }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm whitespace-nowrap text-gray-500"
                                >
                                    {{ item.jabatan }}
                                </td>
                            </tr>
                            <tr v-else>
                                <td
                                    colspan="3"
                                    class="px-6 py-4 text-center text-sm text-gray-500"
                                >
                                    Tidak ada data manajemen yang tersedia.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>
