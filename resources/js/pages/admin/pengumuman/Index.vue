<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';

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
</script>

<template></template>
