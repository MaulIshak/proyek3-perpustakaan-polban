<script setup>
import ArticlePage from '@/components/ArticlePage.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Judul Halaman',
                subTitle: 'Subjudul Halaman',
            },
            { default: () => page },
        ),
});

const article = defineProps({
    article: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <ArticlePage
        :article="{
            title: article.article.judul,
            imageUrl: article.article.url_thumbnail,
            content: article.article.content,
            publishedAt: article.article.created_date,
        }"
    />
</template>
