<script setup>
import ArticleForm from '@/components/admin/ArticleForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Buat Berita Baru',
                subTitle: 'Kelola konten berita perpustakaan baru',
            },
            { default: () => page },
        ),
});

const page = usePage();
const successMessage = computed(() => page.props.flash?.success || null);

const article = ref({
    title: '',
    content: '',
    status: 'draft',
    date: new Date().toISOString().slice(0, 10),
    thumbnail: null,
    attachment: null,
});

const form = useForm({
    judul: '',
    content: '',
    status: 'draft',
    date: '',
    thumbnail: null,
    attachment: null,
});

watch(
    article,
    (newVal) => {
        form.judul = newVal.title;
        form.content = newVal.content;
        form.status = newVal.status;
        form.date = newVal.date;
        form.thumbnail = newVal.thumbnail;
        form.attachment = newVal.attachment;
    },
    { deep: true },
);

const handleSubmit = () => {
    form.post('/admin/berita/store', {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            article.value = {
                title: '',
                content: '',
                status: 'draft',
                date: new Date().toISOString().slice(0, 10),
                thumbnail: null,
                attachment: null,
            };
        },
        onError: (errors) => console.error('Validasi gagal:', errors),
    });
};
</script>

<template>
    <!-- Notifikasi Sukses -->
    <transition name="fade">
        <div
            v-if="successMessage"
            class="mb-4 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-green-700 shadow-sm"
        >
            ✅ {{ successMessage }}
        </div>
    </transition>
    <div class="relative rounded-xl bg-white p-6 shadow">
        <!-- Komponen Form -->
        <ArticleForm
            v-model="article"
            :show-attachment="false"
            @submit="handleSubmit"
        />

        <!-- Pesan Error Validasi -->
        <div
            v-if="Object.keys(form.errors).length"
            class="mt-6 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700"
        >
            <p class="mb-2 font-semibold">Terdapat kesalahan:</p>
            <ul class="ml-4 list-disc space-y-1">
                <li v-for="(msg, key) in form.errors" :key="key">{{ msg }}</li>
            </ul>
        </div>

        <!-- Progress Upload -->
        <div v-if="form.progress" class="mt-4 text-sm text-gray-600">
            Mengunggah... {{ Math.round(form.progress.percentage) }}%
        </div>

        <!-- Modal Loading -->
        <transition name="fade">
            <div
                v-if="form.processing"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
            >
                <div
                    class="flex flex-col items-center rounded-lg bg-white px-8 py-6 shadow-xl"
                >
                    <svg
                        class="h-10 w-10 animate-spin text-emerald-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z"
                        ></path>
                    </svg>
                    <p class="mt-4 text-sm font-medium text-gray-600">
                        Menyimpan berita...
                    </p>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
