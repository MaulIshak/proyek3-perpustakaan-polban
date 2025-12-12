<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import {
    Book,
    Filter,
    Globe,
    Library,
    Pencil,
    Plus,
    Save,
    Trash2,
    UploadCloud,
    X,
    MinusCircle, 
    Link as LinkIcon 
} from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps({
    journals: Object, 
    errors: Object,
});

// -- STATE MANAGEMENT --
const showModal = ref(false);
const isEditing = ref(false);
const previewImage = ref(null);
const fileInputRef = ref(null);
const filterType = ref('all'); 

// Form Default
const form = useForm({
    id: null,
    name: '',
    description: '', 
    url: '', // URL UTAMA (Tombol "Buka Referensi")
    
    // [UPDATE] Link Tambahan (Array of Objects)
    additional_links: [], 
    
    type: 'journal',
    logo: null,
    _method: 'POST',
});

// -- HELPER ACTION UNTUK LINK TAMBAHAN --
const addLinkRow = () => {
    form.additional_links.push({ label: '', url: '' });
};

const removeLinkRow = (index) => {
    form.additional_links.splice(index, 1);
};

// -- COMPUTED --
const filteredData = computed(() => {
    if (filterType.value === 'all') return props.journals.data;
    return props.journals.data.filter((item) => item.type === filterType.value);
});

// -- ACTIONS --
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    form.additional_links = []; // Reset jadi array kosong
    form._method = 'POST';
    previewImage.value = null;
    showModal.value = true;
};

