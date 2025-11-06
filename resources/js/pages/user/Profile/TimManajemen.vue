
<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import RemahanRoti from '@/layouts/RemahanRoti.vue';

defineProps({
    title: String,
    manajemen: Array
});
const breadcrumb = [
    { label: 'Profile' },
    { label: 'Fasilitas' }
];
</script>

<template>
    <Layout>
    
    <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8 max-w-4xl leading-relaxed">
    <RemahanRoti :itemRoti="breadcrumb" />
    <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ title }}</h1>
    <h3 class="text-xl mb-3 ">Pengenalan tim manajemen perpustakaan</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-if="manajemen && manajemen.length > 0" v-for="item in manajemen" :key="item.id_team" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.nama }} {{ item.gelar }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.jabatan }}</td>
          </tr>
          <tr v-else>
            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
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
