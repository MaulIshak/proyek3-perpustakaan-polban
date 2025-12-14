<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { FileSearch, Newspaper, Plus, Search, ArrowUpDown } from 'lucide-vue-next';
import { ref, watch } from 'vue';

// Components
import ArticleCard from '@/components/admin/ArticleCard.vue';
import ArticleModal from '@/components/admin/ArticleModal.vue';
import PaginationLink from '@/components/admin/PaginationLink.vue';
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
    statusFilter: string;
    sortFilter: string;
}>();

// Layout Definition
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Kelola Berita',
                subTitle: 'Publikasi berita dan kegiatan perpustakaan',
            },
            { default: () => page },
        ),
});

// --- Logic Pencarian ---
const search = ref(props.searchQuery || '');
const status = ref(props.statusFilter || 'all');
const sort = ref(props.sortFilter || 'desc');

watch(
    search,
    debounce((value: string) => {
        router.get(
            '/admin/berita',
            { search: value, status: status.value, sort: sort.value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true,
            },
        );
    }, 300),
);

watch(
    status,
    debounce((value: string) => {
        router.get(
            '/admin/berita',
            { search: search.value, status: value, sort: sort.value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true,
            },
        );
    }, 300),
);

watch(
    sort,
    debounce((value: string) => {
        router.get(
            '/admin/berita',
            { search: search.value, status: status.value, sort: value },
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
        title: 'Hapus Berita?',
        message: `Apakah Anda yakin ingin menghapus berita "${article.judul}"? Tindakan ini tidak dapat dibatalkan.`,
        actionLabel: 'Hapus Permanen',
        // confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
        onConfirm: () => {
            router.delete(`/admin/berita/delete/${article.article_id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    // Optional toast here
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
        type: 'berita',
        author: article.created_by,
    };
    modalOpen.value = true;
}
</script>

<template>
    <div class="space-y-6">
        <!-- 1. Toolbar: Search, Filter & Create -->
        <div
            class="flex flex-col gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
        >
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
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
                        placeholder="Cari judul berita..."
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pr-3 pl-10 leading-5 placeholder-slate-400 transition-all focus:border-[#99cc33] focus:bg-white focus:ring-4 focus:ring-[#99cc33]/10 focus:outline-none sm:text-sm"
                    />
                </div>

                <!-- Filter Status -->
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-slate-700">Status:</span>
                    <select
                        v-model="status"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-[#99cc33] focus:outline-none focus:ring-2 focus:ring-[#99cc33]/20"
                    >
                        <option value="all">Semua</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="flex items-center gap-2">
                    <ArrowUpDown class="w-4 h-4 text-slate-400" />
                    <select
                        v-model="sort"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-[#99cc33] focus:outline-none focus:ring-2 focus:ring-[#99cc33]/20"
                    >
                        <option value="desc">Terbaru</option>
                        <option value="asc">Terlama</option>
                    </select>
                </div>
            </div>

            <!-- Create Button -->
            <Link
                href="/admin/berita/create"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                Buat Berita
            </Link>
        </div>

        <!-- 2. Content Grid -->
        <div v-if="articles.data.length > 0">
            <!-- Grid Layout: Responsive -->
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <ArticleCard
                    v-for="berita in articles.data"
                    :key="berita.article_id"
                    :title="berita.judul"
                    :content="berita.content"
                    :status="berita.status"
                    :time="berita.created_date"
                    :thumbnail-url="berita.url_thumbnail"
                    :update-href="`/admin/berita/edit/${berita.article_id}`"
                    delete-action=""
                    @delete="handleDelete(berita)"
                    @view="openModal(berita)"
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
                <Newspaper v-else-if="status !== 'all'" class="h-10 w-10 text-slate-400" />
                <Newspaper v-else class="h-10 w-10 text-slate-400" />
            </div>

            <h3 class="text-lg font-bold text-slate-800">
                {{
                    search
                        ? 'Pencarian Tidak Ditemukan'
                        : status !== 'all'
                        ? `Tidak Ada Berita ${status === 'published' ? 'Published' : 'Draft'}`
                        : 'Belum Ada Berita'
                }}
            </h3>

            <p class="mt-1 max-w-sm text-center text-sm text-slate-500">
                {{
                    search
                        ? `Tidak ada berita yang cocok dengan kata kunci "${search}".`
                        : status !== 'all'
                        ? `Tidak ada berita dengan status ${status === 'published' ? 'published' : 'draft'}.`
                        : 'Mulai buat berita pertama Anda untuk mempublikasikan kegiatan terbaru.'
                }}
            </p>

            <button
                v-if="search || status !== 'all'"
                @click="() => { search = ''; status = 'all'; }"
                class="mt-6 text-sm font-bold text-[#99cc33] hover:text-[#88b82d] hover:underline"
            >
                Reset Filter
            </button>
            <Link
                v-else
                href="/admin/berita/create"
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
