<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import {
    AlertCircle,
    CheckCircle2,
    Eye,
    FileCheck,
    FileText,
    Save,
    Trash2,
    UploadCloud,
} from 'lucide-vue-next';
import { ref } from 'vue';

// Import ConfirmModal & Composable
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

// --- TYPE DEFINITION ---
interface PdfFile {
    id: number;
    name: string;
    path: string;
    created_at?: string;
    updated_at?: string;
}

// --- PROPS ---
const props = defineProps<{
    pdf?: PdfFile | null;
}>();

// --- STATE ---
const fileInputRef = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);
const { open } = useConfirmModal();

// Form Inertia
const form = useForm({
    file: null as File | null,
    _method: 'POST',
});

// Helper: File Selection
const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0] || null;

    if (file) {
        // Validasi sederhana (Client side)
        if (file.type !== 'application/pdf') {
            alert('Hanya file PDF yang diperbolehkan.');
            target.value = '';
            return;
        }
        // 10MB Limit (sesuaikan kebutuhan)
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file maksimal 10MB.');
            target.value = '';
            return;
        }

        selectedFile.value = file;
        form.file = file;
        form.clearErrors();
    }
};

const triggerFileInput = () => {
    fileInputRef.value?.click();
};

// --- ACTIONS ---
const submit = () => {
    if (!form.file) return;

    if (props.pdf) {
        // Update Mode
        form.transform((data) => ({ ...data, _method: 'PUT' })).post(
            `/admin/renstra/update/${props.pdf.id}`,
            {
                forceFormData: true,
                preserveScroll: true,
                onSuccess: () => {
                    selectedFile.value = null;
                    if (fileInputRef.value) fileInputRef.value.value = '';
                },
            },
        );
    } else {
        // Create Mode
        form.post('/admin/renstra/store', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                selectedFile.value = null;
                if (fileInputRef.value) fileInputRef.value.value = '';
            },
        });
    }
};

