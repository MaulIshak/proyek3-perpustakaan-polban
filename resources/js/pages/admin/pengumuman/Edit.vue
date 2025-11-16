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
                title: 'Edit Pengumuman',
                subTitle: 'Perbarui informasi pengumuman perpustakaan',
            },
            { default: () => page },
        ),
});

const props = defineProps({
    article: Object,
});

const article = ref({
    title: props.article.judul,
    content: props.article.content,
    status: props.article.status,
    date: props.article.created_date,
    url_thumbnail: props.article.url_thumbnail || null,
    url_attachment: props.article.url_attachment || null,
});

const form = useForm({
    judul: props.article.judul,
    content: props.article.content,
    status: props.article.status,
    date: props.article.created_date,
    url_thumbnail: props.article.url_thumbnail || null,
    url_attachment: props.article.url_attachment || null,
});

watch(
    article,
    (newVal) => {
        form.judul = newVal.title;
        form.content = newVal.content;
        form.status = newVal.status;
        form.date = newVal.date;
        form.url_thumbnail = newVal.url_thumbnail;
        form.url_attachment = newVal.url_attachment;
    },
    { deep: true },
);

const handleSubmit = () => {
    form.post(`/admin/pengumuman/update/${props.article.article_id}`, {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <div class="rounded-xl bg-white p-6 shadow">
        <ArticleForm
            v-model="article"
            @submit="handleSubmit"
            :show-attachment="true"
            back-href="/admin/pengumuman"
        />
    </div>
</template>
