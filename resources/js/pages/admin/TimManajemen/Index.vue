<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Plus, Pencil, Trash } from 'lucide-vue-next'

defineOptions({
    layout: (h, page) =>
        h(AdminLayout, { title: 'Tim Manajemen', subTitle: 'Kelola Data Tim Manajemen' }, { default: () => page })
})

defineProps({ manajemen: Array })

const showModal = ref(false)
const editMode = ref(false)
const form = ref({ id_team: null, nama: '', jabatan: '', gelar: '' })

const showDeleteModal = ref(false)
const deletingItemId = ref(null)
const deletingItem = ref(null)

function openCreateModal() {
    editMode.value = false
    form.value = { id_team: null, nama: '', jabatan: '', gelar: '' }
    showModal.value = true
}

function openEditModal(item) {
    editMode.value = true
    form.value = { ...item }
    showModal.value = true
}

function save() {
    if (editMode.value) {
        router.put(`/admin/tim-manajemen/update/${form.value.id_team}`, form.value)
    } else {
        router.post('/admin/tim-manajemen/store', form.value)
    }
    showModal.value = false
}

function openDeleteModal(item) {
    deletingItemId.value = item.id_team
    deletingItem.value = item
    showDeleteModal.value = true
}

function confirmDelete() {
    router.delete(`/admin/tim-manajemen/delete/${deletingItemId.value}`)
    showDeleteModal.value = false
    deletingItemId.value = null
    deletingItem.value = null
}
</script>

<template>
    <button @click="openCreateModal" class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 font-medium text-white hover:bg-emerald-700">
        <Plus class="h-4 w-4" />
        Tambah Tim
    </button>

    <!-- Table -->
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gelar</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in manajemen" :key="item.id_team" class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ item.nama }}</td>
                    <td class="px-6 py-4 text-sm">{{ item.jabatan }}</td>
                    <td class="px-6 py-4 text-sm">{{ item.gelar }}</td>
                    <td class="px-6 py-4 text-sm flex justify-center gap-2">
                        <button @click="openEditModal(item)" class="border border-yellow-500 text-yellow-500 px-2 py-1 rounded hover:bg-yellow-500 hover:text-white">
                            <Pencil class="inline w-4 h-4" /> Edit
                        </button>
                        <button @click="openDeleteModal(item)" class="border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white">
                            <Trash class="inline w-4 h-4" /> Hapus
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <Teleport to="body">
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-[9999]">

        <!-- 🌫️ Background blur smooth -->
        <div 
        class="absolute inset-0 bg-black/30 backdrop-blur transition-all duration-700 ease-out opacity-100"
        ></div>

        <!-- 🪟 Modal box tetap pakai transisi scale + fade -->
        <Transition
        enter-from-class="opacity-0 scale-90"
        enter-active-class="transition-all duration-300 ease-out"
        leave-to-class="opacity-0 scale-90"
        leave-active-class="transition-all duration-200 ease-in"
        >
        <div 
            v-if="showModal" 
            class="relative bg-white p-6 rounded-lg w-96 shadow-lg"
        >
            <h2 class="text-lg font-semibold mb-4">
            {{ editMode ? 'Edit Tim' : 'Tambah Tim' }}
            </h2>
            <form @submit.prevent="save">
            <div class="mb-3">
                <label class="block text-sm font-medium">Nama</label>
                <input v-model="form.nama" class="w-full border rounded px-3 py-2" required />
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Jabatan</label>
                <input v-model="form.jabatan" class="w-full border rounded px-3 py-2" required />
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Gelar</label>
                <input v-model="form.gelar" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                {{ editMode ? 'Update' : 'Simpan' }}
                </button>
            </div>
            </form>
        </div>
        </Transition>
    </div>
    </Teleport>


    <!-- Delete Confirmation Modal -->
    <Teleport to="body">
        <Transition
            enter-from-class="opacity-0 scale-90"
            enter-active-class="transition-all duration-200 ease-out"
            leave-to-class="opacity-0 scale-90"
            leave-active-class="transition-all duration-200 ease-in"
        >
            <div v-if="showDeleteModal" class="fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-[9999]">
                <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                    <h2 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h2>
                    Yakin ingin menghapus data 
                    <span class="font-semibold">
                        {{ deletingItem?.nama }} {{ deletingItem?.gelar ? '(' + deletingItem.gelar + ')' : '' }}
                    </span>?
                    <div class="flex justify-end gap-2 mt-4">
                        <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Tidak</button>
                        <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya</button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
