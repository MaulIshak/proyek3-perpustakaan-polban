<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// --- TYPES ---
interface Cover {
    id: number;
    title: string;
    image_path: string;
}

const props = defineProps<{
    covers: Cover[];
}>();

// --- STATE ---
const showModal = ref(false); 
const fileInput = ref<HTMLInputElement | null>(null);

const showResultModal = ref(false); 
const resultMessage = ref('');
const isError = ref(false);

const showConfirmModal = ref(false); 
const deleteId = ref<number | null>(null);

// --- FORM ---
const form = useForm({
    title: '',
    image: null as File | null,
    _method: 'POST',
});

// --- HELPER NOTIF ---
const showNotif = (msg: string, err = false) => {
    resultMessage.value = msg;
    isError.value = err;
    showResultModal.value = true;
};

// --- ACTIONS ---
const openAddModal = () => {
    form.reset();
    form._method = 'POST';
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    if (fileInput.value) fileInput.value.value = '';
};

const submit = () => {
    form.post('/admin/cover-buku/store', {
        forceFormData: true,
        onSuccess: () => {
            closeModal();
            showNotif('Cover berhasil ditambahkan!');
        },
        onError: () => showNotif('Gagal simpan! Cek inputan.', true),
    });
};

// --- DELETE ACTIONS ---
const confirmDelete = (id: number) => {
    deleteId.value = id;
    showConfirmModal.value = true;
};

const executeDelete = () => {
    if (deleteId.value) {
        form.delete(`/admin/cover-buku/delete/${deleteId.value}`, {
            onSuccess: () => {
                showConfirmModal.value = false;
                showNotif('Cover berhasil dihapus!');
            },
            onError: () => showNotif('Gagal menghapus.', true),
        });
    }
};

defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, { title: 'Cover Buku', subTitle: 'Kelola Galeri Cover Buku' }, { default: () => page })
});
</script>

<template>
    <div class="space-y-6 relative">
        
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Galeri Cover Buku</h1>
            <Button @click="openAddModal" class="bg-green-600 hover:bg-green-700 text-white shadow-md transition-transform hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Cover
            </Button>
        </div>

        <div v-if="covers.length === 0" class="flex flex-col items-center justify-center py-20 bg-white rounded-lg shadow-sm border border-dashed border-gray-300">
            <div class="bg-green-50 p-4 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada cover buku</h3>
            <p class="text-gray-500 mt-1">Silakan tambahkan cover buku baru untuk ditampilkan.</p>
        </div>

        <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <div v-for="cover in covers" :key="cover.id" class="group relative flex flex-col">
                <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden shadow-sm border border-gray-200 cursor-pointer">
                    <img 
                        :src="`/storage/${cover.image_path}`" 
                        :alt="cover.title" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-10">
                        <button 
                            @click="confirmDelete(cover.id)"
                            class="bg-red-600 text-white p-3 rounded-full shadow-lg hover:bg-red-700 hover:scale-110 transition-all transform"
                            title="Hapus Gambar"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-3 text-center px-1">
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 leading-tight group-hover:text-green-700 transition-colors">
                        {{ cover.title }}
                    </h3>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div v-if="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <Card class="w-full max-w-md shadow-2xl animate-in fade-in zoom-in duration-200 bg-white">
                    <CardHeader class="border-b bg-green-50/50 pb-3">
                        <CardTitle class="text-green-800">Tambah Cover Buku</CardTitle>
                    </CardHeader>
                    <CardContent class="pt-6">
                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="space-y-2">
                                <Label for="title">Judul Buku</Label>
                                <Input id="title" v-model="form.title" placeholder="Masukkan judul buku..." />
                                <p v-if="form.errors.title" class="text-red-500 text-xs">{{ form.errors.title }}</p>
                            </div>

                            <div class="space-y-2">
                                <Label>File Gambar</Label>
                                <Input 
                                    id="image"
                                    ref="fileInput"
                                    type="file" 
                                    accept="image/*"
                                    @input="form.image = (($event.target as HTMLInputElement).files?.[0] || null)"
                                    class="cursor-pointer file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                />
                                <p v-if="form.errors.image" class="text-red-500 text-xs">{{ form.errors.image }}</p>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <Button type="button" variant="outline" @click="closeModal">Batal</Button>
                                <Button type="submit" class="bg-green-600 hover:bg-green-700 text-white" :disabled="form.processing">
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="showResultModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-lg shadow-2xl w-full max-w-sm p-6 text-center">
                    <div :class="`rounded-full p-3 mb-4 inline-block ${isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}`">
                        <svg v-if="isError" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <svg v-else class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ isError ? 'Gagal' : 'Berhasil' }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ resultMessage }}</p>
                    <Button @click="showResultModal = false" class="w-full bg-gray-900 text-white hover:bg-gray-800">Tutup</Button>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="showConfirmModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
                    <h3 class="text-lg font-bold text-gray-900">Hapus Cover Buku?</h3>
                    <p class="text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan. Gambar akan dihapus permanen.</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <Button variant="outline" @click="showConfirmModal = false">Batal</Button>
                        <Button variant="destructive" @click="executeDelete" class="bg-red-600 hover:bg-red-700">Hapus</Button>
                    </div>
                </div>
            </div>
        </Teleport>

    </div>
</template>