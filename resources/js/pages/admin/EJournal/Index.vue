<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { 
    Plus, Pencil, Trash2, X, Save, UploadCloud, Globe, 
    BookOpen, Filter, Library, Book
} from 'lucide-vue-next';

const props = defineProps({
    journals: Object, // Data dari pagination Laravel
    errors: Object
});

// -- STATE MANAGEMENT --
const showModal = ref(false);
const isEditing = ref(false);
const previewImage = ref(null);
const fileInputRef = ref(null);
const filterType = ref('all'); // State untuk Filter: 'all', 'journal', 'ebook'

// Form Default (Subject diganti Description)
const form = useForm({
    id: null,
    name: '',
    description: '', // Ubah dari subject ke description
    url: '',
    type: 'journal',
    logo: null,
    _method: 'POST' 
});

// -- COMPUTED --
// Filter data yang ada di halaman saat ini (Client-side filter for current page)
const filteredData = computed(() => {
    if (filterType.value === 'all') return props.journals.data;
    return props.journals.data.filter(item => item.type === filterType.value);
});

// -- ACTIONS --

const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    form._method = 'POST';
    previewImage.value = null;
    showModal.value = true;
};

const openEditModal = (item) => {
    isEditing.value = true;
    form.id = item.id;
    form.name = item.name;
    form.description = item.description; // Load description
    form.url = item.url;
    form.type = item.type;
    form.logo = null; 
    form._method = 'PUT'; 
    
    previewImage.value = item.img_url; 
    
    showModal.value = true;
};

const triggerFileInput = () => {
    fileInputRef.value.click();
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const handleDrop = (e) => {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
         fileInputRef.value.files = e.dataTransfer.files; 
         handleFileChange({ target: fileInputRef.value }); 
    }
};

const submit = () => {
    const url = isEditing.value ? `/admin/e-journals/${form.id}` : '/admin/e-journals';
    form.post(url, {
        onSuccess: () => closeModal(),
        preserveScroll: true
    });
};

const deleteItem = (item) => {
    if (confirm('Yakin ingin menghapus ' + item.name + '?')) {
        router.delete(`/admin/e-journals/${item.id}`);
    }
};

const closeModal = () => {
    showModal.value = false;
    setTimeout(() => {
        form.reset();
        form.clearErrors();
        previewImage.value = null;
    }, 300);
};

defineOptions({
    layout: (h, page) => h(AdminLayout, { title: 'Manajemen Referensi', subTitle: 'Kelola E-Journal dan E-Book' }, { default: () => page }),
});
</script>

