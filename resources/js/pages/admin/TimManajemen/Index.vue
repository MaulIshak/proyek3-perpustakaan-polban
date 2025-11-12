<!--
    File: resources/js/pages/admin/_template.vue
    Deskripsi: Template halaman admin dengan layout yang dapat disesuaikan
-->
<script setup>
import { Plus } from 'lucide-vue-next'; // pastikan sudah install lucide-vue-next
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Pencil, Trash } from 'lucide-vue-next';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Tim Manajemen',
                subTitle: 'Kelola Data Tim Manajemen Perpustakaan',
            },
            { default: () => page },
        ),
});

defineProps({
    title: String,
    subjudul: String,  
    manajemen: Array
});

</script>

<template>
    <button
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 font-medium text-white transition-all hover:bg-emerald-700"
        >
            <Plus class="h-4 w-4" />
            <span>Tambah Tim</span>
    </button>
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-5">
      <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gelar</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-span-2  ">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-if="manajemen && manajemen.length > 0" v-for="item in manajemen" :key="item.id_team" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.jabatan }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.gelar }}</td>
            <td class="flex justify-center py-4 whitespace-nowrap text-sm text-gray-500 bg-blue-700">
                <button
                    class="rounded-lg border border-yellow-500 px-2 py-2 text-center font-medium text-yellow-500 transition hover:bg-yellow-500 hover:text-white"
                >
                    <Pencil class="mr-1 inline-block h-4 w-4" />
                    Edit
                </button>
            </td>
            <td class="whitespace-nowrap text-sm text-grey-500">
              <button
                        type="submit"
                        class="rounded-lg border border-red-600 px-2 py-2 text-center font-medium text-red-600 transition hover:bg-red-600 hover:text-white"
                    >
                        <Trash class="mr-1 inline-block h-4 w-4" />
                        Hapus
                </button> 
            </td>
          </tr>
          <tr v-else>
            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
              Tidak ada data manajemen yang tersedia.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>