<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ref } from 'vue';

// 1. DEFINISIKAN TIPE DATA PDF (Agar TS tidak bingung)
interface PdfFile {
    id: number;
    name: string;
    path: string;
    created_at?: string;
    updated_at?: string;
}

// 2. GUNAKAN GENERIC PROPS (Agar TS tahu 'pdf' bisa null atau ada isinya)
const props = defineProps<{
    pdf?: PdfFile | null;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const form = useForm({ file: null as File | null, _method: 'POST' });

// --- STATE MODAL ---
const showResultModal = ref(false);
const resultMessage = ref('');
const isError = ref(false);

const showConfirmModal = ref(false);
const confirmMessage = ref('');
const onConfirmAction = ref<(() => void) | null>(null);

// --- HELPER MODAL ---
const showNotification = (msg: string, error = false) => {
    resultMessage.value = msg;
    isError.value = error;
    showResultModal.value = true;
};

const triggerConfirm = (msg: string, action: () => void) => {
    confirmMessage.value = msg;
    onConfirmAction.value = action;
    showConfirmModal.value = true;
};

const handleConfirmYes = () => {
    if (onConfirmAction.value) {
        onConfirmAction.value();
    }
    showConfirmModal.value = false;
};

// --- LOGIC UTAMA ---
const submit = () => {
    // TS Check: Pastikan pdf ada sebelum akses ID
    if (props.pdf) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(`/admin/renstra/update/${props.pdf.id}`, { // props.pdf.id sekarang aman
            forceFormData: true,
            onSuccess: () => {
                showNotification('Berhasil memperbarui dokumen PDF!');
                form.reset();
                if (fileInput.value) fileInput.value.value = '';
            },
            onError: () => {
                showNotification('Gagal update! Pastikan format PDF dan ukuran sesuai.', true);
            }
        });
    } else {
        form.post('/admin/renstra/store', {
            forceFormData: true,
            onSuccess: () => {
                showNotification('Berhasil mengunggah dokumen PDF!');
                form.reset();
                if (fileInput.value) fileInput.value.value = '';
            },
            onError: () => {
                showNotification('Gagal upload! Pastikan file dipilih.', true);
            }
        });
    }
};

const deletePdf = () => {
    if (!props.pdf) return;

    triggerConfirm('Apakah Anda yakin ingin menghapus file ini secara permanen? Tindakan ini tidak bisa dibatalkan.', () => {
        // Kita perlu check props.pdf lagi atau gunakan non-null assertion (!) jika yakin ada
        if (props.pdf) {
            form.delete(`/admin/renstra/delete/${props.pdf.id}`, {
                onSuccess: () => showNotification('Dokumen PDF berhasil dihapus!'),
                onError: () => showNotification('Gagal menghapus dokumen.', true),
            });
        }
    });
};

// 3. PERBAIKAN TIPE DATA PADA LAYOUT (Tambahkan ': any')
defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, { title: 'Rencana Strategi', subTitle: 'Kelola Data File Rencana Strategi' }, { default: () => page })
}); 

</script>