<template>
    <div class="min-h-screen bg-slate-50/50 p-6 lg:p-8 font-inter relative overflow-hidden">
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-[#99cc33]/10 rounded-full blur-3xl opacity-60 pointer-events-none mix-blend-multiply"></div>
        
        <div class="w-full relative z-10">
            
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-8 gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Database Referensi</h1>
                    <p class="text-slate-500 mt-2 text-lg">Kelola daftar E-Journal dan E-Book perpustakaan.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                    <div class="bg-white p-1 rounded-xl shadow-sm border border-slate-200 flex">
                        <button 
                            @click="filterType = 'all'"
                            class="px-4 py-2 rounded-lg text-sm font-bold transition-all"
                            :class="filterType === 'all' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'"
                        >
                            Semua
                        </button>
                        <button 
                            @click="filterType = 'journal'"
                            class="px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2"
                            :class="filterType === 'journal' ? 'bg-[#99cc33] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'"
                        >
                            <Library class="w-4 h-4" /> E-Journal
                        </button>
                        <button 
                            @click="filterType = 'ebook'"
                            class="px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2"
                            :class="filterType === 'ebook' ? 'bg-blue-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'"
                        >
                            <Book class="w-4 h-4" /> E-Book
                        </button>
                    </div>

                    <button 
                        @click="openCreateModal" 
                        class="group flex items-center justify-center gap-2.5 px-6 py-2.5 bg-[#99cc33] text-white rounded-xl hover:bg-[#8ab82e] transition-all duration-300 shadow-lg shadow-[#99cc33]/20 hover:shadow-xl hover:shadow-[#99cc33]/30 active:scale-95"
                    >
                        <Plus class="w-5 h-5 transition-transform group-hover:rotate-90 stroke-[2.5]" />
                        <span class="font-bold tracking-wide">Tambah Data</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden relative z-20 w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="px-6 py-5 text-slate-500 uppercase text-xs font-bold tracking-widest w-20 text-center">Logo</th>
                                <th class="px-6 py-5 text-slate-500 uppercase text-xs font-bold tracking-widest w-48">Nama & Tipe</th>
                                <th class="px-6 py-5 text-slate-500 uppercase text-xs font-bold tracking-widest">Deskripsi</th>
                                <th class="px-6 py-5 text-slate-500 uppercase text-xs font-bold tracking-widest w-48">URL</th>
                                <th class="px-6 py-5 text-center text-slate-500 uppercase text-xs font-bold tracking-widest w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr v-for="item in filteredData" :key="item.id" class="hover:bg-slate-50/80 transition-colors duration-200 group/row align-top">
                                <td class="px-6 py-5">
                                    <div class="h-12 w-12 mx-auto rounded-xl border border-slate-100 bg-white p-1 flex items-center justify-center overflow-hidden relative">
                                        <img v-if="item.img_url" :src="item.img_url" class="h-full w-full object-contain rounded-lg" alt="Logo" />
                                        <Globe v-else class="w-5 h-5 text-slate-300" />
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-2">
                                        <span class="font-bold text-slate-800 text-base leading-tight">{{ item.name }}</span>
                                        <div>
                                            <span v-if="item.type === 'journal'" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md font-bold text-[10px] uppercase tracking-wider bg-[#99cc33]/10 text-[#7ea82a] border border-[#99cc33]/20">
                                                <Library class="w-3 h-3" /> E-Journal
                                            </span>
                                            <span v-else class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md font-bold text-[10px] uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                                <Book class="w-3 h-3" /> E-Book
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-wrap min-w-[250px]">
                                        {{ item.description }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <a :href="item.url" target="_blank" class="text-sm text-slate-400 hover:text-[#99cc33] hover:underline break-all flex items-center gap-1 transition-colors">
                                        {{ item.url }}
                                    </a>
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="openEditModal(item)" class="p-2 text-slate-400 hover:text-[#99cc33] hover:bg-[#99cc33]/10 rounded-lg transition-all" title="Edit">
                                            <Pencil class="w-4 h-4" />
                                        </button>
                                        <button @click="deleteItem(item)" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus">
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="filteredData.length === 0">
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                            <Filter class="w-8 h-8 text-slate-300" />
                                        </div>
                                        <h3 class="text-slate-500 font-medium">Data tidak ditemukan pada filter ini.</h3>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="journals.links.length > 3" class="px-8 py-6 border-t border-slate-50 bg-white flex justify-between items-center">
                    <p class="text-sm text-slate-500">Total Data: {{ journals.total }}</p>
                    <div class="flex gap-1">
                        <component 
                            :is="link.url ? 'a' : 'span'" 
                            v-for="(link, k) in journals.links" 
                            :key="k" :href="link.url" v-html="link.label"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all"
                            :class="link.active ? 'bg-slate-800 text-white' : 'text-slate-500 hover:bg-slate-100'"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <h3 class="text-xl font-bold text-slate-900">{{ isEditing ? 'Edit Data' : 'Tambah Data Baru' }}</h3>
                        <button @click="closeModal" class="p-2 text-slate-400 hover:bg-slate-100 rounded-full"><X class="w-5 h-5" /></button>
                    </div>

                    <form @submit.prevent="submit" class="p-6 space-y-5">
                        
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">Nama Referensi <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 outline-none" placeholder="Contoh: ScienceDirect" />
                            <p v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Tipe <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer border p-3 rounded-xl flex items-center gap-3 transition-all hover:bg-slate-50" :class="form.type === 'journal' ? 'border-[#99cc33] bg-[#99cc33]/5 ring-1 ring-[#99cc33]' : 'border-slate-200'">
                                    <input type="radio" v-model="form.type" value="journal" class="accent-[#99cc33]" />
                                    <span class="text-sm font-bold" :class="form.type === 'journal' ? 'text-[#99cc33]' : 'text-slate-600'">E-Journal</span>
                                </label>
                                <label class="cursor-pointer border p-3 rounded-xl flex items-center gap-3 transition-all hover:bg-slate-50" :class="form.type === 'ebook' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-200'">
                                    <input type="radio" v-model="form.type" value="ebook" class="accent-blue-500" />
                                    <span class="text-sm font-bold" :class="form.type === 'ebook' ? 'text-blue-600' : 'text-slate-600'">E-Book</span>
                                </label>
                            </div>
                            <p v-if="form.errors.type" class="text-red-500 text-xs">{{ form.errors.type }}</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">Deskripsi / Subjek <span class="text-red-500">*</span></label>
                            <textarea 
                                v-model="form.description" 
                                rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 outline-none resize-none"
                                placeholder="Tuliskan deskripsi lengkap atau daftar subjek..."
                            ></textarea>
                            <p v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">URL Akses <span class="text-red-500">*</span></label>
                            <input v-model="form.url" type="url" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 outline-none" placeholder="https://..." />
                            <p v-if="form.errors.url" class="text-red-500 text-xs">{{ form.errors.url }}</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">Logo (Opsional)</label>
                            <div @click="triggerFileInput" class="border-2 border-dashed border-slate-300 rounded-xl p-4 flex items-center gap-4 cursor-pointer hover:bg-slate-50 hover:border-[#99cc33] transition-all group">
                                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                                    <img v-if="previewImage" :src="previewImage" class="w-full h-full object-contain" />
                                    <UploadCloud v-else class="w-6 h-6 text-slate-400 group-hover:text-[#99cc33]" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Upload Gambar</p>
                                    <p class="text-xs text-slate-500">Klik atau drag file ke sini (Max 2MB)</p>
                                </div>
                                <input ref="fileInputRef" type="file" class="hidden" accept="image/*" @change="handleFileChange" />
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end gap-3">
                            <button type="button" @click="closeModal" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100">Batal</button>
                            <button :disabled="form.processing" type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#99cc33] hover:bg-[#8ebf2f] shadow-lg shadow-[#99cc33]/20 flex items-center gap-2">
                                <Save class="w-4 h-4" /> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </div>
</template>