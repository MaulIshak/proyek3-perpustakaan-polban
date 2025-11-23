<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { FileSearch, Megaphone, Plus, Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';

// Components
import ArticleModal from '@/components/admin/ArticleModal.vue'; // Asumsi komponen ini sudah ada/benar
import PaginationLink from '@/components/admin/PaginationLink.vue';
import PengumumanCard from '@/components/admin/PengumumanCard.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';
import AdminLayout from '@/layouts/AdminLayout.vue';

// Props Definition
const props = defineProps<{
    articles: {
        data: any[];
        links: any[];
        from: number;
        to: number;
        total: number;
    };
    searchQuery: string;
}>();

// Layout Definition
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Kelola Pengumuman',
                subTitle: 'Daftar semua pengumuman dan informasi perpustakaan',
            },
            { default: () => page },
        ),
});

// --- Logic Pencarian ---
const search = ref(props.searchQuery || '');

watch(
    search,
    debounce((value: string) => {
        router.get(
            '/admin/pengumuman',
            { search: value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true,
            },
        );
    }, 300),
);

// --- Logic Delete ---
const { open } = useConfirmModal();

function handleDelete(article: any) {
    open({
        title: 'Hapus Pengumuman?',
        message: `Apakah Anda yakin ingin menghapus pengumuman "${article.judul}"? Tindakan ini tidak dapat dibatalkan.`,
        actionLabel: 'Hapus Permanen',
        // confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
        onConfirm: () => {
            router.delete(`/admin/pengumuman/delete/${article.article_id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    // Optional toast notification here
                },
            });
        },
    });
}

// --- Logic Modal Preview ---
const modalOpen = ref(false);
const selectedArticle = ref({});

function openModal(article: any) {
    selectedArticle.value = {
        title: article.judul,
        imageUrl: article.url_thumbnail,
        content: article.content,
        publishedAt: article.created_date,
        url_attachment: article.url_attachment,
        attachment_name: article.attachment_name,
        type: 'pengumuman',
    };
    modalOpen.value = true;
}
</script>

<template>
    <div class="space-y-6">
        <!-- 1. Toolbar: Search & Create -->
        <div
            class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row"
        >
            <!-- Search Input -->
            <div class="group relative w-full sm:max-w-md">
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition-colors group-focus-within:text-[#99cc33]"
                >
                    <Search class="h-5 w-5" />
                </div>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari judul pengumuman..."
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pr-3 pl-10 leading-5 placeholder-slate-400 transition-all focus:border-[#99cc33] focus:bg-white focus:ring-4 focus:ring-[#99cc33]/10 focus:outline-none sm:text-sm"
                />
            </div>

            <!-- Create Button -->
            <Link
                href="/admin/pengumuman/create"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                Buat Pengumuman
            </Link>
        </div>

        <!-- 2. Content Grid -->
        <div v-if="articles.data.length > 0">
            <!-- Grid Layout: 1 Kolom di Mobile, 2 Kolom di Desktop (karena Card berbentuk Horizontal) -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <PengumumanCard
                    v-for="pengumuman in articles.data"
                    :key="pengumuman.article_id"
                    :id="pengumuman.article_id"
                    :title="pengumuman.judul"
                    :content="pengumuman.content"
                    :status="pengumuman.status"
                    :date="pengumuman.created_date"
                    :update-href="`/admin/pengumuman/edit/${pengumuman.article_id}`"
                    @delete="handleDelete(pengumuman)"
                    @view="openModal(pengumuman)"
                />
            </div>

            <!-- Pagination -->
            <div
                class="mt-8 flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-6 sm:flex-row"
            >
                <div class="text-sm text-slate-500">
                    Menampilkan
                    <span class="font-bold text-slate-800">{{
                        articles.from
                    }}</span>
                    -
                    <span class="font-bold text-slate-800">{{
                        articles.to
                    }}</span>
                    dari
                    <span class="font-bold text-slate-800">{{
                        articles.total
                    }}</span>
                    data
                </div>
                <PaginationLink :links="articles.links" />
            </div>
        </div>

        <!-- 3. Empty State -->
        <div
            v-else
            class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-white py-20"
        >
            <div
                class="mb-4 flex h-20 w-20 animate-pulse items-center justify-center rounded-full bg-slate-50"
            >
                <FileSearch v-if="search" class="h-10 w-10 text-slate-400" />
                <Megaphone v-else class="h-10 w-10 text-slate-400" />
            </div>

            <h3 class="text-lg font-bold text-slate-800">
                {{
                    search
                        ? 'Pencarian Tidak Ditemukan'
                        : 'Belum Ada Pengumuman'
                }}
            </h3>

            <p class="mt-1 max-w-sm text-center text-sm text-slate-500">
                {{
                    search
                        ? `Tidak ada pengumuman yang cocok dengan kata kunci "${search}".`
                        : 'Mulai buat pengumuman pertama Anda untuk memberikan informasi kepada pengguna.'
                }}
            </p>

            <button
                v-if="search"
                @click="search = ''"
                class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
            >
                Reset Pencarian
            </button>
            <Link
                v-else
                href="/admin/pengumuman/create"
                class="mt-6 inline-flex items-center gap-2 rounded-lg bg-slate-800 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-slate-900"
            >
                <Plus class="h-4 w-4" />
                Buat Sekarang
            </Link>
        </div>

        <!-- Modal Preview -->
        <ArticleModal
            :open="modalOpen"
            :article="selectedArticle"
            @close="modalOpen = false"
        />
    </div>
</template>
