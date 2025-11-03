<!--
    File: resources/js/pages/admin/_template.vue
    Deskripsi: Template halaman admin dengan layout yang dapat disesuaikan
-->

<script setup>
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



</script>

<template>
    <!-- Konten disini -->
</template>