<template>
    <div class="space-y-6 relative">
        
        <div v-if="pdf" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-4">
                <Card class="h-full shadow-md">
                    <CardHeader>
                        <CardTitle class="text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Preview Dokumen
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="p-0">
                        <iframe
                            :src="`/storage/${pdf.path}#toolbar=0&navpanes=0&scrollbar=0`"
                            class="w-full h-[700px] rounded-b-lg bg-gray-50"
                            title="Preview PDF"
                        ></iframe>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <Card class="border-l-4 border-l-green-500 shadow-sm transition-all hover:shadow-md">
                    <CardHeader class="pb-2">
                        <CardTitle class="text-base text-gray-700">Informasi File</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Nama File Saat Ini:</p>
                            <div class="flex items-center gap-2 bg-green-50 p-3 rounded-md border border-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                <p class="font-medium text-green-900 text-sm truncate" :title="pdf.name">{{ pdf.name }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="shadow-sm transition-all hover:shadow-md">
                    <CardHeader class="pb-3">
                        <CardTitle class="text-base text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            Ganti File
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="space-y-2">
                                <Label for="update-file" class="text-xs text-gray-500 uppercase font-semibold">Pilih PDF Baru</Label>
                                <Input 
                                    id="update-file"
                                    ref="fileInput" 
                                    type="file" 
                                    accept="application/pdf"
                                    @input="form.file = (($event.target as HTMLInputElement).files?.[0] || null)"
                                    class="text-sm file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer"
                                />
                                <p v-if="form.errors.file" class="text-red-500 text-xs">{{ form.errors.file }}</p>
                            </div>
                            
                            <Button 
                                type="submit" 
                                :disabled="form.processing" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                            >
                                {{ form.processing ? 'Mengganti...' : 'Simpan Perubahan' }}
                            </Button>
                        </form>
                    </CardContent>
                </Card>

                <Card class="border-red-100 bg-red-50/50 shadow-sm transition-all hover:shadow-md">
                    <CardHeader class="pb-2">
                        <CardTitle class="text-red-600 text-base flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Zona Berbahaya
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-gray-600 mb-4">
                            Menghapus file ini akan menghilangkannya dari tampilan publik website.
                        </p>
                        
                        <Button 
                            @click="deletePdf" 
                            variant="destructive" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border-red-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Hapus Dokumen Permanen
                        </Button>

                    </CardContent>
                </Card>
            </div>
        </div>

        <div v-else class="flex justify-center py-20">
            <Card class="w-full max-w-lg shadow-lg border-t-4 border-t-green-500">
                <CardHeader class="text-center pb-2">
                    <div class="mx-auto bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    </div>
                    <CardTitle class="text-xl">Upload Rencana Strategi</CardTitle>
                    <p class="text-gray-500 text-sm">Silakan upload dokumen PDF untuk menampilkannya di website.</p>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid w-full items-center gap-1.5">
                            <Label for="upload-file">File Dokumen</Label>
                            <Input 
                                id="upload-file"
                                ref="fileInput" 
                                type="file" 
                                accept="application/pdf"
                                @input="form.file = (($event.target as HTMLInputElement).files?.[0] || null)"
                                class="cursor-pointer file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                            />
                            <p v-if="form.errors.file" class="text-red-500 text-sm">{{ form.errors.file }}</p>
                        </div>
                        
                        <Button type="submit" :disabled="form.processing" 
                            class="w-full bg-green-600 hover:bg-green-700 text-lg h-12 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                        >
                            <span v-if="form.processing">Mengupload...</span>
                            <span v-else>Upload Sekarang</span>
                        </Button>
                    </form>
                </CardContent>
            </Card>
        </div>

        <div v-if="showResultModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 transform transition-all scale-100">
                <div class="flex flex-col items-center text-center">
                    <div :class="`rounded-full p-3 mb-4 ${isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}`">
                        <svg v-if="isError" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ isError ? 'Terjadi Kesalahan' : 'Berhasil!' }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ resultMessage }}</p>
                    <Button @click="showResultModal = false" class="w-full" :class="isError ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'">
                        Tutup
                    </Button>
                </div>
            </div>
        </div>

        <div v-if="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all">
                <div class="flex items-start space-x-4">
                    <div class="bg-red-100 p-2 rounded-full text-red-600 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Konfirmasi Penghapusan</h3>
                        <p class="text-sm text-gray-500 mt-2">{{ confirmMessage }}</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <Button variant="outline" @click="showConfirmModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-700 border-0">
                        Batal
                    </Button>
                    <Button variant="destructive" @click="handleConfirmYes" class="bg-red-600 hover:bg-red-700">
                        Ya, Hapus File
                    </Button>
                </div>
            </div>
        </div>

    </div>
</template>