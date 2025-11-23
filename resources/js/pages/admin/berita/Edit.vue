<script setup lang="ts">
import ArticleForm from '@/components/admin/ArticleForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { AlertCircle, CheckCircle2, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Edit Berita',
                subTitle: 'Perbarui informasi berita perpustakaan',
            },
            { default: () => page },
        ),
});

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
});

// --- STATE ---
const page = usePage<any>();
const successMessage = computed(() => page.props.flash?.success);
const showSuccess = ref(false);

// Data lokal untuk v-model ke ArticleForm
// Kita inisialisasi dengan data dari props
const articleData = ref({
    title: props.article.judul,
    content: props.article.content,
    status: props.article.status,
    date: props.article.created_date,
    // Thumbnail URL untuk preview, File object untuk upload baru
    thumbnail: null as File | null,
    url_thumbnail: props.article.url_thumbnail || null,
    attachment: null as File | null,
    created_by: props.article.created_by,
});

// Form Inertia
const form = useForm({
    _method: 'PUT', // Penting untuk spoofing method di Laravel saat upload file
    judul: props.article.judul,
    content: props.article.content,
    status: props.article.status,
    date: props.article.created_date,
    thumbnail: null as File | null,
    attachment: null as File | null,
    created_by: props.article.created_by,
});

// --- WATCHER: Sync Local State to Inertia Form ---
watch(
    articleData,
    (newVal) => {
        form.judul = newVal.title;
        form.content = newVal.content;
        form.status = newVal.status;
        form.date = newVal.date;
        form.thumbnail = newVal.thumbnail;
        form.attachment = newVal.attachment;
        // Note: created_by biasanya tidak diubah di edit, tapi kita biarkan sync
    },
    { deep: true },
);

// --- ACTIONS ---
const handleSubmit = () => {
    // Menggunakan POST dengan _method: PUT adalah cara standar Laravel menangani File Upload pada Edit
    form.post(`/admin/berita/update/${props.article.article_id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            // Tampilkan notifikasi sukses
            showSuccess.value = true;

            // Auto hide notifikasi
            setTimeout(() => {
                showSuccess.value = false;
            }, 5000);

            // Jangan reset form di halaman edit agar data tetap terlihat
        },
        onError: (errors) => {
            console.error('Validasi gagal:', errors);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    });
};
</script>

<template>
    <div class="relative">
        <!-- 1. Notifikasi Sukses (Floating/Sticky) -->
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="successMessage || showSuccess"
                class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm"
            >
                <CheckCircle2 class="mt-0.5 h-5 w-5 text-emerald-600" />
                <div class="flex-1">
                    <h4 class="text-sm font-bold">Perubahan Disimpan!</h4>
                    <p class="text-sm opacity-90">
                        {{
                            successMessage || 'Data berita berhasil diperbarui.'
                        }}
                    </p>
                </div>
                <button
                    @click="showSuccess = false"
                    class="text-emerald-600 hover:text-emerald-800"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>
        </transition>

        <!-- 2. Notifikasi Error (Jika ada error validasi global) -->
        <transition name="fade">
            <div
                v-if="Object.keys(form.errors).length > 0"
                class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800 shadow-sm"
            >
                <AlertCircle class="mt-0.5 h-5 w-5 text-rose-600" />
                <div>
                    <h4 class="text-sm font-bold">Gagal Menyimpan</h4>
                    <p class="mb-2 text-sm opacity-90">
                        Mohon periksa kembali isian formulir berikut:
                    </p>
                    <ul
                        class="list-inside list-disc space-y-1 text-xs opacity-80"
                    >
                        <li v-for="(msg, key) in form.errors" :key="key">
                            {{ msg }}
                        </li>
                    </ul>
                </div>
            </div>
        </transition>

        <!-- 3. Komponen Form Utama -->
        <!-- Container putih dihapus di sini karena ArticleForm sudah punya style card sendiri -->
        <ArticleForm
            v-model="articleData"
            :show-attachment="false"
            back-href="/admin/berita"
            @submit="handleSubmit"
        />

        <!-- 4. Loading Overlay (Full Screen Blocker) -->
        <transition name="fade">
            <div
                v-if="form.processing"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
            >
                <div
                    class="mx-4 flex w-full max-w-sm flex-col items-center justify-center rounded-2xl bg-white p-8 text-center shadow-2xl"
                >
                    <!-- Spinner -->
                    <div class="relative mb-4">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-slate-100"
                        ></div>
                        <div
                            class="relative h-12 w-12 animate-spin rounded-full border-4 border-[#99cc33] border-t-transparent"
                        ></div>
                    </div>

                    <h3 class="mb-1 text-lg font-bold text-slate-800">
                        Sedang Memproses
                    </h3>
                    <p class="mb-4 text-sm text-slate-500">
                        Mohon tunggu, sedang menyimpan perubahan...
                    </p>

                    <!-- Progress Bar (Optional) -->
                    <div
                        v-if="form.progress"
                        class="h-2 w-full overflow-hidden rounded-full bg-slate-100"
                    >
                        <div
                            class="h-full bg-[#99cc33] transition-all duration-300"
                            :style="{ width: form.progress.percentage + '%' }"
                        ></div>
                    </div>
                    <p
                        v-if="form.progress"
                        class="mt-2 text-xs font-medium text-slate-400"
                    >
                        {{ form.progress.percentage }}% Terunggah
                    </p>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
