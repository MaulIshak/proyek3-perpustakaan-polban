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

const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

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
  const file = e.target.files?.[0] ?? null;
  if (file) {
    if (file.size > MAX_FILE_SIZE) {
      createForm.setError('foto', 'Ukuran file tidak boleh lebih dari 5MB.');
    } else {
      createForm.clearErrors('foto');
    }
  }
  createForm.foto = file;
}

const onEditFileChange = (e) => {
  const file = e.target.files?.[0] ?? null;
  if (file) {
    if (file.size > MAX_FILE_SIZE) {
      editForm.setError('foto', 'Ukuran file tidak boleh lebih dari 5MB.');
    } else {
      editForm.clearErrors('foto');
    }
  }
  editForm.foto = file;
}

// Open Create Modal
function openCreate() {
  createForm.reset()
  createForm.tipe = 'galeri'
  showCreateModal.value = true
}

// Submit Create
function submitCreate() {
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

// Submit Edit
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

// Delete Photo
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
        class="px-4 py-2 bg-(--primary-green) text-white rounded-lg transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer"
      >
        Upload Foto Baru
      </button>
    </div>

    <!-- Grid List -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
            v-for="item in props.photos.data"
            :key="item?.foto_id"
            class="border rounded-lg p-3 bg-[var(--card)] shadow transition-all duration-200 ease-in-out hover:scale-105"
        >

        <img
          :src="item.url_foto"
          alt="galeri"
          class="w-full h-32 object-cover rounded"
        />

        <div class="mt-3 text-sm">
          <p><span class="font-semibold">Size:</span> {{ item.size }} KB</p>
          <p><span class="font-semibold">Tipe:</span> {{ item.tipe }}</p>
        </div>

        <div class="flex gap-2 mt-3">
          <button
            @click="openEdit(item)"
            class="px-3 py-1 bg-[var(--dark-green)]  text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer"
          >
            Edit
          </button>

          <button
            @click="remove(item)"
            class="px-3 py-1 bg-[var(--destructive)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer"
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
        <div v-if="createForm.errors.foto" class="text-sm text-red-500 mt-2">
          {{ createForm.errors.foto }}
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button
            @click="submitCreate"
            :disabled="createForm.processing || createForm.errors.foto"
            class="px-4 py-2 bg-[var(--primary-green)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer disabled:opacity-50"
          >
            {{ createForm.processing ? 'Uploading...' : 'Upload' }}
          </button>
          <button
            @click="showCreateModal = false"
            class="px-4 py-2 bg-[var(--muted)] rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer"
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
          <label for="edit-file-input" class="cursor-pointer px-4 py-2 bg-[var(--primary-green)] text-white rounded-lg transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105">
            Choose File
          </label>
          <input id="edit-file-input" type="file" @change="onEditFileChange" class="hidden" />
          <span v-if="editForm.foto" class="text-sm text-gray-500">{{ editForm.foto.name }}</span>
          <span v-else class="text-sm text-gray-500">No file chosen</span>
        </div>
        <div v-if="editForm.errors.foto" class="text-sm text-red-500 mt-2">
          {{ editForm.errors.foto }}
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button
            @click="submitEdit"
            :disabled="editForm.processing || editForm.errors.foto"
            class="px-4 py-2 bg-[var(--secondary-green)] text-white rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer disabled:opacity-50"
          >
            {{ editForm.processing ? 'Saving...' : 'Simpan' }}
          </button>
          <button @click="closeEditModal" class="px-4 py-2 bg-[var(--muted)] rounded transition-all duration-200 ease-in-out hover:opacity-80 hover:scale-105 cursor-pointer">
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
