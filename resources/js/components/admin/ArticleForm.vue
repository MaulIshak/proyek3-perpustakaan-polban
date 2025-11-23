<script setup lang="ts">
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onMounted, onUnmounted, ref, watch } from 'vue';
import {
    ImagePlus,
    X,
    Save,
    ArrowLeft,
    FileText,
    UploadCloud,
    Trash2,
    RotateCcw,
    CheckCircle2,
    AlertCircle
} from 'lucide-vue-next';

// Props
const props = defineProps({
    showAttachment: {
        type: Boolean,
        default: true,
    },
    backHref: {
        type: String,
        default: '/admin/berita',
    },
});

// v-model artikel (Vue 3.4+)
const articleData = defineModel<{
    title: string;
    content: string;
    status: string;
    thumbnail: File | null;
    url_thumbnail?: string;
    attachment?: File | null;
    [key: string]: any;
}>({
    required: true,
});

// Emit submit
const emit = defineEmits(['submit']);

// State thumbnail
const thumbnailPreviewUrl = ref<string | null>(null);
const thumbnailInput = ref<HTMLInputElement | null>(null);

// Saat komponen dimount
onMounted(() => {
    if (articleData.value.url_thumbnail) {
        thumbnailPreviewUrl.value = articleData.value.url_thumbnail;
    }
});

// Watcher untuk perubahan eksternal
watch(
    () => articleData.value.url_thumbnail,
    (newUrl) => {
        if (newUrl && !thumbnailPreviewUrl.value) {
            thumbnailPreviewUrl.value = newUrl;
        }
    },
);

// Handle upload thumbnail
function handleThumbnailChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (!file || !file.type.startsWith('image/')) {
        return;
    }

    articleData.value.thumbnail = file;

    // Revoke old blob if exists
    if (thumbnailPreviewUrl.value && thumbnailPreviewUrl.value.startsWith('blob:')) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }

    // Create new preview
    thumbnailPreviewUrl.value = URL.createObjectURL(file);
}

// Hapus thumbnail
function clearThumbnail() {
    articleData.value.thumbnail = null;
    if (thumbnailPreviewUrl.value && thumbnailPreviewUrl.value.startsWith('blob:')) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
    // Jika url_thumbnail asli dari DB ada, kita biarkan null agar nanti di backend ditangani (misal hapus gambar)
    // Atau jika ingin reset ke gambar lama, logic-nya beda. Di sini asumsi clear = hapus.
    thumbnailPreviewUrl.value = null;

    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }
}

// Trigger input file
function triggerThumbnailClick() {
    thumbnailInput.value?.click();
}

// Handle lampiran
function handleAttachmentChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    articleData.value.attachment = file || null;
}

// Submit wrapper
function handleSubmit() {
    emit('submit', articleData.value);
}

// Cleanup
onUnmounted(() => {
    if (thumbnailPreviewUrl.value && thumbnailPreviewUrl.value.startsWith('blob:')) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
});
</script>

