<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { 
  UploadCloud, Trash2, Edit, Plus, X, Image as ImageIcon, 
  FileImage, CheckCircle2, AlertCircle 
} from 'lucide-vue-next';

defineOptions({
  layout: (h, page) =>
    h(
      AdminLayout,
      { title: 'Galeri Foto', subTitle: 'Kelola dokumentasi dan koleksi foto perpustakaan' },
      { default: () => page }
    ),
});

// Props
const props = defineProps({
  photos: { type: Object, required: true },
});

const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// Modal State
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editItem = ref(null);
const previewImage = ref(null); // Untuk preview saat select file

// Forms
const createForm = useForm({ foto: null, tipe: 'galeri' });
const editForm = useForm({ foto: null, tipe: 'galeri', _method: 'put' });

// Helper: Handle File Change & Preview
const handleFileChange = (e, formType) => {
  const file = e.target.files?.[0] ?? null;
  const targetForm = formType === 'create' ? createForm : editForm;

  if (file) {
    if (file.size > MAX_FILE_SIZE) {
      targetForm.setError('foto', 'Ukuran file maksimal 5MB.');
      previewImage.value = null;
    } else {
      targetForm.clearErrors('foto');
      targetForm.foto = file;
      // Buat preview URL
      previewImage.value = URL.createObjectURL(file);
    }
  }
};

// Actions
function openCreate() {
  createForm.reset();
  previewImage.value = null;
  createForm.tipe = 'galeri';
  showCreateModal.value = true;
}

function submitCreate() {
  createForm.post('/admin/galeri/store', {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      showCreateModal.value = false;
      createForm.reset();
      previewImage.value = null;
    },
  });
}

function openEdit(photo) {
  editItem.value = photo;
  editForm.reset();
  previewImage.value = photo.url_foto; // Set preview awal dari foto lama
  editForm.tipe = 'galeri';
  editForm.foto = null; // Reset input file
  showEditModal.value = true;
}

function submitEdit() {
  if (!editItem.value) return;
  // Note: Inertia via Laravel PUT method spoofing handled in form definition or route
  editForm.post(`/admin/galeri/${editItem.value.foto_id}`, {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      showEditModal.value = false;
      editForm.reset();
    },
  });
}

function remove(photo) {
  if (!confirm('Yakin ingin menghapus foto ini secara permanen?')) return;
  router.delete(`/admin/galeri/${photo.foto_id}`, { preserveScroll: true });
}
</script>

