<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Input File Thumbnail (Selalu ada di DOM) -->
        <input
            ref="thumbnailInput"
            type="file"
            class="hidden"
            accept="image/*"
            @change="handleThumbnailChange"
            name="thumbnail"
        />

        <!-- Bagian Thumbnail -->
        <div>
            <label class="block text-sm font-medium text-gray-500">
                Thumbnail
            </label>

            <div class="mt-1">
                <!-- Preview Gambar -->
                <div
                    v-if="thumbnailPreviewUrl"
                    class="group relative w-full sm:w-1/2 md:w-1/3"
                >
                    <img
                        :src="thumbnailPreviewUrl"
                        alt="Preview Thumbnail"
                        class="h-auto w-full rounded-md object-cover shadow-sm"
                    />
                    <div
                        class="absolute inset-0 flex items-center justify-center rounded-md bg-black/30 opacity-0 transition-opacity group-hover:opacity-100"
                    >
                        <button
                            type="button"
                            @click="triggerThumbnailClick"
                            class="mr-2 rounded-md bg-gray-500 px-3 py-1 text-xs text-white hover:bg-gray-800"
                        >
                            Ganti
                        </button>
                        <button
                            type="button"
                            @click="clearThumbnail"
                            class="rounded-md bg-red-600 px-3 py-1 text-xs text-white hover:bg-red-500"
                        >
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- Kotak Upload (jika belum ada gambar) -->
                <label
                    v-else
                    @click="triggerThumbnailClick"
                    class="mt-1 flex cursor-pointer justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 transition hover:border-emerald-500"
                >
                    <div class="space-y-1 text-center">
                        <svg
                            class="mx-auto h-12 w-12 text-gray-400"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 48 48"
                            aria-hidden="true"
                        >
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <div
                            class="flex items-center justify-center text-sm text-gray-600"
                        >
                            <span
                                class="font-medium text-emerald-600 hover:text-emerald-500"
                            >
                                Klik untuk mengunggah
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, GIF (Ukuran maks. 2MB)
                        </p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Judul Artikel -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-500">
                Judul
            </label>
            <div class="mt-1">
                <input
                    id="title"
                    v-model="articleData.title"
                    type="text"
                    required
                    class="block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 sm:text-sm"
                    placeholder="Masukkan judul..."
                    name="judul"
                />
            </div>
        </div>

        <!-- Konten (Rich Text Editor) -->
        <div>
            <label
                for="content"
                class="block text-sm font-medium text-gray-500"
            >
                Konten
            </label>
            <div class="article-content-editor mt-1">
                <QuillEditor
                    id="content"
                    v-model:content="articleData.content"
                    theme="snow"
                    toolbar="essential"
                    contentType="html"
                    placeholder="Tulis isi di sini..."
                    name="content"
                />
            </div>
        </div>

        <!-- Grid untuk Tanggal & Status -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Tanggal Publikasi -->
            <div>
                <label
                    for="date"
                    class="block text-sm font-medium text-gray-500"
                >
                    Tanggal Publikasi
                </label>
                <div class="mt-1">
                    <input
                        name="date"
                        id="date"
                        v-model="articleData.date"
                        type="date"
                        required
                        class="block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                    />
                </div>
            </div>

            <!-- Status -->
            <div>
                <label
                    for="status"
                    class="block text-sm font-medium text-gray-500"
                >
                    Status
                </label>
                <div class="mt-1">
                    <select
                        name="status"
                        id="status"
                        v-model="articleData.status"
                        required
                        class="block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                    >
                        <option value="draft">Draf</option>
                        <option value="published">Published</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Lampiran (Opsional) -->
        <div v-if="props.showAttachment">
            <label
                for="attachment"
                class="block text-sm font-medium text-gray-500"
            >
                Lampiran (Opsional)
            </label>
            <div class="mt-1">
                <input
                    name="attachment"
                    id="attachment"
                    type="file"
                    @change="handleAttachmentChange"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-500 hover:file:bg-emerald-100"
                />
                <p
                    v-if="articleData.attachment"
                    class="mt-2 text-sm text-gray-600"
                >
                    File terpilih:
                    <span class="font-medium">{{
                        articleData.attachment.name
                    }}</span>
                </p>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end border-t pt-6">
            <a
                :href="backHref"
                class="mr-3 inline-flex justify-center rounded-md border border-transparent bg-gray-400 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-500"
            >
                Batal
            </a>
            <button
                type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:outline-none"
            >
                Simpan
            </button>
        </div>
    </form>
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onUnmounted, ref } from 'vue';

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

// v-model artikel
const articleData = defineModel({
    type: Object,
    required: true,
});

// Emit submit
const emit = defineEmits(['submit']);

// State untuk thumbnail
const thumbnailPreviewUrl = ref(null);
const thumbnailInput = ref(null);

// Handle upload thumbnail
function handleThumbnailChange(event) {
    const file = event.target.files?.[0];
    if (!file || !file.type.startsWith('image/')) {
        clearThumbnail();
        return;
    }

    articleData.value.thumbnail = file;

    // Hapus preview lama jika ada
    if (thumbnailPreviewUrl.value) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }

    // Buat preview baru
    thumbnailPreviewUrl.value = URL.createObjectURL(file);
}

// Clear thumbnail
function clearThumbnail() {
    articleData.value.thumbnail = null;
    if (thumbnailPreviewUrl.value) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
    thumbnailPreviewUrl.value = null;

    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }
}

// Trigger file dialog
function triggerThumbnailClick() {
    if (thumbnailInput.value) {
        thumbnailInput.value.value = null; // reset supaya event change tetap bisa dipanggil
        thumbnailInput.value.click();
    }
}

// Handle lampiran opsional
function handleAttachmentChange(event) {
    const file = event.target.files?.[0];
    articleData.value.attachment = file || null;
}

// Submit
function handleSubmit() {
    emit('submit', articleData.value);
}

// Cleanup URL preview
onUnmounted(() => {
    if (thumbnailPreviewUrl.value) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
});
</script>

<style>
.article-content-editor .ql-toolbar.ql-snow {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    border-color: #d1d5db;
}
.article-content-editor .ql-container.ql-snow {
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
    border-color: #d1d5db;
    min-height: 250px;
    font-size: 0.875rem;
}
.article-content-editor .ql-toolbar.ql-snow:focus-within,
.article-content-editor .ql-container.ql-snow:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px #3b82f6;
    z-index: 10;
}
</style>
