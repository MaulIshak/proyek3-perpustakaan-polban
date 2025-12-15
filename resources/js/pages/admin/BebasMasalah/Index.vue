<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // Tambah computed
import {
    Save,
    UploadCloud,
    FileText,
    Image as ImageIcon,
    GitGraph,
    CheckSquare,
    BookOpen,
    ShieldCheck,
    Download,
    X,
    CheckCircle2,
    AlertCircle,
    FileType // Tambah icon FileType
} from 'lucide-vue-next';

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
}>();

// State
const activeTab = ref('alur');

// --- LOCAL TOAST STATE ---
const toast = ref({
    show: false,
    message: '',
    type: 'success' as 'success' | 'error'
});

let toastTimeout: any = null;

const showToast = (message: string, type: 'success' | 'error' = 'success') => {
    toast.value = { show: true, message, type };
    if (toastTimeout) clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        toast.value.show = false;
    }, 3000);
};

// Tabs Configuration
const tabs = [
    { id: 'alur', label: 'Diagram Alur', icon: GitGraph },
    { id: 'persyaratan', label: 'Persyaratan', icon: CheckSquare },
    { id: 'panduan', label: 'Panduan', icon: BookOpen },
    { id: 'template', label: 'Template Surat', icon: FileText },
    { id: 'watermark', label: 'Watermark', icon: ShieldCheck },
];

// Single Form for All Settings
const form = useForm({
    _method: 'POST',

    // Tab 1: Alur
    alur_description: props.settings?.alur_description || '',
    alur_image: null as File | null,

    // Tab 2: Persyaratan
    requirement_description: props.settings?.requirement_description || '',
    requirement_file: null as File | null,

    // Tab 3: Panduan
    guide_description: props.settings?.guide_description || '',
    guide_file: null as File | null,

    // Tab 4: Template
    template_title: props.settings?.template_title || '',
    template_info: props.settings?.template_info || '',
    template_instruction: props.settings?.template_instruction || '',
    template_file: null as File | null,

    // Tab 5: Watermark
    watermark_title: props.settings?.watermark_title || '',
    watermark_info: props.settings?.watermark_info || 'Format PDF - Ukuran: Max 2 MB',
    watermark_instruction: props.settings?.watermark_instruction || '',
    watermark_file: null as File | null,
});

const submitSettings = () => {
    form.post('/admin/bebas-masalah/settings', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('alur_image', 'requirement_file', 'guide_file', 'template_file', 'watermark_file');
            showToast('Pengaturan berhasil disimpan!', 'success');
        },
        onError: () => {
            showToast('Gagal menyimpan pengaturan. Periksa input Anda.', 'error');
        }
    });
};

const MAX_FILE_SIZE_MB = 5;
const MAX_FILE_SIZE_BYTES = MAX_FILE_SIZE_MB * 1024 * 1024;

const handleFileChange = (field: string, event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        // 1. Validasi Ukuran File (Client Side)
        if (file.size > MAX_FILE_SIZE_BYTES) {
            // Tampilkan Toast Error
            showToast(`Gagal! Ukuran file terlalu besar. Maksimal ${MAX_FILE_SIZE_MB} MB.`, 'error');

            // Reset input file agar user harus pilih ulang
            target.value = '';

            // Jangan masukkan ke form
            return;
        }

        // 2. Validasi Tipe File (Optional, tapi bagus untuk UX)
        const isImage = field === 'alur_image';
        if (isImage && !file.type.startsWith('image/')) {
             showToast('File harus berupa gambar (JPG/PNG).', 'error');
             target.value = '';
             return;
        }

        if (!isImage && file.type !== 'application/pdf' && !file.name.match(/\.(doc|docx)$/i)) {
             // Validasi sederhana untuk PDF/Doc
             showToast('Format file tidak didukung.', 'error');
             target.value = '';
             return;
        }

        (form as any)[field] = file;
    }
};

