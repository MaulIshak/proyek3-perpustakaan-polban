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
                Gambar Header
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
                    class="block w-full rounded-lg border-gray-300 p-4 text-lg shadow-sm focus:border-[var(--primary-green)] focus:ring-2 focus:ring-[var(--primary-green)]"
                    placeholder="Masukkan judul artikel..."
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
                    toolbar="minimal"
                    contentType="html"
                    placeholder="Tulis isi di sini..."
                    name="content"
                />
            </div>
        </div>

        <!-- Grid untuk Tanggal & Status -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                        :class="[
                            'block w-full rounded-lg p-4 text-base font-semibold shadow-sm focus:ring-2',
                            articleData.status === 'draft'
                                ? 'border-yellow-300 bg-yellow-50 text-yellow-700 focus:ring-yellow-500'
                                : 'border-green-300 bg-green-50 text-green-700 focus:ring-green-500',
                        ]"
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
                class="text-md mr-3 inline-flex justify-center rounded-md border border-transparent bg-gray-400 px-4 py-2 font-medium text-white shadow-sm hover:bg-red-500"
            >
                Batal
            </a>
            <button
                type="submit"
                class="text-md inline-flex justify-center rounded-md border border-transparent bg-[var(--primary-green)] px-4 py-2 font-medium text-white shadow-sm hover:bg-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:outline-none"
            >
                Simpan
            </button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onMounted, onUnmounted, ref, watch } from 'vue';

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

// v-model artikel (bisa dari create atau edit)
const articleData = defineModel({
    type: Object,
    required: true,
});

// Emit submit
const emit = defineEmits(['submit']);

// State thumbnail
const thumbnailPreviewUrl = ref<string | null>(null);
const thumbnailInput = ref<HTMLInputElement | null>(null);

// Saat komponen dimount (untuk halaman edit)
onMounted(() => {
    console.log(articleData.value);
    // Jika ada thumbnail lama, tampilkan
    if (articleData.value.url_thumbnail) {
        thumbnailPreviewUrl.value = articleData.value.url_thumbnail;
    }
});

// Jika artikel berubah (misalnya data async dari Inertia)
watch(
    () => articleData.value.thumbnail_url,
    (newUrl) => {
        if (newUrl && !thumbnailPreviewUrl.value) {
            thumbnailPreviewUrl.value = newUrl;
        }
    },
);

// Handle upload thumbnail baru
function handleThumbnailChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (!file || !file.type.startsWith('image/')) {
        clearThumbnail();
        return;
    }

    articleData.value.thumbnail = file;

    // Hapus preview lama
    if (
        thumbnailPreviewUrl.value &&
        thumbnailPreviewUrl.value.startsWith('blob:')
    ) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }

    // Buat preview baru dari file upload
    thumbnailPreviewUrl.value = URL.createObjectURL(file);
}

// Hapus thumbnail
function clearThumbnail() {
    articleData.value.thumbnail = null;
    if (
        thumbnailPreviewUrl.value &&
        thumbnailPreviewUrl.value.startsWith('blob:')
    ) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
    thumbnailPreviewUrl.value = null;

    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
    }
}

// Buka dialog file
function triggerThumbnailClick() {
    if (thumbnailInput.value) {
        thumbnailInput.value.value = '';
        thumbnailInput.value.click();
    }
}

// Lampiran opsional
function handleAttachmentChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    articleData.value.attachment = file || null;
}

// Submit
function handleSubmit() {
    emit('submit', articleData.value);
}

// Cleanup URL preview
onUnmounted(() => {
    if (
        thumbnailPreviewUrl.value &&
        thumbnailPreviewUrl.value.startsWith('blob:')
    ) {
        URL.revokeObjectURL(thumbnailPreviewUrl.value);
    }
});
</script>

<style>
.article-content-editor .ql-toolbar.ql-snow,
.article-content-editor .ql-container.ql-snow {
    border-color: #d1d5db !important; /* same as Tailwind gray-300 */
    border-radius: 0.5rem;
}

/* Fokus gunakan warna hijau aplikasi, bukan biru Quill */
.article-content-editor .ql-toolbar.ql-snow:focus-within,
.article-content-editor .ql-container.ql-snow:focus-within {
    border-color: var(--primary-green) !important;
    box-shadow: 0 0 0 2px var(--primary-green) !important;
}

/* Placeholder */
.article-content-editor .ql-editor.ql-blank::before {
    font-style: normal;
    color: #9ca3af; /* gray-400 */
    font-size: 0.9rem;
}

/* Font ukuran sama dengan input lainnya */
.article-content-editor .ql-editor {
    font-size: 0.95rem;
    line-height: 1.6;
}
</style>
