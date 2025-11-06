<script setup>
import ArticleForm from '@/components/admin/ArticleForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

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

// Data model untuk v-model di komponen form
const article = ref({
    title: '',
    content: '',
    status: 'draft',
    date: new Date().toISOString().slice(0, 10),
    thumbnail: null,
    attachment: null,
});

// Ubah struktur form untuk mencocokkan dengan validasi backend
const form = useForm({
    judul: '', // sesuaikan dengan nama field di backend
    content: '',
    status: 'draft',
    date: '',
    thumbnail: null,
    attachment: null,
});

// Sinkronisasi data dari article ke form
watch(
    article,
    (newVal) => {
        form.judul = newVal.title; // title -> judul
        form.content = newVal.content;
        form.status = newVal.status;
        form.date = newVal.date;
        form.thumbnail = newVal.thumbnail;
        form.attachment = newVal.attachment;
    },
    { deep: true },
); // tambahkan deep: true untuk memastikan perubahan terdeteksi

// Handle submit dari child component
const handleSubmit = () => {
    form.post('/admin/berita/store', {
        forceFormData: true, // penting agar file dikirim sebagai multipart/form-data
        onSuccess: () => {
            // Reset form dan tampilkan notifikasi
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
        onError: (errors) => {
            console.error('Validasi gagal:', errors);
        },
    });
};
</script>

<template>
    <div class="rounded-xl bg-white p-6 shadow">
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
    </div>
</template>