<template>
  <div class="min-h-screen bg-[#f3fff3] p-6 rounded-xl">
    
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-white p-4 rounded-xl border border-[#99cc33]/30 shadow-sm gap-4">
      <div class="flex items-center gap-3">
        <div class="p-2 bg-[#e6ffe6] rounded-lg text-[#00637b]">
          <ImageIcon class="w-6 h-6" />
        </div>
        <div>
            <h1 class="text-xl font-bold text-[#0f3800]">Daftar Galeri</h1>
            <p class="text-sm text-gray-500">Total {{ props.photos.data.length }} foto tersimpan</p>
        </div>
      </div>
      
      <button
        @click="openCreate"
        class="flex items-center px-5 py-2.5 bg-[#00637b] hover:bg-[#0f3800] text-white rounded-lg transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium"
      >
        <Plus class="w-5 h-5 mr-2" />
        Upload Foto
      </button>
    </div>

    <div v-if="props.photos.data.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
      <div
        v-for="item in props.photos.data"
        :key="item?.foto_id"
        class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-[#99cc33]/20 transition-all duration-300"
      >
        <div class="aspect-[4/3] overflow-hidden bg-gray-100 relative">
          <img
            :src="item.url_foto"
            alt="Gallery Item"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
          />
          
          <div class="absolute inset-0 bg-[#0f3800]/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center gap-3 backdrop-blur-[2px]">
            <button
              @click="openEdit(item)"
              class="flex items-center px-4 py-2 bg-white/20 hover:bg-white text-white hover:text-[#00637b] rounded-full backdrop-blur-md transition-all text-sm font-medium border border-white/30"
            >
              <Edit class="w-4 h-4 mr-2" /> Edit
            </button>
            <button
              @click="remove(item)"
              class="flex items-center px-4 py-2 bg-red-500/80 hover:bg-red-600 text-white rounded-full backdrop-blur-md transition-all text-sm font-medium"
            >
              <Trash2 class="w-4 h-4 mr-2" /> Hapus
            </button>
          </div>
        </div>

        <div class="p-3 bg-white border-t border-gray-100">
            <div class="flex justify-between items-center text-xs text-gray-500">
                <span class="bg-[#f3fff3] text-[#00637b] px-2 py-1 rounded font-semibold uppercase text-[10px] tracking-wider">
                    {{ item.tipe }}
                </span>
                <span>{{ item.size }} KB</span>
            </div>
        </div>
      </div>
    </div>

    <div v-else class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-[#99cc33]/30">
        <div class="w-20 h-20 bg-[#f3fff3] rounded-full flex items-center justify-center mb-4">
            <FileImage class="w-10 h-10 text-[#99cc33]" />
        </div>
        <h3 class="text-lg font-bold text-[#0f3800]">Belum ada foto</h3>
        <p class="text-gray-500 text-sm mt-1">Upload foto pertama Anda untuk mengisi galeri.</p>
        <button @click="openCreate" class="mt-4 text-[#00637b] font-semibold hover:underline">Upload Sekarang</button>
    </div>

    <Transition name="modal">
      <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0f3800]/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border-t-4 border-[#99cc33]">
          
          <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-[#0f3800]">Upload Foto Baru</h2>
            <button @click="showCreateModal = false" class="text-gray-400 hover:text-red-500 transition">
              <X class="w-6 h-6" />
            </button>
          </div>

          <div class="p-6 space-y-4">
            <div class="w-full">
                <label 
                    for="create-file" 
                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-xl cursor-pointer bg-[#f9fff9] hover:bg-[#f0fff0] transition-colors group relative overflow-hidden"
                    :class="createForm.errors.foto ? 'border-red-300 bg-red-50' : 'border-[#99cc33]/40'"
                >
                    <div v-if="!previewImage" class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                        <UploadCloud class="w-10 h-10 mb-3 text-[#99cc33] group-hover:scale-110 transition-transform" />
                        <p class="mb-1 text-sm text-[#0f3800] font-semibold">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-500">Format: JPG, PNG (Max 5MB)</p>
                    </div>
                    <img v-else :src="previewImage" class="absolute inset-0 w-full h-full object-cover opacity-90" />
                    
                    <input id="create-file" type="file" @change="(e) => handleFileChange(e, 'create')" class="hidden" accept="image/*" />
                </label>
                <p v-if="createForm.errors.foto" class="text-xs text-red-500 mt-2 flex items-center">
                    <AlertCircle class="w-3 h-3 mr-1" /> {{ createForm.errors.foto }}
                </p>
            </div>
          </div>

          <div class="p-5 bg-gray-50 flex justify-end gap-3">
            <button @click="showCreateModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
              Batal
            </button>
            <button 
              @click="submitCreate" 
              :disabled="createForm.processing || !createForm.foto"
              class="px-4 py-2 text-sm font-medium text-white bg-[#00637b] rounded-lg hover:bg-[#0f3800] disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
            >
              <span v-if="createForm.processing" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Uploading...
              </span>
              <span v-else>Simpan Foto</span>
            </button>
          </div>
        </div>
      </div>
    </Transition>

    <Transition name="modal">
      <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0f3800]/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border-t-4 border-[#00637b]">
          
          <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-[#0f3800]">Edit Foto</h2>
            <button @click="showEditModal = false" class="text-gray-400 hover:text-red-500 transition">
              <X class="w-6 h-6" />
            </button>
          </div>

          <div class="p-6 space-y-4">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti File Foto</label>
                <label 
                    for="edit-file" 
                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-xl cursor-pointer bg-[#f9fff9] hover:bg-[#f0fff0] transition-colors group relative overflow-hidden"
                    :class="editForm.errors.foto ? 'border-red-300' : 'border-[#00637b]/30'"
                >
                    <div v-if="!previewImage" class="flex flex-col items-center justify-center text-center">
                        <ImageIcon class="w-10 h-10 mb-2 text-[#00637b]" />
                        <span class="text-sm text-[#00637b]">Pilih file baru</span>
                    </div>
                    <img v-else :src="previewImage" class="absolute inset-0 w-full h-full object-cover" />
                    
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <p class="text-white font-semibold text-sm flex items-center"><Edit class="w-4 h-4 mr-2"/> Ganti Gambar</p>
                    </div>

                    <input id="edit-file" type="file" @change="(e) => handleFileChange(e, 'edit')" class="hidden" accept="image/*" />
                </label>
                <p class="text-xs text-gray-500 mt-2 text-center">Biarkan jika tidak ingin mengubah foto.</p>
                <p v-if="editForm.errors.foto" class="text-xs text-red-500 mt-1 flex items-center justify-center">
                    <AlertCircle class="w-3 h-3 mr-1" /> {{ editForm.errors.foto }}
                </p>
            </div>
          </div>

          <div class="p-5 bg-gray-50 flex justify-end gap-3">
            <button @click="showEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
              Batal
            </button>
            <button 
              @click="submitEdit" 
              :disabled="editForm.processing"
              class="px-4 py-2 text-sm font-medium text-white bg-[#00637b] rounded-lg hover:bg-[#0f3800] disabled:opacity-50 flex items-center"
            >
              {{ editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
          </div>
        </div>
      </div>
    </Transition>

  </div>
</template>

<style scoped>
/* Modal Transition Animation */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>