// --- HELPER UNTUK PREVIEW ---
const getCurrentFilePath = () => {
    if (activeTab.value === 'alur') return props.settings?.alur_image_path;
    if (activeTab.value === 'persyaratan') return props.settings?.requirement_file_path;
    if (activeTab.value === 'panduan') return props.settings?.guide_file_path;
    if (activeTab.value === 'template') return props.settings?.template_file_path;
    if (activeTab.value === 'watermark') return props.settings?.watermark_file_path;
    return null;
};

// Computed property untuk mengecek apakah file saat ini adalah PDF
const isPdf = computed(() => {
    const path = getCurrentFilePath();
    if (!path) return false;
    // Cek ekstensi file string
    return path.toLowerCase().endsWith('.pdf');
});

const getTabLabel = () => {
    const tab = tabs.find(t => t.id === activeTab.value);
    return tab ? tab.label : '';
};
</script>

<template>
    <div class="space-y-8 font-sans text-slate-600 relative">
        <Teleport to="body">
        <transition name="toast">
            <div v-if="toast.show"
                class="fixed top-24 right-5 z-[100] flex items-center gap-3 px-4 py-3 rounded-xl shadow-xl border backdrop-blur-md transition-all duration-300 min-w-[300px]"
                :class="toast.type === 'success'
                    ? 'bg-white/95 border-emerald-200 text-emerald-700'
                    : 'bg-white/95 border-rose-200 text-rose-700'"
            >
                <div class="p-1 rounded-full shrink-0" :class="toast.type === 'success' ? 'bg-emerald-100' : 'bg-rose-100'">
                    <CheckCircle2 v-if="toast.type === 'success'" class="w-5 h-5" />
                    <AlertCircle v-else class="w-5 h-5" />
                </div>
                <div class="flex-1 text-sm font-bold">
                    {{ toast.message }}
                </div>
                <button @click="toast.show = false" class="p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <X class="w-4 h-4 opacity-50" />
                </button>
            </div>
        </transition>
        </Teleport>
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

        <div class="bg-white rounded-3xl border border-slate-100 shadow-lg shadow-slate-200/50 p-6 sm:p-8 min-h-[500px] relative overflow-hidden">

            <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#99cc33]/5 rounded-full blur-3xl pointer-events-none"></div>

            <transition name="fade" mode="out-in">

                <div :key="activeTab" class="relative z-10">

                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="p-3 bg-[#99cc33]/10 rounded-2xl text-[#99cc33]">
                            <component :is="tabs.find(t => t.id === activeTab)?.icon" class="w-8 h-8" />
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800">Pengaturan {{ getTabLabel() }}</h3>
                            <p class="text-sm text-slate-500">Kelola konten dan file untuk bagian ini</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        <div class="space-y-6">

                            <div v-if="['alur', 'persyaratan', 'panduan'].includes(activeTab)">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi / Penjelasan</label>
                                <textarea
                                    v-model="(form as any)[activeTab === 'alur' ? 'alur_description' : (activeTab === 'persyaratan' ? 'requirement_description' : 'guide_description')]"
                                    rows="6"
                                    class="w-full rounded-xl border-[#d0f18e] bg-slate-50 ring-1 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33] transition-all text-slate-700 placeholder:text-slate-400 resize-none p-4"
                                    placeholder="Masukkan penjelasan detail di sini..."
                                ></textarea>
                            </div>

                            <div v-if="['template', 'watermark'].includes(activeTab)" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Display</label>
                                    <input type="text" v-model="(form as any)[activeTab + '_title']" class="w-full px-4 py-3 rounded-xl border border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all outline-none text-slate-700 font-medium" />
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Info File (Size/Format)</label>
                                    <input type="text" v-model="(form as any)[activeTab + '_info']" class="w-full px-4 py-3 rounded-xl border border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all outline-none text-slate-700 font-medium" />
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Instruksi Penggunaan</label>
                                    <textarea v-model="(form as any)[activeTab + '_instruction']" rows="4" class="w-full px-4 py-3 rounded-xl border border-[#d0f18e] focus:border-[#99cc33] ring-1 focus:ring-2 focus:ring-[#99cc33] transition-all resize-none"></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Upload File {{ activeTab === 'alur' ? 'Gambar' : 'PDF/Dokumen' }}
                                </label>
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-[#99cc33]/5 hover:border-[#99cc33] transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-slate-400 group-hover:text-[#99cc33] transition-colors">
                                        <UploadCloud class="w-8 h-8 mb-2" />
                                        <p class="text-sm font-medium">Klik untuk ganti file</p>
                                        <p class="text-xs opacity-70 mt-1">
                                            {{ activeTab === 'alur' ? 'PNG, JPG' : 'PDF Only' }} (Max 5MB)
                                        </p>
                                    </div>
                                    <input
                                        type="file"
                                        class="hidden"
                                        :accept="activeTab === 'alur' ? 'image/*' : 'application/pdf, .doc, .docx'"
                                        @change="handleFileChange(
                                            activeTab === 'alur' ? 'alur_image' :
                                            activeTab === 'persyaratan' ? 'requirement_file' :
                                            activeTab === 'panduan' ? 'guide_file' :
                                            activeTab + '_file',
                                            $event
                                        )"
                                    />
                                </label>

                                <p v-if="(form as any)[
                                    activeTab === 'alur' ? 'alur_image' :
                                    activeTab === 'persyaratan' ? 'requirement_file' :
                                    activeTab === 'panduan' ? 'guide_file' :
                                    activeTab + '_file'
                                ]" class="mt-2 text-sm text-[#99cc33] font-bold flex items-center gap-1">
                                    <CheckSquare class="w-4 h-4"/>
                                    File baru dipilih:
                                    {{
                                        (form as any)[
                                            activeTab === 'alur' ? 'alur_image' :
                                            activeTab === 'persyaratan' ? 'requirement_file' :
                                            activeTab === 'panduan' ? 'guide_file' :
                                            activeTab + '_file'
                                        ]?.name
                                    }}
                                </p>
                            </div>

                            <button @click="submitSettings" :disabled="form.processing" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#99cc33] hover:bg-[#88b82d] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-[#99cc33]/30 hover:shadow-[#99cc33]/50 transition-all active:scale-95">
                                <Save class="w-4 h-4"/> Simpan Perubahan
                            </button>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 h-full min-h-[500px] flex flex-col relative overflow-hidden">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 z-10 flex items-center gap-2">
                                <CheckSquare class="w-3 h-3"/> Preview File Aktif
                            </p>

                            <div class="flex-1 flex flex-col items-center justify-center rounded-xl bg-white shadow-sm border border-slate-100 p-2 z-10 w-full text-center overflow-hidden">

                                <div v-if="getCurrentFilePath()" class="w-full h-full flex flex-col items-center justify-center">

                                    <img
                                        v-if="activeTab === 'alur'"
                                        :src="getCurrentFilePath()"
                                        class="max-w-full max-h-[400px] object-contain rounded-lg"
                                        alt="Preview"
                                    />

                                    <div v-else-if="isPdf" class="w-full h-full min-h-[500px] relative">
                                        <embed
                                            :src="getCurrentFilePath()"
                                            type="application/pdf"
                                            class="w-full h-full rounded-lg border border-slate-100"
                                        />
                                    </div>

                                    <div v-else class="flex flex-col items-center gap-4 py-10">
                                        <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center border border-blue-100">
                                            <FileType class="w-10 h-10" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 text-lg">Format Dokumen (.doc/.docx)</p>
                                            <p class="text-sm text-slate-400 mb-6 max-w-xs mx-auto">
                                                Preview tidak tersedia untuk format ini. Silakan download untuk melihat isinya.
                                            </p>

                                            <a :href="getCurrentFilePath()" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors shadow-lg shadow-slate-200">
                                                <Download class="w-4 h-4" /> Download File
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="flex flex-col items-center text-slate-300">
                                    <div class="p-4 bg-slate-50 rounded-full mb-3">
                                        <component :is="activeTab === 'alur' ? ImageIcon : FileText" class="w-12 h-12 opacity-30" />
                                    </div>
                                    <span class="text-base font-medium">Belum ada file yang diupload</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </transition>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}
.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>
