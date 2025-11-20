<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Trash2, Edit, Plus, Save, UploadCloud, FileText, Image as ImageIcon } from 'lucide-vue-next';

// Layout Setup
defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Manajemen Bebas Masalah',
                subTitle: 'Atur konten halaman bebas masalah perpustakaan',
            },
            { default: () => page },
        ),
});

// Props dari Controller
const props = defineProps({
    settings: Object,
    requirements: Array,
    guides: Array,
});

const activeTab = ref('alur');

// --- FORM SETTINGS ---
const formSettings = useForm({
    _method: 'POST',
    alur_description: props.settings?.alur_description || '',
    alur_image: null,
    template_title: props.settings?.template_title || '',
    template_info: props.settings?.template_info || '',
    template_instruction: props.settings?.template_instruction || '',
    template_file: null,
    watermark_title: props.settings?.watermark_title || '',
    watermark_info: props.settings?.watermark_info || '',
    watermark_instruction: props.settings?.watermark_instruction || '',
    watermark_image: null,
});

const submitSettings = () => {
    // UBAH DISINI: Menggunakan URL Manual
    formSettings.post('/admin/bebas-masalah/settings', {
        preserveScroll: true,
        onSuccess: () => formSettings.reset('alur_image', 'template_file', 'watermark_image'),
    });
};

// --- LOGIC CRUD ---
const showModal = ref(false);
const modalMode = ref('create');
const modalType = ref('requirement');
const editingId = ref(null);

const formList = useForm({
    title: '',
    description: '',
    sort_order: 0,
});

const openModal = (type, mode, item = null) => {
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
        formList.sort_order = type === 'requirement' ? props.requirements.length + 1 : props.guides.length + 1;
    }
};

const submitList = () => {
    let url = '';
    
    // UBAH DISINI: Logic URL Manual
    if (modalType.value === 'requirement') {
        // URL untuk Requirement
        if (modalMode.value === 'create') {
            url = '/admin/bebas-masalah/requirements';
        } else {
            url = `/admin/bebas-masalah/requirements/${editingId.value}`;
        }
    } else {
        // URL untuk Guide
        if (modalMode.value === 'create') {
            url = '/admin/bebas-masalah/guides';
        } else {
            url = `/admin/bebas-masalah/guides/${editingId.value}`;
        }
    }

    const options = { onSuccess: () => showModal.value = false };
    
    // Kirim request (POST untuk create, PUT untuk update)
    modalMode.value === 'create' ? formList.post(url, options) : formList.put(url, options);
};

const deleteItem = (type, id) => {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    
    // UBAH DISINI: URL Manual Delete
    const url = type === 'requirement' 
        ? `/admin/bebas-masalah/requirements/${id}`
        : `/admin/bebas-masalah/guides/${id}`;
        
    formList.delete(url);
};
</script>