const deletePdf = () => {
    if (!props.pdf) return;

    open({
        title: 'Hapus Dokumen Renstra?',
        message:
            'Dokumen ini akan dihapus secara permanen dan tidak akan tampil lagi di halaman publik. Apakah Anda yakin?',
        actionLabel: 'Hapus Permanen',
        // confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
        onConfirm: () => {
            form.delete(`/admin/renstra/delete/${props.pdf!.id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    selectedFile.value = null;
                },
            });
        },
    });
};

// Layout Definition
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Rencana Strategi',
                subTitle: 'Kelola dokumen PDF Rencana Strategi (Renstra)',
            },
            { default: () => page },
        ),
});
</script>

<template>
    <div class="space-y-8 font-sans text-slate-600">
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- LEFT COLUMN: PDF Preview (Dominant) -->
            <div class="lg:col-span-2">
                <div
                    class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <!-- Header Preview -->
                    <div
                        class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-6 py-4"
                    >
                        <h3
                            class="flex items-center gap-2 font-bold text-slate-800"
                        >
                            <Eye class="h-5 w-5 text-[#99cc33]" />
                            Preview Dokumen
                        </h3>
                        <span
                            v-if="pdf"
                            class="flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700"
                        >
                            <CheckCircle2 class="h-3 w-3" /> Tayang
                        </span>
                        <span
                            v-else
                            class="flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500"
                        >
                            <AlertCircle class="h-3 w-3" /> Kosong
                        </span>
                    </div>

                    <!-- Iframe Container -->
                    <div
                        class="relative min-h-[500px] flex-grow bg-slate-100 lg:min-h-[700px]"
                    >
                        <iframe
                            v-if="pdf"
                            :src="`/storage/${pdf.path}#toolbar=0&navpanes=0&scrollbar=0`"
                            class="absolute inset-0 h-full w-full"
                            title="Preview PDF"
                        ></iframe>

                        <!-- Empty State -->
                        <div
                            v-else
                            class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center"
                        >
                            <div
                                class="mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-white shadow-sm"
                            >
                                <FileText class="h-10 w-10 text-slate-300" />
                            </div>
                            <h4 class="text-lg font-bold text-slate-700">
                                Belum Ada Dokumen
                            </h4>
                            <p class="max-w-xs text-sm text-slate-500">
                                Silakan unggah file PDF Rencana Strategi melalui
                                panel di sebelah kanan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Controls -->
            <div class="space-y-6">
                <!-- Card 1: Info File (If Exists) -->
                <div
                    v-if="pdf"
                    class="rounded-2xl border-y border-r border-l-4 border-slate-200 border-l-[#99cc33] bg-white p-5 shadow-sm"
                >
                    <h4
                        class="mb-3 text-xs font-bold tracking-wider text-slate-400 uppercase"
                    >
                        File Aktif
                    </h4>
                    <div class="flex items-start gap-3">
                        <div
                            class="shrink-0 rounded-lg bg-[#99cc33]/10 p-2 text-[#99cc33]"
                        >
                            <FileCheck class="h-6 w-6" />
                        </div>
                        <div class="min-w-0">
                            <p
                                class="truncate text-sm font-bold text-slate-800"
                                :title="pdf.name"
                            >
                                {{ pdf.name }}
                            </p>
                            <p class="mt-0.5 text-xs text-slate-500">
                                Diunggah pada:
                                <span class="font-medium">{{
                                    new Date(
                                        pdf.created_at || '',
                                    ).toLocaleDateString('id-ID')
                                }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Upload Form -->
                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="border-b border-slate-100 px-6 py-4">
                        <h3
                            class="flex items-center gap-2 font-bold text-slate-800"
                        >
                            <UploadCloud class="h-5 w-5 text-[#99cc33]" />
                            {{ pdf ? 'Ganti Dokumen' : 'Upload Dokumen' }}
                        </h3>
                    </div>

                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-5">
                            <!-- Custom File Input -->
                            <div class="space-y-2">
                                <label
                                    class="mb-1 block text-sm font-bold text-slate-700"
                                    >Pilih File PDF</label
                                >

                                <div
                                    @click="triggerFileInput"
                                    class="group relative flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed bg-slate-50 text-center transition-all hover:bg-[#99cc33]/5"
                                    :class="
                                        form.errors.file
                                            ? 'border-red-300 bg-red-50'
                                            : 'border-slate-300 hover:border-[#99cc33]'
                                    "
                                >
                                    <div
                                        class="relative z-10 flex flex-col items-center p-4"
                                    >
                                        <div
                                            class="mb-3 rounded-full bg-white p-3 shadow-sm transition-transform group-hover:scale-110"
                                        >
                                            <FileText
                                                class="h-6 w-6 text-[#99cc33]"
                                            />
                                        </div>
                                        <p
                                            v-if="selectedFile"
                                            class="max-w-full truncate px-4 text-sm font-bold text-[#99cc33]"
                                        >
                                            {{ selectedFile.name }}
                                        </p>
                                        <div v-else>
                                            <p
                                                class="text-sm font-bold text-slate-700 transition-colors group-hover:text-[#99cc33]"
                                            >
                                                Klik untuk pilih file
                                            </p>
                                            <p
                                                class="mt-1 text-xs text-slate-400"
                                            >
                                                PDF (Maks. 10MB)
                                            </p>
                                        </div>
                                    </div>

                                    <input
                                        ref="fileInputRef"
                                        type="file"
                                        accept="application/pdf"
                                        class="hidden"
                                        @change="handleFileChange"
                                    />
                                </div>

                                <p
                                    v-if="form.errors.file"
                                    class="mt-1 flex items-center text-xs font-medium text-red-500"
                                >
                                    <AlertCircle class="mr-1 h-3 w-3" />
                                    {{ form.errors.file }}
                                </p>
                            </div>

                            <!-- Action Button -->
                            <button
                                type="submit"
                                :disabled="form.processing || !form.file"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-3 font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-70 disabled:hover:translate-y-0"
                            >
                                <span
                                    v-if="form.processing"
                                    class="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"
                                ></span>
                                <Save v-else class="h-5 w-5" />
                                {{
                                    form.processing
                                        ? 'Menyimpan...'
                                        : 'Simpan Perubahan'
                                }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Card 3: Danger Zone (Only if PDF exists) -->
                <div
                    v-if="pdf"
                    class="rounded-2xl border border-red-100 bg-red-50/50 p-5"
                >
                    <h4
                        class="mb-2 flex items-center gap-2 text-sm font-bold text-red-700"
                    >
                        <AlertCircle class="h-4 w-4" />
                        Zona Berbahaya
                    </h4>
                    <p class="mb-4 text-xs leading-relaxed text-red-600/80">
                        Menghapus dokumen akan menghilangkannya dari halaman
                        publik secara permanen.
                    </p>
                    <button
                        @click="deletePdf"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white py-2.5 text-sm font-bold text-red-600 shadow-sm transition-all hover:border-transparent hover:bg-red-600 hover:text-white"
                    >
                        <Trash2 class="h-4 w-4" />
                        Hapus Dokumen
                    </button>
                </div>
            </div>
        </div>

        <!-- Confirm Modal Component -->
        <ConfirmModal />
    </div>
</template>