<template>
    <form @submit.prevent="handleSubmit" class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">

        <!-- Header Form (Optional Decorative Bar) -->
        <div class="h-1.5 w-full bg-gradient-to-r from-[#99cc33] to-[#7aace5]"></div>

        <div class="p-6 sm:p-8 lg:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                <!-- KOLOM KIRI: Thumbnail Upload (Lebar 4/12) -->
                <div class="lg:col-span-4 space-y-4">
                    <label class="block text-sm font-bold text-slate-700 mb-1">
                        Thumbnail / Gambar Utama
                    </label>

                    <!-- Input Hidden -->
                    <input
                        ref="thumbnailInput"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        @change="handleThumbnailChange"
                        name="thumbnail"
                    />

                    <!-- Preview Area -->
                    <div
                        class="group relative w-full aspect-video rounded-2xl overflow-hidden border-2 border-dashed transition-all duration-300 bg-slate-50"
                        :class="thumbnailPreviewUrl ? 'border-transparent shadow-md' : 'border-slate-300 hover:border-[#99cc33] hover:bg-[#99cc33]/5'"
                    >
                        <!-- Image Preview -->
                        <img
                            v-if="thumbnailPreviewUrl"
                            :src="thumbnailPreviewUrl"
                            alt="Preview"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />

                        <!-- Placeholder State -->
                        <div
                            v-else
                            @click="triggerThumbnailClick"
                            class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer text-slate-400 hover:text-[#99cc33] transition-colors"
                        >
                            <div class="p-3 bg-white rounded-full shadow-sm mb-2">
                                <ImagePlus class="w-8 h-8" />
                            </div>
                            <span class="text-xs font-semibold">Klik untuk unggah</span>
                            <span class="text-[10px] mt-1 opacity-60">JPG/PNG Max 2MB</span>
                        </div>

                        <!-- Hover Actions (Only if image exists) -->
                        <div
                            v-if="thumbnailPreviewUrl"
                            class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3"
                        >
                            <button
                                type="button"
                                @click="triggerThumbnailClick"
                                class="p-2 bg-white/20 hover:bg-white text-white hover:text-[#99cc33] rounded-full backdrop-blur-md transition-all"
                                title="Ganti Gambar"
                            >
                                <RotateCcw class="w-5 h-5" />
                            </button>
                            <button
                                type="button"
                                @click="clearThumbnail"
                                class="p-2 bg-white/20 hover:bg-red-500 text-white rounded-full backdrop-blur-md transition-all"
                                title="Hapus Gambar"
                            >
                                <Trash2 class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        *Disarankan menggunakan gambar rasio 16:9 agar tampilan optimal di halaman berita/artikel.
                    </p>
                </div>

                <!-- KOLOM KANAN: Meta Data & Content (Lebar 8/12) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Row 1: Title & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-bold text-slate-700 mb-2">
                                Judul Artikel
                            </label>
                            <input
                                id="title"
                                v-model="articleData.title"
                                type="text"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10 transition-all outline-none text-slate-700 placeholder:text-slate-400 font-medium"
                                placeholder="Masukkan judul yang menarik..."
                            />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-bold text-slate-700 mb-2">
                                Status Publikasi
                            </label>
                            <div class="relative">
                                <select
                                    id="status"
                                    v-model="articleData.status"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border appearance-none focus:ring-4 outline-none transition-all font-bold text-sm cursor-pointer"
                                    :class="articleData.status === 'published'
                                        ? 'border-emerald-200 bg-emerald-50 text-emerald-700 focus:ring-emerald-100'
                                        : 'border-amber-200 bg-amber-50 text-amber-700 focus:ring-amber-100'"
                                >
                                    <option value="draft">Draft (Konsep)</option>
                                    <option value="published">Published (Tayang)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <component
                                        :is="articleData.status === 'published' ? CheckCircle2 : AlertCircle"
                                        class="w-5 h-5"
                                        :class="articleData.status === 'published' ? 'text-emerald-500' : 'text-amber-500'"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Content Editor -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Isi Konten
                        </label>
                        <div class="article-content-editor rounded-xl overflow-hidden border border-slate-200 focus-within:border-[#99cc33] focus-within:ring-4 focus-within:ring-[#99cc33]/10 transition-all bg-white">
                            <QuillEditor
                                v-model:content="articleData.content"
                                theme="snow"
                                toolbar="minimal"
                                contentType="html"
                                placeholder="Mulai tulis artikel Anda di sini..."
                                style="min-height: 300px;"
                            />
                        </div>
                    </div>

                    <!-- Row 3: Attachment (Optional) -->
                    <div v-if="props.showAttachment" class="pt-4 border-t border-slate-100">
                        <label class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                            <FileText class="w-4 h-4 text-slate-400" />
                            Lampiran Dokumen (Opsional)
                        </label>

                        <div class="flex items-center gap-4">
                            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition-colors">
                                <UploadCloud class="w-4 h-4" />
                                Pilih File
                                <input
                                    type="file"
                                    class="hidden"
                                    @change="handleAttachmentChange"
                                />
                            </label>
                            <span v-if="articleData.attachment" class="text-sm text-[#99cc33] font-medium truncate max-w-[200px]">
                                {{ articleData.attachment.name }}
                            </span>
                            <span v-else class="text-sm text-slate-400 italic">
                                Belum ada file dipilih
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-slate-50 px-6 py-4 sm:px-10 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
            <a
                :href="backHref"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-slate-800 transition-all"
            >
                <ArrowLeft class="w-4 h-4" />
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-xl bg-[#99cc33] text-white font-bold text-sm shadow-lg shadow-[#99cc33]/30 hover:bg-[#88b82d] hover:shadow-[#99cc33]/50 hover:-translate-y-0.5 transition-all active:translate-y-0"
            >
                <Save class="w-4 h-4" />
                Simpan Artikel
            </button>
        </div>

    </form>
</template>

<style>
/* Quill Editor Customization for Modern Look */
.article-content-editor .ql-toolbar.ql-snow {
    border: none;
    border-bottom: 1px solid #e2e8f0; /* slate-200 */
    background-color: #f8fafc; /* slate-50 */
    padding: 12px;
}

.article-content-editor .ql-container.ql-snow {
    border: none;
    font-family: inherit; /* Use app font */
    font-size: 1rem;
}

.article-content-editor .ql-editor {
    padding: 20px;
    min-height: 300px;
    color: #334155; /* slate-700 */
    line-height: 1.7;
}

.article-content-editor .ql-editor.ql-blank::before {
    color: #94a3b8; /* slate-400 */
    font-style: normal;
}

/* Toolbar button hover effect */
.article-content-editor .ql-snow .ql-toolbar button:hover,
.article-content-editor .ql-snow .ql-toolbar button:focus {
    color: #99cc33;
}
.article-content-editor .ql-snow .ql-toolbar button.ql-active {
    color: #99cc33;
}
</style>
