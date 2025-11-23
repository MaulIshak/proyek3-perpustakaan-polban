<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import {
  UploadCloud, Trash2, Edit, Plus, X, Image as ImageIcon,
  FileImage, Save, RotateCcw, AlertCircle
} from 'lucide-vue-next';

// Import ConfirmModal dan Composables
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

// Layout Definition
defineOptions({
  layout: (h: any, page: any) =>
    h(
      AdminLayout,
      {
        title: 'Kelola Galeri',
        subTitle: 'Manajemen dokumentasi foto dan koleksi visual perpustakaan'
      },
      { default: () => page }
    ),
});

// Props
const props = defineProps<{
  photos: {
    data: any[];
    links: any[];
    // ... pagination props lainnya
  };
}>();

const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// State
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editItem = ref<any>(null);
const previewImage = ref<string | null>(null);
const fileInputRef = ref<HTMLInputElement | null>(null);

// Use Confirm Modal
const { open } = useConfirmModal();

// Forms
const createForm = useForm({
    foto: null as File | null,
    judul: '',
    tipe: 'galeri'
});

const editForm = useForm({
    foto: null as File | null,
    judul: '',
    tipe: 'galeri',
    _method: 'put'
});

// Helper: Handle File Change & Preview
const handleFileChange = (e: Event, formType: 'create' | 'edit') => {
  const target = e.target as HTMLInputElement;
  const file = target.files?.[0] ?? null;
  const targetForm = formType === 'create' ? createForm : editForm;

  if (file) {
    if (file.size > MAX_FILE_SIZE) {
      targetForm.setError('foto', 'Ukuran file maksimal 5MB.');
      previewImage.value = null;
    } else {
      targetForm.clearErrors('foto');
      targetForm.foto = file;
      previewImage.value = URL.createObjectURL(file);
    }
  }
};

// Trigger File Input Click
const triggerFileInput = () => {
    fileInputRef.value?.click();
};

// Actions
function openCreate() {
  createForm.reset();
  previewImage.value = null;
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

function openEdit(photo: any) {
  editItem.value = photo;
  editForm.reset();
  editForm.judul = photo.judul || '';
  previewImage.value = photo.url_foto;
  editForm.foto = null;
  showEditModal.value = true;
}

function submitEdit() {
  if (!editItem.value) return;
  editForm.post(`/admin/galeri/${editItem.value.foto_id}`, {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      showEditModal.value = false;
      editForm.reset();
    },
  });
}

// Menggunakan ConfirmModal
function remove(photo: any) {
  open({
      title: 'Hapus Foto Galeri?',
      message: 'Apakah Anda yakin ingin menghapus foto ini secara permanen? Tindakan ini tidak dapat dibatalkan.',
      actionLabel: 'Hapus',
    //   confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
      onConfirm: () => {
          router.delete(`/admin/galeri/${photo.foto_id}`, {
              preserveScroll: true
          });
      },
  });
}
</script>

