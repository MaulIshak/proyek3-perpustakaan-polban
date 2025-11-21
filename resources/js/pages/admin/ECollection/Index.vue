<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import PaginationLink from '@/components/admin/PaginationLink.vue';
import { router, useForm, Head } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { 
    FileSearch, Plus, Search, Pencil, Trash2, 
    ExternalLink, X, Save, Image as ImageIcon, 
    Copy 
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps({
    collections: Object,
    searchQuery: String,
});

// --- SEARCH LOGIC ---
const search = ref(props.searchQuery);

watch(
    search,
    debounce((value) => {
        router.get(
            '/admin/e-collections',
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);

// --- MODAL & FORM LOGIC ---
// Ubah nama variabel dari isDrawerOpen jadi isModalOpen biar sesuai konteks
const isModalOpen = ref(false); 
const isEditMode = ref(false);
const imagePreview = ref(null);

const form = useForm({
    id: null,
    title: '',
    url: '',
    description: '',
    is_active: true,
    image: null,
    _method: 'POST',
});

const openCreate = () => {
    isEditMode.value = false;
    form.reset();
    form.clearErrors();
    form._method = 'POST';
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEdit = (item) => {
    isEditMode.value = true;
    form.clearErrors();
    form.id = item.id;
    form.title = item.title;
    form.url = item.url;
    form.description = item.description;
    form.is_active = Boolean(item.is_active);
    form.image = null;
    form._method = 'POST';
    imagePreview.value = item.image_path;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => { form.reset(); imagePreview.value = null; }, 300);
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    const url = isEditMode.value ? `/admin/e-collections/${form.id}` : '/admin/e-collections';
    form.post(url, {
        onSuccess: () => closeModal(),
        preserveScroll: true
    });
};

const handleDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus koleksi ini?')) {
        router.delete(`/admin/e-collections/${id}`);
    }
};

// Helper Copy HTML
const copySnippet = (type) => {
    let text = '';
    if(type === 'blue') text = '<h4 class="text-blue-500 font-bold mb-1 mt-4">Judul Sub-Bab</h4>';
    if(type === 'yellow') text = '<div class="bg-yellow-300 p-3 border border-black text-sm mt-4">Info penting...</div>';
    navigator.clipboard.writeText(text);
};

// Helper Strip HTML untuk Card Preview
const stripHtml = (html) => {
    return html ? html.replace(/<[^>]*>?/gm, '') : '';
}

defineOptions({
    layout: (h, page) => h(AdminLayout, { title: 'E-Collection', subTitle: 'Kelola daftar koleksi digital' }, { default: () => page }),
});
</script>

<template>
    <Head title="E-Collection" />

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="relative flex-1 max-w-md">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" />
            <input 
                v-model="search" 
                type="text" 
                placeholder="Cari koleksi..." 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[var(--primary-green)] focus:ring-1 focus:ring-[var(--primary-green)] outline-none transition-all"
            >
        </div>

        <button 
            @click="openCreate"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[var(--primary-green)] px-5 py-2.5 font-medium text-white transition hover:opacity-90 shadow-sm"
        >
            <Plus class="w-5 h-5" />
            <span>Buat Koleksi Baru</span>
        </button>
    </div>

    <div v-if="collections.data.length > 0" class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div 
            v-for="item in collections.data" 
            :key="item.id" 
            class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden"
        >
            <div class="h-40 bg-gray-50 flex items-center justify-center overflow-hidden relative border-b border-gray-100">
                <img 
                    v-if="item.image_path" 
                    :src="item.image_path" 
                    class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105" 
                />
                <ImageIcon v-else class="w-12 h-12 text-gray-300" />
                <div class="absolute top-3 right-3">
                    <span :class="item.is_active ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-500'" class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                        {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-bold text-gray-800 mb-2 line-clamp-1" :title="item.title">
                    {{ item.title }}
                </h3>
                <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-1 leading-relaxed">
                    {{ stripHtml(item.description) }}
                </p>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                    <a 
                        v-if="item.url" 
                        :href="item.url" 
                        target="_blank" 
                        class="text-xs font-medium text-blue-600 flex items-center gap-1 hover:underline"
                    >
                        <ExternalLink class="w-3 h-3" /> Link
                    </a>
                    <span v-else class="text-xs text-gray-400">-</span>

                    <div class="flex items-center gap-2">
                        <button @click="openEdit(item)" class="p-2 rounded-lg text-amber-600 bg-amber-50 hover:bg-amber-100 transition-colors" title="Edit">
                            <Pencil class="w-4 h-4" />
                        </button>
                        <button @click="handleDelete(item.id)" class="p-2 rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors" title="Hapus">
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-2xl border border-dashed border-gray-200">
        <FileSearch class="mb-4 h-20 w-20 text-gray-300" />
        <h3 class="text-2xl font-semibold text-gray-600">
            {{ search ? 'Koleksi Tidak Ditemukan' : 'Belum Ada Koleksi' }}
        </h3>
        <p class="mt-2 max-w-sm text-gray-500">
            {{ search ? 'Sistem tidak menemukan data yang cocok.' : 'Belum ada data E-Collection. Silakan buat yang baru.' }}
        </p>
        <button v-if="!search" @click="openCreate" class="mt-6 rounded-xl bg-[var(--primary-green)] px-5 py-3 font-medium text-white transition hover:opacity-90">
            Buat Koleksi Baru
        </button>
    </div>

    <div class="mt-6">
        <PaginationLink :links="collections.links" />
    </div>

    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
            
            <div @click="closeModal" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"></div>

            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden z-10">
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ isEditMode ? 'Edit Koleksi' : 'Buat Koleksi Baru' }}
                    </h2>
                    <button @click="closeModal" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-5 bg-gray-50/50">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                            <input v-model="form.title" type="text" class="w-full rounded-lg border-gray-300 focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" placeholder="Nama koleksi...">
                            <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                            <input v-model="form.url" type="url" class="w-full rounded-lg border-gray-300 focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" placeholder="https://...">
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-3">Gambar / Logo</label>
                        <div class="flex items-center gap-4">
                            <div class="shrink-0 w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border border-dashed border-gray-300">
                                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-contain" />
                                <ImageIcon v-else class="w-8 h-8 text-gray-300" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="file" @change="handleImageUpload" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-all"/>
                                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Max 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <div class="flex gap-2">
                                <button type="button" @click="copySnippet('blue')" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded hover:bg-blue-100 font-semibold">Blue Header</button>
                                <button type="button" @click="copySnippet('yellow')" class="text-[10px] bg-yellow-50 text-yellow-600 px-2 py-1 rounded hover:bg-yellow-100 font-semibold">Yellow Box</button>
                            </div>
                        </div>
                        <textarea v-model="form.description" rows="5" class="w-full rounded-lg border-gray-300 focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)] font-mono text-xs" placeholder="Isi deskripsi atau HTML..."></textarea>
                        
                        <div class="mt-2 p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Live Preview</p>
                            <div class="rich-text-content text-xs" v-html="form.description || '<span class=\'text-gray-300 italic\'>Preview...</span>'"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-gray-200">
                        <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--primary-green)]"></div>
                        </label>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 bg-white flex items-center justify-end gap-3">
                    <button @click="closeModal" class="px-5 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 font-medium text-sm transition-colors">Batal</button>
                    <button @click="submit" :disabled="form.processing" class="px-6 py-2.5 rounded-xl bg-[var(--primary-green)] text-white font-bold text-sm hover:opacity-90 flex items-center gap-2 disabled:opacity-70 transition-opacity shadow-lg shadow-green-900/10">
                        <Save class="w-4 h-4" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style>
/* CSS untuk Preview HTML (Sama seperti sebelumnya) */
.rich-text-content h4 { color: #3b82f6; font-weight: 700; margin-top: 8px; margin-bottom: 4px; }
.rich-text-content p { margin-bottom: 6px; }
.rich-text-content .warning-box, 
.rich-text-content div[class*="bg-yellow"] {
    background-color: #fef9c3; border: 1px solid #fde047; color: #854d0e; padding: 8px; border-radius: 6px; margin-top: 8px;
}
</style>