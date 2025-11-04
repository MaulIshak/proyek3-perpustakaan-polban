<script setup>
import ArticleCard from '@/components/admin/ArticleCard.vue';
import CreateWithSearch from '@/components/admin/CreateWithSearch.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Berita',
                subTitle: 'Kelola konten berita perpustakaan',
            },
            { default: () => page },
        ),
});

const { articles } = defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
});

console.log(articles);

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

const handleCreate = () => {};
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
            :delete-action="`/admin/berita/${berita.article_id}/delete`"
            :thumbnail-url="berita.url_thumbnail"
            class="flex-1"
        />
    </div>
</template>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    overflow: hidden;
}
</style>