<template>
  <div class="space-y-8 font-sans">

    <!-- 1. Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
      <div class="flex items-center gap-3">
        <div class="p-2 bg-[#99cc33]/10 rounded-xl text-[#99cc33]">
          <ImageIcon class="w-6 h-6" />
        </div>
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Foto</h2>
            <p class="text-xs text-slate-500 font-medium">Total {{ props.photos.data.length }} item</p>
        </div>
      </div>

      <button
        @click="openCreate"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-[#99cc33] hover:bg-[#88b82d] shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 active:translate-y-0"
      >
        <Plus class="w-5 h-5" />
        Upload Foto Baru
      </button>
    </div>

    <!-- 2. Grid Gallery -->
    <div v-if="props.photos.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div
        v-for="item in props.photos.data"
        :key="item?.foto_id"
        class="group relative bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#99cc33]/50 transition-all duration-300 overflow-hidden flex flex-col"
      >
        <!-- Image Area -->
        <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
          <img
            :src="item.url_foto"
            alt="Gallery Item"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
          />

          <!-- Overlay Actions -->
          <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3">
            <button
              @click="openEdit(item)"
              class="p-2 bg-white/20 hover:bg-white text-white hover:text-[#99cc33] rounded-full backdrop-blur-md transition-all transform hover:scale-110"
              title="Edit Foto"
            >
              <Edit class="w-5 h-5" />
            </button>
            <button
              @click="remove(item)"
              class="p-2 bg-white/20 hover:bg-red-500 text-white rounded-full backdrop-blur-md transition-all transform hover:scale-110"
              title="Hapus Foto"
            >
              <Trash2 class="w-5 h-5" />
            </button>
          </div>
        </div>

        <!-- Meta Footer -->
        <div class="p-3 bg-white border-t border-slate-100 flex justify-between items-center">
            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                {{ item.tipe || 'GALERI' }}
            </span>
            <span class="text-xs text-slate-400 font-medium">{{ item.size || '0' }} KB</span>
        </div>
      </div>
    </div>

    <!-- 3. Empty State -->
    <div v-else class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl border border-dashed border-slate-200 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 animate-pulse">
            <FileImage class="w-10 h-10 text-slate-400" />
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Galeri Kosong</h3>
        <p class="text-slate-500 text-sm max-w-md leading-relaxed">
            Belum ada foto yang diunggah. Mulai dokumentasikan kegiatan perpustakaan dengan mengunggah foto pertama Anda.
        </p>
        <button
            @click="openCreate"
            class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
        >
            Upload Foto Sekarang
        </button>
    </div>

    <!-- MODAL CREATE -->
    <transition name="modal">
      <div v-if="showCreateModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="showCreateModal = false"></div>

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative z-10">
          <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Upload Foto Baru</h3>
            <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 bg-white p-1 rounded-full shadow-sm transition">
              <X class="w-5 h-5" />
            </button>
          </div>

          <div class="p-6 space-y-6">
            <!-- Upload Area -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">File Foto</label>

                <!-- PERBAIKAN: Dropzone Area -->
                <div
                    @click="triggerFileInput"
                    class="group relative w-full h-64 border-2 border-dashed rounded-2xl cursor-pointer transition-all flex flex-col items-center justify-center text-center overflow-hidden bg-slate-50"
                    :class="[
                        createForm.errors.foto ? 'border-red-300 bg-red-50' : 'border-slate-300 hover:border-[#99cc33] hover:bg-[#99cc33]/5',
                        previewImage ? 'border-solid' : ''
                    ]"
                >
                    <!-- Case 1: Ada Preview Image (Tampilkan Gambar Full, Sembunyikan Teks Default) -->
                    <template v-if="previewImage">
                        <img
                            :src="previewImage"
                            class="w-full h-full object-contain p-2"
                        />

                        <!-- Overlay Hover: Hanya muncul saat di-hover untuk ganti gambar -->
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white backdrop-blur-[1px]">
                            <RotateCcw class="w-8 h-8 mb-2" />
                            <span class="text-sm font-bold">Klik untuk ganti foto</span>
                        </div>
                    </template>

                    <!-- Case 2: Belum Ada Image (Tampilkan Placeholder Upload) -->
                    <div v-else class="flex flex-col items-center justify-center p-6 transition-transform duration-300 group-hover:scale-105">
                        <div class="p-4 bg-white rounded-full shadow-sm mb-3 group-hover:shadow-md">
                            <UploadCloud class="w-8 h-8 text-[#99cc33]" />
                        </div>
                        <p class="text-sm font-bold text-slate-700 group-hover:text-[#99cc33] transition-colors">
                            Klik untuk pilih foto
                        </p>
                        <p class="text-xs mt-1 text-slate-400 font-medium">JPG, PNG (Maks. 5MB)</p>
                    </div>

                    <!-- Hidden Input -->
                    <input
                        ref="fileInputRef"
                        type="file"
                        @change="(e) => handleFileChange(e, 'create')"
                        class="hidden"
                        accept="image/*"
                    />
                </div>

                <!-- Error Message -->
                <p v-if="createForm.errors.foto" class="text-xs text-red-500 mt-2 flex items-center font-medium animate-pulse">
                    <AlertCircle class="w-3 h-3 mr-1" /> {{ createForm.errors.foto }}
                </p>
            </div>
          </div>

          <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
            <button @click="showCreateModal = false" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors shadow-sm">
              Batal
            </button>
            <button
              @click="submitCreate"
              :disabled="createForm.processing || !createForm.foto"
              class="flex items-center px-6 py-2.5 bg-[#99cc33] text-white font-bold rounded-xl hover:bg-[#88b82d] shadow-lg shadow-[#99cc33]/30 transition-all disabled:opacity-70 disabled:cursor-not-allowed"
            >
              <span v-if="createForm.processing" class="flex items-center gap-2">
                 <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                 Mengunggah...
              </span>
              <span v-else class="flex items-center gap-2">
                 <Save class="w-4 h-4" /> Simpan
              </span>
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!-- MODAL EDIT -->
    <transition name="modal">
      <div v-if="showEditModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="showEditModal = false"></div>

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all relative z-10">
          <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Edit Foto</h3>
            <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 bg-white p-1 rounded-full shadow-sm transition">
              <X class="w-5 h-5" />
            </button>
          </div>

          <div class="p-6 space-y-6">
            <div class="w-full">
                <label class="block text-sm font-bold text-slate-700 mb-2">Preview Gambar</label>

                <div class="relative aspect-video rounded-xl overflow-hidden bg-slate-100 border border-slate-200 mb-4 group">
                    <img :src="previewImage || ''" class="w-full h-full object-contain" />

                    <!-- Edit Overlay -->
                    <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                        <RotateCcw class="w-8 h-8 mb-2" />
                        <span class="text-sm font-bold">Ganti Gambar</span>
                        <input type="file" @change="(e) => handleFileChange(e, 'edit')" class="hidden" accept="image/*" />
                    </label>
                </div>

                <p v-if="editForm.errors.foto" class="text-xs text-red-500 mt-1 flex items-center">
                    <AlertCircle class="w-3 h-3 mr-1" /> {{ editForm.errors.foto }}
                </p>
                <p class="text-xs text-slate-400 italic text-center">Klik gambar di atas untuk mengganti foto.</p>
            </div>
          </div>

          <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
            <button @click="showEditModal = false" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors shadow-sm">
              Batal
            </button>
            <button
              @click="submitEdit"
              :disabled="editForm.processing"
              class="px-6 py-2.5 bg-[#99cc33] text-white font-bold rounded-xl hover:bg-[#88b82d] shadow-lg shadow-[#99cc33]/30 transition-all disabled:opacity-70"
            >
              {{ editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!-- Komponen Confirm Modal -->
    <ConfirmModal />

  </div>
</template>

<style scoped>
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
}
.modal-enter-active .transform, .modal-leave-active .transform {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.modal-enter-from .transform, .modal-leave-to .transform {
    transform: scale(0.95) translateY(10px);
}
</style>
