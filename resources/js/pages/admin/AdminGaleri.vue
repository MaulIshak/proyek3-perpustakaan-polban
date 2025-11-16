<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { ref } from 'vue'
import { router, useForm } from '@inertiajs/vue3'

defineOptions({
  layout: (h, page) =>
    h(
      AdminLayout,
      { title: 'Galeri Foto', subTitle: 'Kelola koleksi foto galeri' },
      { default: () => page }
    ),
})

// Props dari Controller
const props = defineProps({
  photos: { type: Object, required: true },
})

// Modal State
const showCreateModal = ref(false)
const showEditModal = ref(false)
const editItem = ref(null)

// Form Create
const createForm = useForm({
  foto: null,
  tipe: 'galeri',
})

// Form Edit
const editForm = useForm({
  foto: null,
  tipe: 'galeri',
})

// File input handlers
const onCreateFileChange = (e) => {
  createForm.foto = e.target.files?.[0] ?? null
}

const onEditFileChange = (e) => {
  editForm.foto = e.target.files?.[0] ?? null
}

// Open Create Modal
function openCreate() {
  createForm.reset()
  createForm.tipe = 'galeri'
  showCreateModal.value = true
}

// Submit Create (TANPA ROUTE)
function submitCreate() {
  if (!createForm.foto) return alert('Pilih foto terlebih dahulu.')

  createForm.post('/admin/galeri/store', {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      showCreateModal.value = false
      createForm.reset()
    },
  })
}

// Open Edit Modal
function openEdit(photo) {
  editItem.value = photo
  editForm.reset()
  editForm.tipe = 'galeri'
  editForm.foto = null
  showEditModal.value = true
}

// Submit Edit (TANPA ROUTE)
function submitEdit() {
  if (!editItem.value) return

  editForm
    .transform((data) => ({ ...data, _method: 'put' }))
    .post(`/admin/galeri/${editItem.value.foto_id}`, {
      forceFormData: true,
      preserveScroll: true,
      onSuccess: () => closeEditModal(),
    })
}

// Close Edit Modal
function closeEditModal() {
  showEditModal.value = false
  editForm.reset()
  editItem.value = null
}

// Delete Photo (TANPA ROUTE)
function remove(photo) {
  if (!confirm('Yakin ingin menghapus foto ini?')) return

  router.delete(`/admin/galeri/${photo.foto_id}`)
}
</script>

<template>
  <div class="p-6 space-y-6 bg-[var(--background-green)]">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-[var(--dark-green)]">Galeri Foto</h1>
      <button
        @click="openCreate"
        class="px-4 py-2 bg-[var(--primary-green)] text-white rounded-lg transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
      >
        Upload Foto Baru
      </button>
    </div>

    <!-- Grid List -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
            v-for="item in (props.photos.data ?? props.photos)"
            :key="item?.foto_id"
            class="border rounded-lg p-3 bg-[var(--card)] shadow transition-all duration-200 ease-in-out hover:scale-105"
        >

        <img
          :src="item.url_foto"
          class="w-full h-32 object-cover rounded"
        />

        <div class="mt-3 text-sm">
          <p><span class="font-semibold">Size:</span> {{ item.size }} KB</p>
          <p><span class="font-semibold">Tipe:</span> {{ item.tipe }}</p>
        </div>

        <div class="flex gap-2 mt-3">
          <button
            @click="openEdit(item)"
            class="px-3 py-1 bg-[var(--dark-green)]  text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
          >
            Edit
          </button>

          <button
            @click="remove(item)"
            class="px-3 py-1 bg-[var(--destructive)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Create -->
    <div v-if="showCreateModal" class="modal-backdrop">
      <div class="modal-box">
        <h2 class="text-lg font-bold mb-4">Upload Foto Baru</h2>

        <div class="flex items-center space-x-4">
          <label for="create-file-input" class="cursor-pointer px-4 py-2 bg-[var(--primary-green)] text-white rounded-lg transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105">
            Choose File
          </label>
          <input id="create-file-input" type="file" @change="onCreateFileChange" class="hidden" />
          <span v-if="createForm.foto" class="text-sm text-gray-500">{{ createForm.foto.name }}</span>
          <span v-else class="text-sm text-gray-500">No file chosen</span>
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button
            @click="submitCreate"
            class="px-4 py-2 bg-[var(--primary-green)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
          >
            Upload
          </button>
          <button
            @click="showCreateModal = false"
            class="px-4 py-2 bg-[var(--muted)] rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
          >
            Batal
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Edit -->
    <div v-if="showEditModal" class="modal-backdrop">
      <div class="modal-box">
        <h2 class="text-lg font-bold mb-4">Edit Foto</h2>

        <div class="flex items-center space-x-4">
          <label for="edit-file-input" class="cursor-pointer px-4 py-2 bg-[var(--secondary-green)] text-white rounded-lg transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105">
            Choose File
          </label>
          <input id="edit-file-input" type="file" @change="onEditFileChange" class="hidden" />
          <span v-if="editForm.foto" class="text-sm text-gray-500">{{ editForm.foto.name }}</span>
          <span v-else class="text-sm text-gray-500">No file chosen</span>
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button
            @click="submitEdit"
            class="px-4 py-2 bg-[var(--secondary-green)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105"
          >
            Simpan
          </button>
          <button @click="closeEditModal" class="px-4 py-2 bg-[var(--muted)] rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105">
            Batal
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<style>
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-box {
  background: white;
  padding: 24px;
  border-radius: 8px;
  width: 350px;
}
</style>
