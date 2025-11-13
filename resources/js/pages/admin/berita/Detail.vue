<script setup>
import ArticlePage from '@/components/ArticlePage.vue';

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