const openEditModal = (item) => {
    isEditing.value = true;
    form.id = item.id;
    form.name = item.name;
    form.description = item.description; 
    form.url = item.url;
    
    // [UPDATE] Load links dari DB. Pastikan formatnya Array.
    // Kita pakai JSON parse/stringify untuk deep copy agar tidak reaktif langsung ke tampilan tabel sebelum disave
    form.additional_links = Array.isArray(item.additional_links) 
        ? JSON.parse(JSON.stringify(item.additional_links)) 
        : [];

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

const submit = () => {
    const url = isEditing.value
        ? `/admin/e-journals/${form.id}`
        : '/admin/e-journals';
    form.post(url, {
        onSuccess: () => closeModal(),
        preserveScroll: true,
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
    layout: (h, page) =>
        h(AdminLayout, { title: 'Manajemen Referensi', subTitle: 'Kelola E-Journal dan E-Book' }, { default: () => page }),
});
</script>

<template>
    <div class="font-inter relative min-h-screen overflow-hidden p-6 lg:p-8">
        <div class="relative z-10 w-full">
            <div class="mb-8 flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-end">
                <div class="flex rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                    <button @click="filterType = 'all'" class="rounded-lg px-4 py-2 text-sm font-bold transition-all" :class="filterType === 'all' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'">Semua</button>
                    <button @click="filterType = 'journal'" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold transition-all" :class="filterType === 'journal' ? 'bg-[#99cc33] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'"><Library class="h-4 w-4" /> E-Journal</button>
                    <button @click="filterType = 'ebook'" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold transition-all" :class="filterType === 'ebook' ? 'bg-blue-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'"><Book class="h-4 w-4" /> E-Book</button>
                </div>

                <div class="flex w-full flex-col gap-4 sm:flex-row lg:w-auto">
                    <button @click="openCreateModal" class="group flex items-center justify-center gap-2.5 rounded-xl bg-[#99cc33] px-6 py-2.5 text-white shadow-lg shadow-[#99cc33]/20 transition-all duration-300 hover:bg-[#8ab82e] hover:shadow-xl hover:shadow-[#99cc33]/30 active:scale-95">
                        <Plus class="h-5 w-5 stroke-[2.5] transition-transform group-hover:rotate-90" />
                        <span class="font-bold tracking-wide">Tambah Data</span>
                    </button>
                </div>
            </div>

            <div class="relative z-20 w-full overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/40">
                <div class="w-full overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="w-20 px-6 py-5 text-center text-xs font-bold tracking-widest text-slate-500 uppercase">Logo</th>
                                <th class="w-48 px-6 py-5 text-xs font-bold tracking-widest text-slate-500 uppercase">Nama & Tipe</th>
                                <th class="px-6 py-5 text-xs font-bold tracking-widest text-slate-500 uppercase">Deskripsi</th>
                                <th class="w-48 px-6 py-5 text-xs font-bold tracking-widest text-slate-500 uppercase">URL Utama</th>
                                <th class="w-28 px-6 py-5 text-center text-xs font-bold tracking-widest text-slate-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                             <tr v-for="item in filteredData" :key="item.id" class="group/row align-top transition-colors duration-200 hover:bg-slate-50/80">
                                <td class="px-6 py-5">
                                    <div class="relative mx-auto flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl border border-slate-100 bg-white p-1">
                                        <img v-if="item.img_url" :src="item.img_url" class="h-full w-full rounded-lg object-contain" alt="Logo" />
                                        <Globe v-else class="h-5 w-5 text-slate-300" />
                                    </div>
                                </td>
                                
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-2">
                                        <span class="text-base leading-tight font-bold text-slate-800">{{ item.name }}</span>
                                        <div>
                                            <span v-if="item.type === 'journal'" class="inline-flex items-center gap-1 rounded-md border border-[#99cc33]/20 bg-[#99cc33]/10 px-2.5 py-1 text-[10px] font-bold tracking-wider text-[#7ea82a] uppercase"><Library class="h-3 w-3" /> E-Journal</span>
                                            <span v-else class="inline-flex items-center gap-1 rounded-md border border-blue-100 bg-blue-50 px-2.5 py-1 text-[10px] font-bold tracking-wider text-blue-600 uppercase"><Book class="h-3 w-3" /> E-Book</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="min-w-[250px] text-sm leading-relaxed whitespace-pre-wrap text-slate-600 line-clamp-3">{{ item.description }}</p>
                                    <div v-if="item.additional_links && item.additional_links.length > 0" class="mt-2 flex flex-wrap gap-1">
                                        <span v-for="(link, lIdx) in item.additional_links" :key="lIdx" class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-[10px] text-slate-500 border border-slate-200">
                                            <LinkIcon class="w-3 h-3" /> {{ link.label }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <a :href="item.url" target="_blank" class="flex items-center gap-1 text-sm break-all text-slate-400 transition-colors hover:text-[#99cc33] hover:underline">{{ item.url }}</a>
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="openEditModal(item)" class="rounded-lg p-2 text-slate-400 transition-all hover:bg-[#99cc33]/10 hover:text-[#99cc33]" title="Edit"><Pencil class="h-4 w-4" /></button>
                                        <button @click="deleteItem(item)" class="rounded-lg p-2 text-slate-400 transition-all hover:bg-rose-50 hover:text-rose-600" title="Hapus"><Trash2 class="h-4 w-4" /></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="journals.links.length > 3" class="flex items-center justify-between border-t border-slate-50 bg-white px-8 py-6">
                    <p class="text-sm text-slate-500">Total Data: {{ journals.total }}</p>
                    <div class="flex gap-1">
                        <component :is="link.url ? 'a' : 'span'" v-for="(link, k) in journals.links" :key="k" :href="link.url" v-html="link.label" class="flex h-8 w-8 items-center justify-center rounded-lg text-xs font-bold transition-all" :class="link.active ? 'bg-slate-800 text-white' : 'text-slate-500 hover:bg-slate-100'" />
                    </div>
                </div>
            </div>
        </div>

        <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
                <div class="max-h-[90vh] w-full max-w-lg overflow-hidden overflow-y-auto rounded-2xl bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <h3 class="text-xl font-bold text-slate-900">{{ isEditing ? 'Edit Data' : 'Tambah Data Baru' }}</h3>
                        <button @click="closeModal" class="rounded-full p-2 text-slate-400 hover:bg-slate-100"><X class="h-5 w-5" /></button>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5 p-6">
                        
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">Nama Referensi <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Contoh: ScienceDirect" />
                            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Tipe <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border p-3 transition-all hover:bg-slate-50" :class="form.type === 'journal' ? 'border-[#99cc33] bg-[#99cc33]/5 ring-1 ring-[#99cc33]' : 'border-slate-200'">
                                    <input type="radio" v-model="form.type" value="journal" class="accent-[#99cc33]" />
                                    <span class="text-sm font-bold" :class="form.type === 'journal' ? 'text-[#99cc33]' : 'text-slate-600'">E-Journal</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border p-3 transition-all hover:bg-slate-50" :class="form.type === 'ebook' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-200'">
                                    <input type="radio" v-model="form.type" value="ebook" class="accent-blue-500" />
                                    <span class="text-sm font-bold" :class="form.type === 'ebook' ? 'text-blue-600' : 'text-slate-600'">E-Book</span>
                                </label>
                            </div>
                            <p v-if="form.errors.type" class="text-xs text-red-500">{{ form.errors.type }}</p>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-bold text-slate-700">Deskripsi / Subjek <span class="text-red-500">*</span></label>
                                <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                    Tips: Enter untuk baris baru, gunakan tanda '<b>-</b>' untuk list.
                                </span>
                            </div>
                            <textarea v-model="form.description" rows="5" class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Contoh:&#10;Jurnal ini mencakup bidang:&#10;- Teknik Komputer&#10;- Informatika"></textarea>
                            <p v-if="form.errors.description" class="text-xs text-red-500">{{ form.errors.description }}</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700">URL Utama (Tombol Buka) <span class="text-red-500">*</span></label>
                            <input v-model="form.url" type="url" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="https://..." />
                            <p v-if="form.errors.url" class="text-xs text-red-500">{{ form.errors.url }}</p>
                        </div>

                        <div class="space-y-3 pt-2 border-t border-slate-100">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                    <LinkIcon class="w-4 h-4 text-slate-400"/> Link Tambahan (Opsional)
                                </label>
                                <button type="button" @click="addLinkRow" class="text-xs font-bold text-[#99cc33] hover:underline flex items-center gap-1">
                                    <Plus class="w-3 h-3" /> Tambah Link
                                </button>
                            </div>
                            
                            <div v-if="form.additional_links.length === 0" class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-lg border border-dashed border-slate-200 text-center">
                                Tidak ada link tambahan. Klik tombol tambah di kanan atas jika ada link GDrive, Panduan, dll.
                            </div>

                            <div v-else class="space-y-2">
                                <div v-for="(link, index) in form.additional_links" :key="index" class="flex items-start gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 flex-1">
                                        <div>
                                            <input v-model="link.label" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium outline-none focus:border-[#99cc33] focus:ring-1 focus:ring-[#99cc33]" placeholder="Label Teks (Cth: Download PDF)" required />
                                        </div>
                                        <div>
                                            <input v-model="link.url" type="url" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium outline-none focus:border-[#99cc33] focus:ring-1 focus:ring-[#99cc33]" placeholder="https://..." required />
                                        </div>
                                    </div>
                                    <button type="button" @click="removeLinkRow(index)" class="mt-1 p-1 text-slate-400 hover:text-red-500 hover:bg-white rounded-full transition-all shadow-sm" title="Hapus Baris">
                                        <MinusCircle class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                            <p v-if="form.errors.additional_links" class="text-xs text-red-500">{{ form.errors.additional_links }}</p>
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-slate-100">
                            <label class="text-sm font-bold text-slate-700">Logo (Opsional)</label>
                            <div @click="triggerFileInput" class="group flex cursor-pointer items-center gap-4 rounded-xl border-2 border-dashed border-slate-300 p-4 transition-all hover:border-[#99cc33] hover:bg-slate-50">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-slate-100">
                                    <img v-if="previewImage" :src="previewImage" class="h-full w-full object-contain" />
                                    <UploadCloud v-else class="h-6 w-6 text-slate-400 group-hover:text-[#99cc33]" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Upload Gambar</p>
                                    <p class="text-xs text-slate-500">Klik atau drag file ke sini (Max 2MB)</p>
                                </div>
                                <input ref="fileInputRef" type="file" class="hidden" accept="image/*" @change="handleFileChange" />
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="closeModal" class="rounded-xl px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100">Batal</button>
                            <button :disabled="form.processing" type="submit" class="flex items-center gap-2 rounded-xl bg-[#99cc33] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/20 hover:bg-[#8ebf2f]">
                                <Save class="h-4 w-4" /> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </div>
</template>