<script setup>
import ArticleCard from '@/components/admin/ArticleCard.vue';
import CreateWithSearch from '@/components/admin/CreateWithSearch.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
const { open } = useConfirmModal();
const { articles } = defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
});
defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Berita',
                subTitle: 'Kelola berita perpustakaan',
            },
            { default: () => page },
        ),
});

const berita = [
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
    {
        id: 1,
        title: 'Perpanjangan Waktu Peminjaman',
        type: 'Berita',
        status: 'Published',
        time: '25-06-2024',
        content:
            'Perpustakaan UPT Polban mengumumkan perpanjangan waktu peminjaman buku hingga 2 minggu ke depan. Manfaatkan kesempatan ini untuk menambah koleksi bacaan Anda!',
        thumbnailUrl: '/hero-bg.jpg',
    },
];

function handleDelete(article) {
    open({
        title: 'Hapus Berita?',
        message: 'Pastikan data yang akan dihapus sudah benar.',
        actionLabel: 'Hapus',
        payload: {
            Judul: article.judul,
            Status: article.status,
            Tanggal: article.created_date,
        },
        onConfirm: () => {
            router.delete(`/admin/berita/delete/${article.article_id}`);
        },
    });
}
</script>

<template>
    <CreateWithSearch
        placeholder="Cari berita..."
        create-text="Buat Berita Baru"
        create-href="/admin/berita/create"
        class="mb-3"
    />
    <div
        class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4"
    >
        <ArticleCard
            v-for="berita in articles"
            :key="berita.article_id"
            :title="berita.judul"
            :content="berita.content"
            :status="berita.status"
            :time="berita.created_date"
            :thumbnail-url="berita.url_thumbnail"
            :view-href="`/admin/berita/detail/${berita.article_id}/`"
            :update-href="`/admin/berita/edit/${berita.article_id}/`"
            class="flex-1"
            @delete="handleDelete(berita)"
        />
    </div>
</template>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    overflow: hidden;
}
</style>
