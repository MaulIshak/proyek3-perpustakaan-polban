<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    Trash2,
    Edit,
    Plus,
    Save,
    UploadCloud,
    FileText,
    Image as ImageIcon,
    GitGraph,
    CheckSquare,
    BookOpen,
    ShieldCheck,
    Download,
    X
} from 'lucide-vue-next';
import { useConfirmModal } from '@/composables/userConfirmModal';

// Layout Setup
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Manajemen Bebas Masalah',
                subTitle: 'Atur konten, persyaratan, dan panduan halaman bebas masalah',
            },
            { default: () => page },
        ),
});

// Props
const props = defineProps<{
    settings: any;
    requirements: any[];
    guides: any[];
}>();

// State
const activeTab = ref('alur');
const { open } = useConfirmModal();

// Tabs Configuration
const tabs = [
    { id: 'alur', label: 'Diagram Alur', icon: GitGraph },
    { id: 'persyaratan', label: 'Persyaratan', icon: CheckSquare },
    { id: 'panduan', label: 'Panduan', icon: BookOpen },
    { id: 'template', label: 'Template Surat', icon: FileText },
    { id: 'watermark', label: 'Watermark', icon: ShieldCheck },
];

// --- FORM SETTINGS (Single Endpoint Update) ---
const formSettings = useForm({
    _method: 'POST', // Trick for Laravel file upload on update
    alur_description: props.settings?.alur_description || '',
    alur_image: null as File | null,

    template_title: props.settings?.template_title || '',
    template_info: props.settings?.template_info || '',
    template_instruction: props.settings?.template_instruction || '',
    template_file: null as File | null,

    watermark_title: props.settings?.watermark_title || '',
    watermark_info: props.settings?.watermark_info || '',
    watermark_instruction: props.settings?.watermark_instruction || '',
    watermark_image: null as File | null,   
});

const submitSettings = () => {
    formSettings.post('/admin/bebas-masalah/settings', {
        preserveScroll: true,
        onSuccess: () => {
            formSettings.reset('alur_image', 'template_file', 'watermark_image');
            // Optional: Show toast
        },
    });
};

// --- CRUD LIST (Requirements & Guides) ---
const showModal = ref(false);
const modalMode = ref<'create' | 'edit'>('create');
const modalType = ref<'requirement' | 'guide'>('requirement');
const editingId = ref<number | null>(null);

const formList = useForm({
    title: '',
    description: '',
    sort_order: 0,
});

const openModal = (type: 'requirement' | 'guide', mode: 'create' | 'edit', item: any = null) => {
    modalType.value = type;
    modalMode.value = mode;
    showModal.value = true;

    if (mode === 'edit' && item) {
        editingId.value = item.id;
        formList.title = item.title;
        formList.description = item.description;
        formList.sort_order = item.sort_order;
    } else {
        formList.reset();
        // Auto increment sort order suggestion
        const list = type === 'requirement' ? props.requirements : props.guides;
        formList.sort_order = list.length + 1;
    }
};

const submitList = () => {
    const resource = modalType.value === 'requirement' ? 'requirements' : 'guides';
    const url = modalMode.value === 'create'
        ? `/admin/bebas-masalah/${resource}`
        : `/admin/bebas-masalah/${resource}/${editingId.value}`;

    const options = {
        onSuccess: () => { showModal.value = false; formList.reset(); },
        preserveScroll: true
    };

    if (modalMode.value === 'create') {
        formList.post(url, options);
    } else {
        formList.put(url, options);
    }
};

const handleDelete = (type: 'requirement' | 'guide', item: any) => {
    open({
        title: 'Hapus Data?',
        message: `Apakah Anda yakin ingin menghapus data "${item.title}"?`,
        actionLabel: 'Hapus',
        onConfirm: () => {
            const resource = type === 'requirement' ? 'requirements' : 'guides';
            router.delete(`/admin/bebas-masalah/${resource}/${item.id}`, {
                preserveScroll: true
            });
        },
    });
};

// File Input Helper
const handleFileChange = (field: 'alur_image' | 'template_file' | 'watermark_image', event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) formSettings[field] = file;
};

</script>

