<script setup lang="ts">
import PaginationLink from '@/components/admin/PaginationLink.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import {
    Copy,
    ExternalLink,
    FileSearch,
    Image as ImageIcon,
    Pencil,
    Plus,
    RotateCcw,
    Save,
    Search,
    Trash2,
    UploadCloud,
    X,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

// Import ConfirmModal
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

const props = defineProps<{
    collections: {
        data: any[];
        links: any[];
    };
    searchQuery: string;
}>();

// Layout
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'E-Collection',
                subTitle: 'Kelola daftar koleksi digital dan referensi',
            },
            { default: () => page },
        ),
});

// --- SEARCH LOGIC ---
const search = ref(props.searchQuery || '');

watch(
    search,
    debounce((value: string) => {
        router.get(
            '/admin/e-collections',
            { search: value },
            { preserveState: true, replace: true },
        );
    }, 300),
);

// --- MODAL & FORM LOGIC ---
const isModalOpen = ref(false);
const isEditMode = ref(false);
const imagePreview = ref<string | null>(null);
const fileInputRef = ref<HTMLInputElement | null>(null);

const form = useForm({
    id: null as number | null,
    title: '',
    url: '',
    description: '',
    is_active: true,
    image: null as File | null,
    _method: 'POST',
});

const { open } = useConfirmModal();

const openCreate = () => {
    isEditMode.value = false;
    form.reset();
    form.clearErrors();
    form._method = 'POST';
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEdit = (item: any) => {
    isEditMode.value = true;
    form.clearErrors();
    form.id = item.id;
    form.title = item.title;
    form.url = item.url;
    form.description = item.description;
    form.is_active = Boolean(item.is_active);
    form.image = null;
    form._method = 'POST'; // Inertia handles multipart via POST with _method PUT if needed, but mostly POST for files
    imagePreview.value = item.image_path;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => {
        form.reset();
        imagePreview.value = null;
    }, 300);
};

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const triggerFileInput = () => {
    fileInputRef.value?.click();
};

const submit = () => {
    const url = isEditMode.value
        ? `/admin/e-collections/${form.id}`
        : '/admin/e-collections';
    form.post(url, {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    });
};

const handleDelete = (item: any) => {
    open({
        title: 'Hapus Koleksi?',
        message: `Apakah Anda yakin ingin menghapus koleksi "${item.title}"?`,
        actionLabel: 'Hapus',
        // confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
        onConfirm: () => {
            router.delete(`/admin/e-collections/${item.id}`, {
                preserveScroll: true,
            });
        },
    });
};

// Helper Copy HTML
const copySnippet = (type: 'blue' | 'yellow') => {
    let text = '';
    if (type === 'blue')
        text =
            '<h4 class="text-[#00637b] font-bold text-sm mb-1 mt-4">Judul Sub-Bab</h4>';
    if (type === 'yellow')
        text =
            '<div class="bg-amber-50 p-3 border-l-4 border-amber-400 text-xs text-amber-800 mt-4 rounded-r-md">Info penting...</div>';
    navigator.clipboard.writeText(text);
    // Optional toast here
};

// Helper Strip HTML
const stripHtml = (html: string) => {
    return html ? html.replace(/<[^>]*>?/gm, '') : '';
};
</script>

