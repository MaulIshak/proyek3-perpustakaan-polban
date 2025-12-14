<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import {
    AlertCircle,
    Book,
    Image as ImageIcon,
    Link as LinkIcon,
    Plus,
    RotateCcw,
    Save,
    Trash2,
    Pencil, // [BARU] Import Icon Pencil
    UploadCloud,
    X,
    ExternalLink
} from 'lucide-vue-next';
import { ref } from 'vue';

import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Cover Buku',
                subTitle: 'Kelola aset visual sampul buku untuk katalog',
            },
            { default: () => page },
        ),
});

interface Cover {
    id: number;
    image_path: string;
    link_buku: string;
}

const props = defineProps<{
    covers: Cover[];
}>();

const MAX_FILE_SIZE = 2 * 1024 * 1024;

const showModal = ref(false);
const isEditing = ref(false); // [BARU] State untuk mode edit
const editingId = ref<number | null>(null); // [BARU] ID yang sedang diedit

const fileInputRef = ref<HTMLInputElement | null>(null);
const previewImage = ref<string | null>(null);
const { open } = useConfirmModal();

const form = useForm({
    link_buku: '',
    image: null as File | null,
    _method: 'POST', // Penting untuk update file via POST di Laravel
});

// [UBAH] Fungsi membuka modal bisa menerima data (untuk edit)
const openModal = (cover: Cover | null = null) => {
    form.reset();
    form.clearErrors();
    
    if (cover) {
        // Mode Edit
        isEditing.value = true;
        editingId.value = cover.id;
        form.link_buku = cover.link_buku;
        // Tampilkan gambar yang sudah ada di database sebagai preview awal
        previewImage.value = `/storage/${cover.image_path}`;
    } else {
        // Mode Tambah Baru
        isEditing.value = false;
        editingId.value = null;
        previewImage.value = null;
    }
    
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    setTimeout(() => {
        form.reset();
        previewImage.value = null;
        isEditing.value = false;
        editingId.value = null;
    }, 300);
};

const handleFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        if (file.size > MAX_FILE_SIZE) {
            form.setError('image', 'Ukuran file maksimal 2MB.');
            previewImage.value = null;
            return;
        }
        form.clearErrors('image');
        form.image = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const triggerFileInput = () => {
    fileInputRef.value?.click();
};