<template>
    <div class="bg-[#f3fff3] min-h-[80vh] rounded-xl shadow-sm border border-[#99cc33]/30 p-6">
        
        <div class="flex flex-wrap gap-2 mb-8 p-1 bg-white rounded-lg border border-[#99cc33]/20 w-fit shadow-sm">
            <button
                v-for="tab in ['alur', 'persyaratan', 'panduan', 'template', 'watermark']"
                :key="tab"
                class="px-5 py-2.5 text-sm font-semibold rounded-md transition-all duration-300 flex items-center gap-2"
                :class="activeTab === tab 
                    ? 'bg-[#00637b] text-white shadow-md transform scale-105' 
                    : 'text-[#0f3800] hover:bg-[#f3fff3] hover:text-[#00637b]'"
                @click="activeTab = tab"
            >
                {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-[#99cc33]/20 p-6 lg:p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#f3fff3] rounded-full -mr-16 -mt-16 opacity-50 pointer-events-none"></div>

            <div v-if="activeTab === 'alur'" class="space-y-6 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="space-y-5">
                        <h3 class="text-xl font-bold text-[#0f3800] flex items-center gap-2">
                            <Edit class="w-5 h-5 text-[#99cc33]" /> Edit Konten Alur
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-semibold text-[#00637b] mb-1">Deskripsi Alur</label>
                            <textarea 
                                v-model="formSettings.alur_description" 
                                rows="4" 
                                class="w-full rounded-lg border border-[#99cc33] focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/50 focus:outline-none transition-all duration-200 bg-[#f3fff3]/30 text-gray-700 placeholder-gray-400"
                                placeholder="Masukkan deskripsi alur..."
                            ></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-[#00637b] mb-1">Upload Gambar Baru</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="alur-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#99cc33] border-dashed rounded-lg cursor-pointer bg-[#f3fff3] hover:bg-[#e6ffe6] transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <UploadCloud class="w-8 h-8 text-[#00637b] mb-2" />
                                        <p class="text-sm text-[#0f3800]"><span class="font-semibold">Klik untuk upload</span> gambar alur</p>
                                    </div>
                                    <input id="alur-upload" type="file" class="hidden" @input="formSettings.alur_image = $event.target.files[0]" />
                                </label>
                            </div>
                            <p v-if="formSettings.alur_image" class="mt-2 text-sm text-[#00637b] font-medium">
                                File terpilih: {{ formSettings.alur_image.name }}
                            </p>
                        </div>

                        <button @click="submitSettings" :disabled="formSettings.processing" class="flex items-center justify-center w-full sm:w-auto bg-[#00637b] hover:bg-[#0f3800] text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                            <Save class="w-4 h-4 mr-2"/> Simpan Perubahan
                        </button>
                    </div>

                    <div class="flex flex-col gap-2">
                         <p class="text-sm font-semibold text-[#00637b]">Preview Saat Ini:</p>
                         <div class="border-4 border-[#f3fff3] rounded-xl shadow-inner bg-gray-50 p-2 h-full flex items-center justify-center overflow-hidden relative">
                            <img :src="settings?.alur_image_path" class="max-w-full rounded-lg shadow-md object-contain" alt="Current Alur" />
                            <div class="absolute inset-0 border-2 border-[#99cc33]/30 rounded-xl pointer-events-none"></div>
                         </div>
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'persyaratan' || activeTab === 'panduan'" class="relative z-10">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-[#0f3800]">
                            List {{ activeTab === 'persyaratan' ? 'Persyaratan' : 'Panduan' }}
                        </h3>
                        <p class="text-sm text-gray-500">Kelola daftar data yang tampil di halaman user</p>
                    </div>
                    <button @click="openModal(activeTab === 'persyaratan' ? 'requirement' : 'guide', 'create')" class="bg-[#99cc33] hover:bg-[#88b82b] text-[#0f3800] px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center font-bold">
                        <Plus class="w-5 h-5 mr-2"/> Tambah Data
                    </button>
                </div>

                <div class="overflow-hidden rounded-xl border border-[#99cc33]/30 shadow-sm">
                    <table class="min-w-full divide-y divide-[#f3fff3]">
                        <thead class="bg-[#00637b]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <tr v-for="item in (activeTab === 'persyaratan' ? requirements : guides)" :key="item.id" class="hover:bg-[#f3fff3] transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#00637b]">{{ item.sort_order }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#0f3800]">{{ item.title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-md truncate">{{ item.description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <button @click="openModal(activeTab === 'persyaratan' ? 'requirement' : 'guide', 'edit', item)" class="p-2 bg-[#f3fff3] text-[#00637b] rounded-full hover:bg-[#00637b] hover:text-white transition"><Edit class="w-4 h-4"/></button>
                                    <button @click="deleteItem(activeTab === 'persyaratan' ? 'requirement' : 'guide', item.id)" class="p-2 bg-red-50 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition"><Trash2 class="w-4 h-4"/></button>
                                </td>
                            </tr>
                            <tr v-if="(activeTab === 'persyaratan' ? requirements : guides).length === 0">
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic bg-[#f3fff3]/50">
                                    Belum ada data yang tersedia.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="activeTab === 'template' || activeTab === 'watermark'" class="max-w-4xl mx-auto relative z-10">
                <div class="flex items-center gap-4 mb-6 border-b border-[#99cc33]/30 pb-4">
                    <div class="p-3 bg-[#f3fff3] rounded-lg border border-[#99cc33]">
                        <FileText v-if="activeTab === 'template'" class="w-8 h-8 text-[#00637b]" />
                        <ImageIcon v-else class="w-8 h-8 text-[#00637b]" />
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#0f3800]">Pengaturan {{ activeTab === 'template' ? 'Template Dokumen' : 'Watermark' }}</h3>
                        <p class="text-sm text-gray-500">Sesuaikan file yang akan diunduh oleh mahasiswa</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 bg-[#f3fff3]/30 p-6 rounded-xl border border-[#99cc33]/20">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#00637b] mb-1">Judul {{ activeTab === 'template' ? 'Dokumen' : 'Watermark' }}</label>
                            <input type="text" v-model="formSettings[activeTab + '_title']" class="w-full h-8 rounded-lg border border-[#99cc33] focus:ring-2 focus:outline-none focus:ring-[#99cc33]" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#00637b] mb-1">Info File</label>
                            <input type="text" v-model="formSettings[activeTab + '_info']" class="w-full h-8 rounded-lg border border-[#99cc33] focus:ring-2 focus:outline-none focus:ring-[#99cc33]" />
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#00637b] mb-1">Instruksi</label>
                        <textarea v-model="formSettings[activeTab + '_instruction']" rows="3" class="w-full rounded-lg border border-[#99cc33] focus:ring-2 focus:outline-none focus:ring-[#99cc33]"></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-start mt-2 bg-white p-4 rounded-lg border border-[#99cc33]/30 shadow-sm">
                        <div v-if="activeTab === 'watermark'" class="bg-[#f3fff3] p-2 rounded border border-gray-200 h-24 w-24 flex items-center justify-center flex-shrink-0">
                            <img :src="settings?.watermark_image_path" class="max-h-full max-w-full" alt="Preview" />
                        </div>
                        <div v-else class="h-24 w-24 flex items-center justify-center bg-[#f3fff3] rounded text-[#99cc33] flex-shrink-0">
                            <FileText class="w-10 h-10" />
                        </div>

                        <div class="flex-1 w-full">
                             <div class="flex justify-between items-start">
                                 <label class="block text-sm font-bold text-[#0f3800] mb-1">Ganti File</label>
                                 <a :href="settings?.[activeTab + (activeTab === 'template' ? '_file_path' : '_image_path')]" target="_blank" class="text-xs text-[#00637b] hover:text-[#99cc33] underline font-semibold">Lihat File Saat Ini</a>
                             </div>
                             <input type="file" @input="formSettings[activeTab + (activeTab === 'template' ? '_file' : '_image')] = $event.target.files[0]" 
                                class="mt-1 block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-[#f3fff3] file:text-[#00637b]
                                hover:file:bg-[#e6ffe6] transition"/>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button @click="submitSettings" :disabled="formSettings.processing" class="flex items-center bg-[#00637b] hover:bg-[#0f3800] text-white px-6 py-3 rounded-lg transition shadow-lg hover:shadow-xl font-medium">
                            <Save class="w-4 h-4 mr-2"/> Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <Teleport to="body">
        <div v-if="showModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-[#0f3800]/50 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>
            
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all scale-100 relative z-10 border-t-4 border-[#99cc33]">
                <div class="bg-[#f3fff3] px-6 py-4 border-b border-[#99cc33]/20 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#0f3800]">
                        {{ modalMode === 'create' ? 'Tambah' : 'Edit' }} 
                        <span class="text-[#00637b]">{{ modalType === 'requirement' ? 'Persyaratan' : 'Panduan' }}</span>
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-[#00637b]"><Trash2 class="w-5 h-5 rotate-45"/></button>
                </div>
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-[#00637b]">Nomor Urut</label>
                        <input type="number" v-model="formList.sort_order" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#99cc33] focus:ring-[#99cc33] bg-[#f3fff3]/30"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#00637b]">Judul</label>
                        <input type="text" v-model="formList.title" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#99cc33] focus:ring-[#99cc33] bg-[#f3fff3]/30"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#00637b]">Deskripsi</label>
                        <textarea v-model="formList.description" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#99cc33] focus:ring-[#99cc33] bg-[#f3fff3]/30"></textarea>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
                    <button @click="showModal = false" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</button>
                    <button @click="submitList" :disabled="formList.processing" class="px-5 py-2 bg-[#00637b] text-white rounded-lg hover:bg-[#0f3800] font-medium shadow-md transition">Simpan Data</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>