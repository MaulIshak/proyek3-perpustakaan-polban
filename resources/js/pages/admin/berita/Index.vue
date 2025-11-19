<script setup>
import ArticleCard from '@/components/admin/ArticleCard.vue';
import ArticleModal from '@/components/admin/ArticleModal.vue';
import CreateWithSearch from '@/components/admin/CreateWithSearch.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { FileSearch } from 'lucide-vue-next';
import { computed, ref } from 'vue';

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

const modalOpen = ref(false);
const selectedArticle = ref(null);

function openModal(article) {
    selectedArticle.value = article;
    modalOpen.value = true;
}

const searchQuery = ref('');

const filteredArticles = computed(() => {
    if (!searchQuery.value) {
        return articles;
    }
    return articles.filter((article) =>
        article.judul.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});
</script>

<template>
    <CreateWithSearch
        placeholder="Cari berita..."
        create-label="Buat Berita Baru"
        create-href="/admin/berita/create"
        class="mb-3"
        @search="(query) => (searchQuery = query)"
    />
    <div
        v-if="articles.length != 0"
        class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4"
    >
        <ArticleCard
            v-for="berita in filteredArticles"
            :key="berita.article_id"
            :title="berita.judul"
            :content="berita.content"
            :status="berita.status"
            :time="berita.created_date"
            :thumbnail-url="berita.url_thumbnail"
            @view="openModal"
            :update-href="`/admin/berita/edit/${berita.article_id}/`"
            class="flex-1"
            @delete="handleDelete(berita)"
        />
    </div>
    <div
        v-else
        class="flex flex-col items-center justify-center py-20 text-center"
    >
        <!-- Icon dari lucide -->
        <FileSearch class="mb-4 h-20 w-20 text-gray-400" />

        <h3 class="text-2xl font-semibold text-gray-600">Belum Ada Berita</h3>

        <p class="mt-2 max-w-sm text-gray-500">
            Sistem tidak menemukan berita apapun. Buat berita baru atau ubah
            kata kunci pencarian.
        </p>

        <a
            href="/admin/berita/create"
            class="mt-6 rounded-xl bg-[var(--primary-green)] px-5 py-3 font-medium text-white transition hover:opacity-90"
        >
            Buat Berita Baru
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
