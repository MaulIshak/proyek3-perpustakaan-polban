<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Detail Berita" :no-header="true">
        <ArticlePage :article="article" />
    </UserAppLayout>
</template>

<script setup lang="ts">
const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Berita' },
    { label: 'Detail Berita' },
];
import ArticlePage from '@/components/ArticlePage.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';

defineProps<{
    open: boolean;
    article: any;
}>();

defineEmits(['close']);
</script>
