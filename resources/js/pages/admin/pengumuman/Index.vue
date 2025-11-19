<script setup>
import ArticleModal from '@/components/admin/ArticleModal.vue';
import CreateWithSearch from '@/components/admin/CreateWithSearch.vue';
import PengumumanCard from '@/components/admin/PengumumanCard.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { FileSearch } from 'lucide-vue-next';
import { ref, computed } from 'vue';

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
                title: 'Pengumuman',
                subTitle: 'Kelola pengumuman perpustakaan',
            },
            { default: () => page },
        ),
});

const searchQuery = ref('');

const filteredArticles = computed(() => {
    if (!searchQuery.value) {
        return articles;
    }
    return articles.filter((article) =>
        article.judul.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

function handleDelete(article) {
    open({
        title: 'Hapus Pengumuman?',
        message: 'Pastikan data yang akan dihapus sudah benar.',
        actionLabel: 'Hapus',
        payload: {
            Judul: article.judul,
            Status: article.status,
            Tanggal: article.created_date,
        },
        onConfirm: () => {
            router.delete(`/admin/pengumuman/delete/${article.article_id}`);
        },
    });
}

const modalOpen = ref(false);
const selectedArticle = ref(null);

function openModal(article) {
    selectedArticle.value = {
        title: article.judul,
        imageUrl: article.url_thumbnail,
        content: article.content,
        publishedAt: article.created_date,
        url_attachment: article.url_attachment,
        attachment_name: article.attachment_name,
    };
    modalOpen.value = true;
}
</script>

<template>
    <CreateWithSearch
        placeholder="Cari pengumuman..."
        create-label="Buat Pengumuman Baru"
        create-href="/admin/pengumuman/create"
        class="mb-3"
        @search="(query) => (searchQuery = query)"
    />
    <div
        v-if="filteredArticles.length > 0"
        class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4"
    >
        <PengumumanCard
            v-for="pengumuman in filteredArticles"
            :key="pengumuman.article_id"
            :title="pengumuman.judul"
            :content="pengumuman.content"
            :status="pengumuman.status"
            :time="pengumuman.created_date"
            :thumbnail-url="pengumuman.url_thumbnail"
            :update-href="`/admin/pengumuman/edit/${pengumuman.article_id}/`"
            class="flex-1"
            @delete="handleDelete(pengumuman)"
            @view="openModal(pengumuman)"
        />
    </div>
    <div
        v-else
        class="flex flex-col items-center justify-center py-20 text-center"
    >
        <!-- Icon dari lucide -->
        <FileSearch class="mb-4 h-20 w-20 text-gray-400" />

        <h3 class="text-2xl font-semibold text-gray-600">
            Belum Ada Pengumuman
        </h3>

        <p class="mt-2 max-w-sm text-gray-500">
            Sistem tidak menemukan pengumuman apapun. Buat pengumuman baru atau
            ubah kata kunci pencarian.
        </p>

        <a
            v-if="searchQuery === ''"
            href="/admin/pengumuman/create"
            class="mt-6 rounded-xl bg-[var(--primary-green)] px-5 py-3 font-medium text-white transition hover:opacity-90"
        >
            Buat Pengumuman Baru
        </a>
    </div>
    <ArticleModal
        :open="modalOpen"
        :article="selectedArticle"
        @close="modalOpen = false"
    />
</template>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    overflow: hidden;
}
</style>