<template>
    <Head title="E-Collection" />

    <div class="space-y-8 font-sans text-slate-600">
        <!-- 1. Toolbar -->
        <div
            class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row"
        >
            <!-- Search Input -->
            <div class="group relative w-full sm:max-w-md">
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition-colors group-focus-within:text-[#99cc33]"
                >
                    <Search class="h-5 w-5" />
                </div>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari koleksi..."
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pr-3 pl-10 leading-5 placeholder-slate-400 transition-all focus:border-[#99cc33] focus:bg-white focus:ring-4 focus:ring-[#99cc33]/10 focus:outline-none sm:text-sm"
                />
            </div>

            <!-- Create Button -->
            <button
                @click="openCreate"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                <span>Buat Koleksi Baru</span>
            </button>
        </div>

        <!-- 2. Content Grid -->
        <div
            v-if="collections.data.length > 0"
            class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <div
                v-for="item in collections.data"
                :key="item.id"
                class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/40 hover:shadow-xl"
            >
                <!-- Image Area -->
                <div
                    class="relative flex h-40 items-center justify-center overflow-hidden border-b border-slate-100 bg-slate-50 p-4"
                >
                    <img
                        v-if="item.image_path"
                        :src="item.image_path"
                        class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-110"
                        alt="Collection Logo"
                    />
                    <div
                        v-else
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-slate-300 shadow-sm"
                    >
                        <ImageIcon class="h-8 w-8" />
                    </div>

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <span
                            class="rounded-lg border px-2 py-1 text-[10px] font-bold tracking-wide uppercase shadow-sm"
                            :class="
                                item.is_active
                                    ? 'border-emerald-200 bg-emerald-100 text-emerald-700'
                                    : 'border-slate-200 bg-slate-100 text-slate-500'
                            "
                        >
                            {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-1 flex-col p-5">
                    <h3
                        class="mb-2 line-clamp-1 text-lg font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                        :title="item.title"
                    >
                        {{ item.title }}
                    </h3>
                    <p
                        class="mb-4 line-clamp-3 flex-1 text-sm leading-relaxed text-slate-500"
                    >
                        {{ stripHtml(item.description) }}
                    </p>

                    <!-- Footer Actions -->
                    <div
                        class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4"
                    >
                        <a
                            v-if="item.url"
                            :href="item.url"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-sky-600 transition-colors hover:text-sky-700 hover:underline"
                        >
                            <ExternalLink class="h-3.5 w-3.5" /> Kunjungi
                        </a>
                        <span v-else class="text-xs text-slate-400 italic"
                            >No Link</span
                        >

                        <div class="flex items-center gap-2">
                            <button
                                @click="openEdit(item)"
                                class="rounded-lg border border-amber-100 bg-amber-50 p-2 text-amber-600 shadow-sm transition-colors hover:bg-amber-100"
                                title="Edit"
                            >
                                <Pencil class="h-4 w-4" />
                            </button>
                            <button
                                @click="handleDelete(item)"
                                class="rounded-lg border border-rose-100 bg-rose-50 p-2 text-rose-600 shadow-sm transition-colors hover:bg-rose-100"
                                title="Hapus"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Empty State -->
        <div
            v-else
            class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-white py-20 text-center"
        >
            <div
                class="mb-4 flex h-20 w-20 animate-pulse items-center justify-center rounded-full bg-slate-50"
            >
                <FileSearch class="h-10 w-10 text-slate-400" />
            </div>
            <h3 class="mb-2 text-xl font-bold text-slate-800">
                {{ search ? 'Koleksi Tidak Ditemukan' : 'Belum Ada Koleksi' }}
            </h3>
            <p class="max-w-sm text-sm leading-relaxed text-slate-500">
                {{
                    search
                        ? 'Coba gunakan kata kunci lain.'
                        : 'Mulai tambahkan koleksi digital pertama Anda.'
                }}
            </p>
            <button
                v-if="!search"
                @click="openCreate"
                class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
            >
                Buat Koleksi Baru
            </button>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            <PaginationLink :links="collections.links" />
        </div>

        <!-- MODAL FORM -->
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="isModalOpen"
                class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-6"
            >
                <div
                    @click="closeModal"
                    class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
                ></div>

                <div
                    class="relative z-10 flex max-h-[90vh] w-full max-w-lg transform flex-col overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                >
                    <!-- Modal Header -->
                    <div
                        class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-6 py-4"
                    >
                        <h2 class="text-lg font-bold text-slate-800">
                            {{
                                isEditMode
                                    ? 'Edit Koleksi'
                                    : 'Buat Koleksi Baru'
                            }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="rounded-full p-1 text-slate-400 transition-colors hover:bg-slate-200 hover:text-slate-600"
                        >
                            <X class="h-6 w-6" />
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex-1 space-y-6 overflow-y-auto bg-white p-6">
                        <!-- Title & URL -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                    >Judul Koleksi</label
                                >
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full rounded-xl border-slate-200 transition-all focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                    placeholder="Contoh: Emerald Insight"
                                />
                                <p
                                    v-if="form.errors.title"
                                    class="mt-1 text-xs font-medium text-rose-500"
                                >
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                    >Link URL</label
                                >
                                <input
                                    v-model="form.url"
                                    type="url"
                                    class="w-full rounded-xl border-slate-200 transition-all focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                    placeholder="https://..."
                                />
                            </div>
                        </div>

                        <!-- Image Upload Dropzone -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-bold text-slate-700"
                                >Logo / Gambar</label
                            >
                            <div
                                @click="triggerFileInput"
                                class="group relative flex h-32 w-full cursor-pointer items-center justify-center rounded-xl border-2 border-dashed bg-slate-50 transition-all hover:bg-[#99cc33]/5"
                                :class="
                                    imagePreview
                                        ? 'border-slate-300'
                                        : 'border-slate-300 hover:border-[#99cc33]'
                                "
                            >
                                <div
                                    v-if="imagePreview"
                                    class="relative flex h-full w-full items-center justify-center p-2"
                                >
                                    <img
                                        :src="imagePreview"
                                        class="max-h-full max-w-full object-contain"
                                    />
                                    <!-- Edit Overlay -->
                                    <div
                                        class="absolute inset-0 flex flex-col items-center justify-center rounded-lg bg-black/40 text-white opacity-0 backdrop-blur-[1px] transition-opacity group-hover:opacity-100"
                                    >
                                        <RotateCcw class="mb-1 h-6 w-6" />
                                        <span class="text-xs font-bold"
                                            >Ganti</span
                                        >
                                    </div>
                                </div>
                                <div
                                    v-else
                                    class="flex flex-col items-center text-slate-400 transition-colors group-hover:text-[#99cc33]"
                                >
                                    <UploadCloud class="mb-1 h-8 w-8" />
                                    <span class="text-xs font-bold"
                                        >Upload Logo</span
                                    >
                                </div>
                                <input
                                    ref="fileInputRef"
                                    type="file"
                                    @change="handleImageUpload"
                                    accept="image/*"
                                    class="hidden"
                                />
                            </div>
                            <p class="mt-1 ml-1 text-xs text-slate-400">
                                Format: JPG, PNG. Max 2MB.
                            </p>
                        </div>

                        <!-- Description & Helper -->
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label
                                    class="block text-sm font-bold text-slate-700"
                                    >Deskripsi</label
                                >
                                <div class="flex gap-2">
                                    <button
                                        type="button"
                                        @click="copySnippet('blue')"
                                        class="flex items-center gap-1 rounded-md border border-sky-100 bg-sky-50 px-2 py-1 text-[10px] font-bold text-sky-600 transition-colors hover:bg-sky-100"
                                    >
                                        <Copy class="h-3 w-3" /> Header Biru
                                    </button>
                                    <button
                                        type="button"
                                        @click="copySnippet('yellow')"
                                        class="flex items-center gap-1 rounded-md border border-amber-100 bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-600 transition-colors hover:bg-amber-100"
                                    >
                                        <Copy class="h-3 w-3" /> Box Kuning
                                    </button>
                                </div>
                            </div>
                            <textarea
                                v-model="form.description"
                                rows="5"
                                class="w-full resize-none rounded-xl border-slate-200 font-mono text-xs leading-relaxed text-slate-600 transition-all focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                placeholder="Isi deskripsi atau kode HTML sederhana..."
                            ></textarea>
                        </div>

                        <!-- Active Toggle -->
                        <div
                            class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-4"
                        >
                            <span class="text-sm font-bold text-slate-700"
                                >Status Aktif</span
                            >
                            <label
                                class="relative inline-flex cursor-pointer items-center"
                            >
                                <input
                                    type="checkbox"
                                    v-model="form.is_active"
                                    class="peer sr-only"
                                />
                                <div
                                    class="peer h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#99cc33] peer-focus:outline-none after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"
                                ></div>
                            </label>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 p-6"
                    >
                        <button
                            @click="closeModal"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 shadow-sm transition-colors hover:bg-slate-100"
                        >
                            Batal
                        </button>
                        <button
                            @click="submit"
                            :disabled="form.processing"
                            class="flex items-center gap-2 rounded-xl bg-[#99cc33] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            <Save class="h-4 w-4" />
                            {{
                                form.processing ? 'Menyimpan...' : 'Simpan Data'
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Confirm Modal -->
        <ConfirmModal />
    </div>
</template>
