<script setup>
import ArticleForm from '@/components/admin/ArticleForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ref } from 'vue';

const article = ref({
    title: '',
    content: '',
    status: 'draft',
    date: new Date().toISOString().slice(0, 10),
    thumbnail: null,
    attachment: null,
});

const handleSubmit = (data) => {
    console.log('Data form:', data);
    // Kirim ke server via Inertia atau Axios
};
</script>

<template>
    <AdminLayout
        title="Buat Berita Baru"
        subTitle="Kelola konten berita perpustakaan baru"
    >
        <div class="rounded-xl bg-white p-6 shadow">
            <ArticleForm
                v-model="article"
                :show-attachment="false"
                @submit="handleSubmit"
            />
        </div>
    </AdminLayout>
</template>
