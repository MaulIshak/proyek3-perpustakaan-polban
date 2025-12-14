<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import {
  UploadCloud, Trash2, Edit, Plus, X, Image as ImageIcon,
  FileImage, Save, RotateCcw, AlertCircle, Search, ChevronLeft, ChevronRight,
  Filter
} from 'lucide-vue-next';

// Import ConfirmModal dan Composables
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

// Layout Definition
defineOptions({
  layout: (h, page) =>
    h(
      AdminLayout,
      {
        title: 'Kelola Galeri',
        subTitle: 'Manajemen dokumentasi foto dan koleksi visual perpustakaan'
      },
      { default: () => page }
    ),
});

// Props (Menerima pagination object & filters)
const props = defineProps({
  photos: Object, // Struktur: { data: [], links: [], ... }
  filters: Object, // State filter dari server
});

const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// State
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editItem = ref(null);
const previewImage = ref(null);
const fileInputRef = ref(null);

// State Filter (Server Side)
const search = ref(props.filters?.q || '');
const typeFilter = ref(props.filters?.tipe || ''); // '' = Semua

// Use Confirm Modal
const { open } = useConfirmModal();

// Watcher untuk Search & Filter
watch(
    [search, typeFilter],
    debounce(([newSearch, newType]) => {
        router.get('/admin/galeri', {
            q: newSearch,
            tipe: newType
        }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300)
);

// Forms
const createForm = useForm({
    foto: null,
    tipe: 'galeri' // Default
});

const editForm = useForm({
    foto: null,
    tipe: 'galeri',
    _method: 'put'
});

// Helper: Handle File Change & Preview
const handleFileChange = (e, formType) => {
  const target = e.target;
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

function openEdit(photo) {
  editItem.value = photo;
  editForm.reset();
  editForm.tipe = photo.tipe || 'galeri';
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

function remove(photo) {
  open({
      title: 'Hapus Foto Galeri?',
      message: 'Apakah Anda yakin ingin menghapus foto ini secara permanen? Tindakan ini tidak dapat dibatalkan.',
      actionLabel: 'Hapus',
      onConfirm: () => {
          router.delete(`/admin/galeri/${photo.foto_id}`, {
              preserveScroll: true
          });
      },
  });
}

// Helper Label Pagination
const getLabel = (label) => {
    if (label.includes('Previous')) return 'Prev';
    if (label.includes('Next')) return 'Next';
    return label;
};
</script>

<template>
  <div class="space-y-8 font-sans">
            <div
            class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row"
        >
            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-[#99cc33]/10 p-2 text-[#99cc33]">
                    <ImageIcon class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Daftar Gambar
                    </h2>
                    <p class="text-xs font-medium text-slate-500">
                        Total {{ props.photos.total }} item
                    </p>
                </div>
            </div>

            <button
                @click="openCreate"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                Upload Foto
            </button>
        </div>
    <div v-if="props.photos.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div
        v-for="item in props.photos.data"
        :key="item?.foto_id"
        class="group relative bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#99cc33]/50 transition-all duration-300 overflow-hidden flex flex-col"
      >
        <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
          <img
            :src="item.url_foto"
            alt="Gallery Item"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
          />

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

        <div class="p-3 bg-white border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-400 font-medium">{{ item.size || '0' }} KB</span>
        </div>
      </div>
    </div>

    <div v-else class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl border border-dashed border-slate-200 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
            <Search class="w-10 h-10 text-slate-300" />
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ditemukan</h3>
        <p class="text-slate-500 text-sm max-w-md leading-relaxed">
            Tidak ada foto yang cocok dengan pencarian atau filter Anda.
        </p>
        <button
            @click="search = ''; typeFilter = ''"
            class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
        >
            Reset Filter
        </button>
    </div>

    <div v-if="props.photos.data.length > 0" class="flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-6 sm:flex-row">
        <p class="text-sm text-slate-500">
            Menampilkan <span class="font-bold text-slate-700">{{ props.photos.from }}</span> - <span class="font-bold text-slate-700">{{ props.photos.to }}</span> dari <span class="font-bold text-slate-700">{{ props.photos.total }}</span> foto
        </p>

        <div class="flex items-center gap-1">
            <template v-for="(link, k) in props.photos.links" :key="k">
                <div v-if="link.url === null"
                        class="flex h-9 min-w-[36px] items-center justify-center rounded-lg border border-transparent px-3 text-sm text-slate-300"
                        v-html="getLabel(link.label)">
                </div>

                <component
                    :is="link.url ? 'button' : 'span'"
                    v-else
                    @click="link.url && router.get(link.url, {}, { preserveState: true, preserveScroll: true })"
                    class="flex h-9 min-w-[36px] items-center justify-center rounded-lg px-3 text-sm font-bold transition-all border"
                    :class="link.active
                        ? 'bg-[#99cc33] text-white border-[#99cc33] shadow-md shadow-[#99cc33]/20'
                        : 'bg-white text-slate-600 border-slate-200 hover:border-[#99cc33] hover:text-[#99cc33]'"
                >
                    <span v-if="link.label.includes('Previous')"><ChevronLeft class="h-4 w-4" /></span>
                    <span v-else-if="link.label.includes('Next')"><ChevronRight class="h-4 w-4" /></span>
                    <span v-else v-html="link.label"></span>
                </component>
            </template>
        </div>
    </div>
<Teleport to="body">
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

            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">File Foto</label>
                <div
                    @click="triggerFileInput"
                    class="group relative w-full h-56 border-2 border-dashed rounded-2xl cursor-pointer transition-all flex flex-col items-center justify-center text-center overflow-hidden bg-slate-50"
                    :class="[
                        createForm.errors.foto ? 'border-red-300 bg-red-50' : 'border-slate-300 hover:border-[#99cc33] hover:bg-[#99cc33]/5',
                        previewImage ? 'border-solid' : ''
                    ]"
                >
                    <template v-if="previewImage">
                        <img :src="previewImage" class="w-full h-full object-contain p-2" />
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white backdrop-blur-[1px]">
                            <RotateCcw class="w-8 h-8 mb-2" />
                            <span class="text-sm font-bold">Klik untuk ganti foto</span>
                        </div>
                    </template>

                    <div v-else class="flex flex-col items-center justify-center p-6 transition-transform duration-300 group-hover:scale-105">
                        <div class="p-4 bg-white rounded-full shadow-sm mb-3 group-hover:shadow-md">
                            <UploadCloud class="w-8 h-8 text-[#99cc33]" />
                        </div>
                        <p class="text-sm font-bold text-slate-700 group-hover:text-[#99cc33] transition-colors">
                            Klik untuk pilih foto
                        </p>
                        <p class="text-xs mt-1 text-slate-400 font-medium">JPG, PNG (Maks. 5MB)</p>
                    </div>

                    <input
                        ref="fileInputRef"
                        type="file"
                        @change="(e) => handleFileChange(e, 'create')"
                        class="hidden"
                        accept="image/*"
                    />
                </div>
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
    </Teleport>

    <Teleport to="body">
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

                    <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer text-white">
                        <RotateCcw class="w-8 h-8 mb-2" />
                        <span class="text-sm font-bold">Ganti Gambar</span>
                        <input type="file" @change="(e) => handleFileChange(e, 'edit')" class="hidden" accept="image/*" />
                    </label>
                </div>
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
</Teleport>
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