// [UBAH] Logic Submit Dinamis (Store / Update)
const submit = () => {
    if (isEditing.value && editingId.value) {
        // Logic Update
        form.post(`/admin/cover-buku/update/${editingId.value}`, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        // Logic Store (Create)
        form.post('/admin/cover-buku/store', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

const handleDelete = (cover: Cover) => {
    open({
        title: 'Hapus Cover Buku?',
        message: `Apakah Anda yakin ingin menghapus cover ini?`,
        actionLabel: 'Hapus',
        onConfirm: () => {
            router.delete(`/admin/cover-buku/delete/${cover.id}`, {
                preserveScroll: true,
            });
        },
    });
};
</script>

<template>
    <Head title="Cover Buku" />

    <div class="space-y-8 font-sans text-slate-600">
        <div class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row">
            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-[#99cc33]/10 p-2 text-[#99cc33]">
                    <Book class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Galeri Cover</h2>
                    <p class="text-xs font-medium text-slate-500">Total {{ props.covers.length }} cover buku</p>
                </div>
            </div>

            <button
                @click="() => openModal(null)"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                Tambah Cover
            </button>
        </div>

        <div v-if="covers.length > 0" class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            <div v-for="cover in covers" :key="cover.id" class="group relative flex flex-col">

                <div class="relative aspect-[2/3] w-full cursor-pointer overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-md transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-xl group-hover:shadow-[#99cc33]/20">
                    <img :src="`/storage/${cover.image_path}`" alt="Book Cover" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" />

                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-slate-900/40 opacity-0 backdrop-blur-[1px] transition-all duration-300 group-hover:opacity-100">
                        
                        <button
                            @click="openModal(cover)"
                            class="flex items-center gap-2 rounded-full border border-white/30 bg-white/90 px-4 py-2 text-xs font-bold text-slate-700 shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-[#99cc33] hover:text-white hover:border-[#99cc33]"
                            title="Edit Link / Gambar"
                        >
                            <Pencil class="h-3.5 w-3.5" />
                            Edit
                        </button>

                        <button
                            @click="handleDelete(cover)"
                            class="flex items-center gap-2 rounded-full border border-white/30 bg-white/20 px-4 py-2 text-xs font-bold text-white shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-rose-500 hover:border-rose-500"
                            title="Hapus Cover"
                        >
                            <Trash2 class="h-3.5 w-3.5" />
                            Hapus
                        </button>

                    </div>
                </div>

                <div class="mt-3 px-1 text-center min-h-[20px]">
                    <a :href="cover.link_buku" target="_blank" class="group/link inline-flex items-center gap-1.5 text-xs font-bold text-blue-500 hover:text-blue-600 transition-colors">
                        <LinkIcon class="h-3 w-3" /> 
                        <span class="truncate max-w-[120px] group-hover/link:underline">Buka Link Buku</span>
                        <ExternalLink class="h-2.5 w-2.5 opacity-50" />
                    </a>
                </div>
            </div>
        </div>

        <div v-else class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-white py-24 text-center">
            <div class="mb-4 flex h-20 w-20 animate-pulse items-center justify-center rounded-full bg-slate-50">
                <ImageIcon class="h-10 w-10 text-slate-400" />
            </div>
            <h3 class="mb-2 text-xl font-bold text-slate-800">Belum Ada Cover</h3>
            <p class="max-w-md text-sm leading-relaxed text-slate-500">
                Koleksi cover buku masih kosong. Silakan tambahkan cover buku baru.
            </p>
            <button @click="() => openModal(null)" class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline">
                Tambah Cover Sekarang
            </button>
        </div>

        <Teleport to="body">
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="showModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-6">
                <div @click="closeModal" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div class="relative z-10 flex max-h-[90vh] w-full max-w-md transform flex-col overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                    <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-lg font-bold text-slate-800">{{ isEditing ? 'Edit Cover Buku' : 'Tambah Cover Buku' }}</h2>
                        <button @click="closeModal" class="rounded-full p-1 text-slate-400 transition-colors hover:bg-slate-200 hover:text-slate-600">
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <div class="space-y-6 overflow-y-auto bg-white p-6">
                        <form @submit.prevent="submit" id="createForm" class="space-y-5">

                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-slate-700 flex items-center gap-1">
                                    Link Buku <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <LinkIcon class="h-4 w-4" />
                                    </div>
                                    <input
                                        v-model="form.link_buku"
                                        type="url"
                                        class="w-full rounded-xl border-slate-200 pl-10 transition-all placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 p-3"
                                        placeholder="https://perpustakaan.polban.ac.id/..."
                                        required
                                    />
                                </div>
                                <p v-if="form.errors.link_buku" class="mt-1 text-xs font-medium text-rose-500">{{ form.errors.link_buku }}</p>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700">
                                    File Cover 
                                    <span v-if="!isEditing" class="text-red-500">*</span>
                                    <span v-else class="text-xs font-normal text-gray-400 ml-1">(Biarkan kosong jika tidak diubah)</span>
                                </label>
                                <div
                                    @click="triggerFileInput"
                                    class="group relative flex h-64 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed bg-slate-50 text-center transition-all"
                                    :class="[
                                        form.errors.image ? 'border-red-300 bg-red-50' : 'border-slate-300 hover:border-[#99cc33] hover:bg-[#99cc33]/5',
                                        previewImage ? 'border-solid' : '',
                                    ]"
                                >
                                    <template v-if="previewImage">
                                        <img :src="previewImage" class="h-full w-full object-contain p-2" />
                                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/60 text-white opacity-0 backdrop-blur-[1px] transition-opacity group-hover:opacity-100">
                                            <RotateCcw class="mb-2 h-8 w-8" />
                                            <span class="text-sm font-bold">Ganti Gambar</span>
                                        </div>
                                    </template>
                                    <div v-else class="flex flex-col items-center justify-center p-6 transition-transform duration-300 group-hover:scale-105">
                                        <div class="mb-3 rounded-full bg-white p-4 shadow-sm group-hover:shadow-md">
                                            <UploadCloud class="h-8 w-8 text-[#99cc33]" />
                                        </div>
                                        <p class="text-sm font-bold text-slate-700 transition-colors group-hover:text-[#99cc33]">Klik untuk pilih file</p>
                                        <p class="mt-1 text-xs font-medium text-slate-400">JPG, PNG (Max 2MB)</p>
                                    </div>
                                    <input ref="fileInputRef" type="file" @change="handleFileChange" accept="image/*" class="hidden" />
                                </div>
                                <p v-if="form.errors.image" class="mt-2 flex animate-pulse items-center text-xs font-medium text-red-500">
                                    <AlertCircle class="mr-1 h-3 w-3" /> {{ form.errors.image }}
                                </p>
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 p-6">
                        <button @click="closeModal" type="button" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 shadow-sm transition-colors hover:bg-slate-100">Batal</button>
                        <button type="submit" form="createForm" :disabled="form.processing" class="flex items-center gap-2 rounded-xl bg-[#99cc33] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-70">
                            <span v-if="form.processing" class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                            <Save v-else class="h-4 w-4" />
                            {{ form.processing ? 'Menyimpan...' : (isEditing ? 'Simpan Perubahan' : 'Simpan') }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
</Teleport>
        <ConfirmModal />
    </div>
</template>