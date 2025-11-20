<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { 
    Plus, Pencil, Trash2, X, Save, UploadCloud, Globe, Image as ImageIcon, FileText
} from 'lucide-vue-next';

const props = defineProps({
    journals: Object, 
    errors: Object
});

// -- STATE MANAGEMENT --
const showModal = ref(false);
const isEditing = ref(false);
const previewImage = ref(null);
const fileInputRef = ref(null);

// Form Default
const form = useForm({
    id: null,
    name: '',
    subject: '',
    url: '',
    logo: null,
    _method: 'POST' 
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
    form.subject = item.subject;
    form.url = item.url;
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
    if (isEditing.value) {
        form.post(`/admin/e-journals/${form.id}`, {
            onSuccess: () => closeModal(),
            preserveScroll: true
        });
    } else {
        form.post('/admin/e-journals', {
            onSuccess: () => closeModal(),
            preserveScroll: true
        });
    }
};

const deleteItem = (item) => {
    if (confirm('Yakin ingin menghapus jurnal ' + item.name + '?')) {
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
    layout: (h, page) => h(AdminLayout, { title: 'Manajemen E-Journal', subTitle: 'Kelola daftar jurnal dan database' }, { default: () => page }),
});
</script>

<template>
    <div class="min-h-screen bg-slate-50/50 p-6 lg:p-8 font-inter relative overflow-hidden">
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-[#99cc33]/10 rounded-full blur-3xl opacity-60 pointer-events-none mix-blend-multiply"></div>
        
        <div class="w-full relative z-10">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Daftar E-Journal</h1>
                    <p class="text-slate-500 mt-2 text-lg">Kelola repositori dan database jurnal eksternal.</p>
                </div>
                <button 
                    @click="openCreateModal" 
                    class="group flex items-center gap-2.5 px-6 py-3 bg-[#99cc33] text-white rounded-2xl hover:bg-[#8ab82e] transition-all duration-300 shadow-lg shadow-[#99cc33]/20 hover:shadow-xl hover:shadow-[#99cc33]/30 active:scale-95 shrink-0"
                >
                    <Plus class="w-5 h-5 transition-transform group-hover:rotate-90 stroke-[2.5]" />
                    <span class="font-bold tracking-wide">Jurnal Baru</span>
                </button>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden relative z-20 w-full">
                
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-8 py-6 text-slate-400 uppercase text-xs font-bold tracking-widest w-24">Identity</th>
                                <th class="px-8 py-6 text-slate-400 uppercase text-xs font-bold tracking-widest">Nama Jurnal & URL</th>
                                <th class="px-8 py-6 text-slate-400 uppercase text-xs font-bold tracking-widest">Kategori</th>
                                <th class="px-8 py-6 text-center text-slate-400 uppercase text-xs font-bold tracking-widest w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr v-for="item in journals.data" :key="item.id" class="hover:bg-slate-50/80 transition-colors duration-200 group/row">
                                <td class="px-8 py-5">
                                    <div class="h-14 w-14 rounded-2xl border border-slate-100 bg-slate-50 p-1 flex items-center justify-center overflow-hidden relative group-hover/row:border-[#99cc33]/30 transition-colors">
                                        <img v-if="item.img_url" :src="item.img_url" class="h-full w-full object-contain rounded-xl" alt="Logo" />
                                        <Globe v-else class="w-6 h-6 text-slate-300 group-hover/row:text-[#99cc33] transition-colors" />
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-base mb-1">{{ item.name }}</span>
                                        <a :href="item.url" target="_blank" class="text-sm text-slate-500 hover:text-[#99cc33] hover:underline truncate flex items-center gap-1 transition-colors">
                                            {{ item.url }}
                                            <Globe class="w-3 h-3 opacity-70" />
                                        </a>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl font-semibold text-xs bg-[#99cc33]/10 text-[#7ea82a] border border-[#99cc33]/20">
                                        {{ item.subject }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-80 group-hover/row:opacity-100 transition-opacity">
                                        <button @click="openEditModal(item)" class="p-2.5 text-slate-400 bg-white border border-slate-200 hover:border-[#99cc33] hover:text-[#99cc33] hover:bg-[#99cc33]/5 rounded-xl transition-all duration-200 active:scale-90" title="Edit">
                                            <Pencil class="w-[18px] h-[18px]" />
                                        </button>
                                        <button @click="deleteItem(item)" class="p-2.5 text-slate-400 bg-white border border-slate-200 hover:border-rose-200 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-200 active:scale-90" title="Hapus">
                                            <Trash2 class="w-[18px] h-[18px]" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="journals.data.length === 0">
                                <td colspan="4" class="px-8 py-20">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                            <FileText class="w-10 h-10 text-slate-300" />
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">Belum ada Data Jurnal</h3>
                                        <p class="text-slate-500 mt-2 max-w-md">Mulailah dengan menambahkan jurnal elektronik pertama Anda ke dalam sistem.</p>
                                        <button @click="openCreateModal" class="mt-6 px-6 py-2.5 bg-white border-2 border-[#99cc33] text-[#99cc33] rounded-xl font-bold hover:bg-[#99cc33] hover:text-white transition-all duration-200">
                                            Tambah Jurnal Sekarang
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="journals.links.length > 3" class="px-8 py-6 border-t border-slate-50 bg-white flex justify-between items-center">
                    <p class="text-sm text-slate-500">Menampilkan {{ journals.from }}-{{ journals.to }} dari {{ journals.total }} data.</p>
                    <div class="flex gap-2 bg-slate-100 p-1.5 rounded-xl">
                        <component 
                            :is="link.url ? 'a' : 'span'" 
                            v-for="(link, k) in journals.links" 
                            :key="k"
                            :href="link.url"
                            v-html="link.label"
                            class="w-9 h-9 flex items-center justify-center rounded-[10px] text-sm font-bold transition-all duration-200"
                            :class="{
                                'bg-white text-[#99cc33] shadow-sm ring-2 ring-[#99cc33]/10': link.active,
                                'text-slate-500 hover:bg-white hover:text-slate-700': !link.active && link.url,
                                'text-slate-300 cursor-not-allowed': !link.url
                            }"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-sm">
                <Transition
                     enter-active-class="transition duration-400 ease-cubic-bezier(0.16, 1, 0.3, 1)"
                     enter-from-class="opacity-0 translate-y-12 scale-95"
                     enter-to-class="opacity-100 translate-y-0 scale-100"
                     leave-active-class="transition duration-200 ease-in"
                     leave-from-class="opacity-100 translate-y-0 scale-100"
                     leave-to-class="opacity-0 translate-y-8 scale-95"
                >
                    <div v-if="showModal" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl overflow-hidden relative">
                        <div class="flex items-center justify-between px-8 pt-8 pb-4 relative z-10">
                            <h3 class="text-2xl font-extrabold text-slate-900">
                                {{ isEditing ? 'Edit Jurnal' : 'Jurnal Baru' }}
                            </h3>
                            <button @click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-full transition-all active:scale-90">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="px-8 pb-8 space-y-6">
                            <p class="text-slate-500">Lengkapi informasi detail jurnal di bawah ini.</p>
                            
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Nama Jurnal <span class="text-[#99cc33]">*</span></label>
                                    <input 
                                        v-model="form.name" type="text" 
                                        class="w-full px-5 py-3 rounded-xl border-2 border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400" 
                                        placeholder="Misal: ScienceDirect" 
                                    />
                                    <p v-if="form.errors.name" class="text-red-500 text-sm font-medium mt-1">{{ form.errors.name }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Kategori / Subjek <span class="text-[#99cc33]">*</span></label>
                                    <input 
                                        v-model="form.subject" type="text" 
                                        class="w-full px-5 py-3 rounded-xl border-2 border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400" 
                                        placeholder="Misal: Bisnis, Teknologi" 
                                    />
                                    <p v-if="form.errors.subject" class="text-red-500 text-sm font-medium mt-1">{{ form.errors.subject }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">URL Website <span class="text-[#99cc33]">*</span></label>
                                    <input 
                                        v-model="form.url" type="url" 
                                        class="w-full px-5 py-3 rounded-xl border-2 border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400" 
                                        placeholder="https://..." 
                                    />
                                    <p v-if="form.errors.url" class="text-red-500 text-sm font-medium mt-1">{{ form.errors.url }}</p>
                                </div>
                            </div>

                            <div class="pt-2 space-y-2">
                                <label class="block text-sm font-bold text-slate-700">Logo Jurnal (Opsional)</label>
                                
                                <div 
                                    @click="triggerFileInput"
                                    @dragover.prevent
                                    @drop.prevent="handleDrop"
                                    class="relative group/upload flex flex-col items-center justify-center w-full h-48 border-3 border-dashed border-slate-200 rounded-2xl bg-slate-50/30 hover:bg-[#99cc33]/5 hover:border-[#99cc33]/50 transition-all duration-300 cursor-pointer overflow-hidden"
                                    :class="{'border-[#99cc33] bg-[#99cc33]/10': previewImage}"
                                >
                                    <input ref="fileInputRef" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="handleFileChange" />
                                    
                                    <div v-if="previewImage" class="absolute inset-0 p-4 z-10 flex items-center justify-center bg-white/80 backdrop-blur-sm opacity-0 group-hover/upload:opacity-100 transition-opacity duration-300">
                                         <p class="text-sm font-bold text-slate-600">Klik untuk ganti gambar</p>
                                    </div>
                                    <img v-if="previewImage" :src="previewImage" class="absolute inset-0 w-full h-full object-contain p-6 z-0" />

                                    <div v-if="!previewImage" class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                        <div class="w-16 h-16 mb-4 rounded-full bg-[#99cc33]/10 flex items-center justify-center group-hover/upload:scale-110 transition-transform duration-300">
                                            <UploadCloud class="w-8 h-8 text-[#99cc33]" />
                                        </div>
                                        <p class="mb-2 text-sm text-slate-700 font-semibold">
                                            <span class="text-[#99cc33] underline-offset-2 hover:underline">Klik untuk unggah</span> atau drag and drop
                                        </p>
                                        <p class="text-xs text-slate-400">PNG, JPG (Maks. 2MB)</p>
                                    </div>
                                </div>
                                <p v-if="form.errors.logo" class="text-red-500 text-sm font-medium mt-1">{{ form.errors.logo }}</p>
                            </div>

                            <div class="pt-6 flex justify-end gap-4 items-center">
                                <button 
                                    type="button" 
                                    @click="closeModal" 
                                    class="px-5 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl font-bold text-sm transition-all duration-200"
                                >
                                    Batal
                                </button>
                                <button 
                                    :disabled="form.processing" 
                                    type="submit" 
                                    class="px-8 py-3 bg-[#99cc33] text-white rounded-xl hover:bg-[#8ebf2f] shadow-lg shadow-[#99cc33]/20 font-bold text-sm flex items-center gap-2 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed hover:shadow-xl hover:shadow-[#99cc33]/30 active:scale-95"
                                >
                                    <Save class="w-5 h-5" />
                                    {{ isEditing ? 'Simpan Perubahan' : 'Simpan Data' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </Transition>
    </div>
</template>