<template>
    <div class="space-y-8 font-sans text-slate-600">

        <!-- 1. Tabs Navigation -->
        <div class="flex flex-wrap gap-2 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm w-fit">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                @click="activeTab = tab.id"
                class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl transition-all duration-300"
                :class="activeTab === tab.id
                    ? 'bg-[#99cc33] text-white shadow-md transform scale-105'
                    : 'text-slate-500 hover:bg-slate-50 hover:text-[#99cc33]'"
            >
                <component :is="tab.icon" class="w-4 h-4" />
                {{ tab.label }}
            </button>
        </div>

        <!-- 2. Content Area -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-lg shadow-slate-200/50 p-6 sm:p-8 min-h-[500px] relative overflow-hidden">

            <!-- Decorative Blob -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#99cc33]/5 rounded-full blur-3xl pointer-events-none"></div>

            <transition name="fade" mode="out-in">

                <!-- TAB: ALUR -->
                <div v-if="activeTab === 'alur'" key="alur" class="relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        <!-- Form -->
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-4">
                                <GitGraph class="w-5 h-5 text-[#99cc33]" />
                                Edit Konten Alur
                            </h3>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Alur</label>
                                <textarea
                                    v-model="formSettings.alur_description"
                                    rows="6"
                                    class="w-full rounded-xl border-[#d0f18e] bg-slate-50 ring-1 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33] transition-all text-slate-700 placeholder:text-slate-400 resize-none p-4"
                                    placeholder="Jelaskan alur proses bebas masalah..."
                                ></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Upload Gambar Diagram</label>
                                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-[#99cc33]/5 hover:border-[#99cc33] transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-slate-400 group-hover:text-[#99cc33] transition-colors">
                                        <UploadCloud class="w-10 h-10 mb-3" />
                                        <p class="text-sm font-medium"><span class="font-bold">Klik untuk upload</span> gambar baru</p>
                                        <p class="text-xs opacity-70 mt-1">PNG, JPG (Max 2MB)</p>
                                    </div>
                                    <input type="file" class="hidden" accept="image/*" @change="handleFileChange('alur_image', $event)" />
                                </label>
                                <p v-if="formSettings.alur_image" class="mt-2 text-sm text-[#99cc33] font-bold flex items-center gap-1">
                                    <CheckSquare class="w-4 h-4"/> File terpilih: {{ formSettings.alur_image.name }}
                                </p>
                            </div>

                            <button @click="submitSettings" :disabled="formSettings.processing" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#99cc33] hover:bg-[#88b82d] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-[#99cc33]/30 hover:shadow-[#99cc33]/50 transition-all active:scale-95">
                                <Save class="w-4 h-4"/> Simpan Perubahan
                            </button>
                        </div>

                        <!-- Preview -->
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 h-full min-h-[300px] flex flex-col">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Preview Gambar Saat Ini</p>
                            <div class="flex-1 flex items-center justify-center overflow-hidden rounded-xl bg-white shadow-sm border border-slate-100 p-2">
                                <img
                                    v-if="settings?.alur_image_path"
                                    :src="settings.alur_image_path"
                                    class="max-w-full max-h-[400px] object-contain"
                                    alt="Alur Preview"
                                />
                                <div v-else class="flex flex-col items-center text-slate-300">
                                    <ImageIcon class="w-12 h-12 mb-2" />
                                    <span class="text-sm">Belum ada gambar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: LIST (Requirements & Guides) -->
                <div v-else-if="activeTab === 'persyaratan' || activeTab === 'panduan'" key="list" class="relative z-10">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">
                                List {{ activeTab === 'persyaratan' ? 'Persyaratan' : 'Panduan' }}
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">Kelola daftar poin yang tampil di halaman user</p>
                        </div>
                        <button @click="openModal(activeTab === 'persyaratan' ? 'requirement' : 'guide', 'create')" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg transition-all hover:-translate-y-0.5">
                            <Plus class="w-5 h-5"/> Tambah Data
                        </button>
                    </div>

                    <!-- Table List -->
                    <div class="overflow-hidden rounded-xl border border-slate-200 shadow-sm bg-white">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr
                                    v-for="item in (activeTab === 'persyaratan' ? requirements : guides)"
                                    :key="item.id"
                                    class="hover:bg-slate-50/80 transition-colors group"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#99cc33]">{{ item.sort_order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700">{{ item.title }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500 max-w-md truncate">{{ item.description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button @click="openModal(activeTab === 'persyaratan' ? 'requirement' : 'guide', 'edit', item)" class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors">
                                            <Edit class="w-4 h-4"/>
                                        </button>
                                        <button @click="handleDelete(activeTab === 'persyaratan' ? 'requirement' : 'guide', item)" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                                            <Trash2 class="w-4 h-4"/>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="(activeTab === 'persyaratan' ? requirements : guides).length === 0">
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 flex flex-col items-center">
                                        <FileText class="w-10 h-10 mb-2 opacity-20" />
                                        <span class="text-sm italic">Belum ada data yang tersedia.</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB: FILE SETTINGS (Template/Watermark) -->
                <div v-else key="file-settings" class="max-w-4xl mx-auto relative z-10">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="p-4 bg-[#99cc33]/10 rounded-2xl text-[#99cc33]">
                            <component :is="activeTab === 'template' ? FileText : ShieldCheck" class="w-8 h-8" />
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800">Pengaturan {{ activeTab === 'template' ? 'Template Dokumen' : 'Watermark' }}</h3>
                            <p class="text-sm text-slate-500">Sesuaikan file aset yang dapat diunduh oleh mahasiswa</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Display</label>
                                <input type="text" v-model="formSettings[activeTab + '_title']" class="w-full px-4 py-3 rounded-xl border border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all outline-none text-slate-700 placeholder:text-slate-400 font-medium" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Info File (Size/Format)</label>
                                <input type="text" v-model="formSettings[activeTab + '_info']" class="w-full px-4 py-3 rounded-xl border border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all outline-none text-slate-700 placeholder:text-slate-400 font-medium" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Instruksi Penggunaan</label>
                            <textarea v-model="formSettings[activeTab + '_instruction']" rows="5" class="w-full px-4 rounded-xl border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all resize-none"></textarea>
                        </div>

                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center gap-6">
                            <!-- File Preview -->
                            <div class="shrink-0">
                                <div v-if="activeTab === 'watermark' && settings?.watermark_image_path" class="h-24 w-24 bg-slate-100 rounded-xl flex items-center justify-center p-2 border border-slate-200">
                                    <img :src="settings.watermark_image_path" class="max-h-full max-w-full object-contain" alt="Preview" />
                                </div>
                                <div v-else class="h-24 w-24 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 border border-slate-200">
                                    <FileText class="w-10 h-10" />
                                </div>
                            </div>

                            <div class="flex-1 w-full">
                                 <div class="flex justify-between items-center mb-2">
                                     <label class="text-sm font-bold text-slate-700">Upload File Baru</label>
                                     <a v-if="settings?.[activeTab + (activeTab === 'template' ? '_file_path' : '_image_path')]"
                                        :href="settings?.[activeTab + (activeTab === 'template' ? '_file_path' : '_image_path')]"
                                        target="_blank"
                                        class="text-xs font-bold text-[#99cc33] hover:underline flex items-center gap-1">
                                        <Download class="w-3 h-3" /> Download File Saat Ini
                                     </a>
                                 </div>
                                 <input
                                    type="file"
                                    @change="handleFileChange(
                                        activeTab === 'template' ? 'template_file' : 
                                        activeTab === 'watermark' ? 'watermark_image' : 'alur_image', 
                                        $event
                                    )"
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-bold
                                    file:bg-[#99cc33]/10 file:text-[#99cc33]
                                    hover:file:bg-[#99cc33]/20 transition-all cursor-pointer"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-200">
                            <button @click="submitSettings" :disabled="formSettings.processing" class="flex items-center gap-2 bg-[#99cc33] hover:bg-[#88b82d] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-[#99cc33]/30 transition-all active:scale-95">
                                <Save class="w-4 h-4"/> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>

            </transition>
        </div>
    </div>

    <!-- Modal CRUD -->
    <transition name="modal">
        <div v-if="showModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 overflow-hidden transform transition-all">
                <!-- Modal Header -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ modalMode === 'create' ? 'Tambah' : 'Edit' }}
                        <span class="text-[#99cc33]">{{ modalType === 'requirement' ? 'Persyaratan' : 'Panduan' }}</span>
                    </h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors bg-white p-1 rounded-full hover:bg-slate-200 shadow-sm">
                        <X class="w-5 h-5"/>
                    </button>
                </div>

                <!-- Modal Form -->
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Urut</label>
                        <input type="number" v-model="formList.sort_order" class="w-full rounded-xl border-slate-200 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul</label>
                        <input type="text" v-model="formList.title" class="w-full rounded-xl border-slate-200 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all" placeholder="Contoh: Upload Dokumen"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea v-model="formList.description" rows="4" class="w-full rounded-xl border-slate-200 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all resize-none" placeholder="Penjelasan detail..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
                    <button @click="showModal = false" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors shadow-sm">Batal</button>
                    <button @click="submitList" :disabled="formList.processing" class="px-6 py-2.5 bg-[#99cc33] text-white font-bold rounded-xl hover:bg-[#88b82d] shadow-lg shadow-[#99cc33]/30 transition-all">Simpan</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
/* Simple fade transition for tabs */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.modal-enter-active .transform,
.modal-leave-active .transform {
    transition: transform 0.3s ease;
}
.modal-enter-from .transform,
.modal-leave-to .transform {
    transform: scale(0.95);
}
</style>
