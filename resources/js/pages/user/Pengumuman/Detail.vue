<template>
    <UserAppLayout
        :page="true"
        :breadcrumb="breadcrumb"
        title="Berita"
        :no-header="true"
    >
        <ArticlePage :article="article" />
    </UserAppLayout>
</template>

<script setup lang="ts">
const breadcrumb = [{ label: 'Informasi' }, { label: 'Berita' }];
import ArticlePage from '@/components/ArticlePage.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';

defineProps<{
    open: boolean;
    article: any;
}>();

defineEmits(['close']);
</script>
