<script setup lang="ts">
import BeritaCard from '@/components/BeritaCard.vue';
import PaginationLink from '@/components/PaginationLink.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { watch, ref, computed } from 'vue';
import { debounce } from 'lodash';

// Tipe data untuk prop articles (menggunakan struktur pagination Laravel)
interface Article {
    article_id: string;
    judul: string;
    content: string;
    url_thumbnail: string;
    created_date: string;
}

const props = defineProps<{
    articles: {
        data: Article[];
        links: {
            url: string | null;
            label: string;
            active: boolean;
        }[];
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
    searchQuery: string | null;
}>();

const breadcrumb = [{ label: 'Informasi' }, { label: 'Berita' }];

// State untuk input pencarian, diinisialisasi dari URL query string
const search = ref(props.searchQuery || '');

// Debounced function untuk menjalankan Inertia visit
const searchArticles = debounce(() => {
    router.get(
        '/berita',
        { search: search.value },
        {
            preserveState: true,
            replace: true,
            // Hapus scroll agar tidak kembali ke atas saat live search
            preserveScroll: true,
        }
    );
}, 300); // Debounce selama 300ms

// Watcher untuk memanggil fungsi search saat input berubah
watch(search, searchArticles);

// Filter link pagination untuk menghilangkan link yang tidak diperlukan (seperti ellipsis)
const paginationLinks = computed(() => {
    return props.articles.links.filter(link => link.url || link.label.includes('...'));
});
</script>

<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Berita">
        <div class="mx-auto mt-10 mb-8 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="relative mb-8 flex items-center">
                <input
                    type="text"
                    placeholder="Cari berita..."
                    v-model="search"
                    class="w-full rounded-xl border border-gray-300 p-3 pl-10 shadow-sm transition-shadow duration-300 focus:border-[var(--primary-green)] focus:ring-2 focus:ring-[var(--primary-green)]/50"
                />
                <Search class="absolute left-3 h-5 w-5 text-gray-400" />
            </div>

            <div v-if="props.articles.data.length > 0" class="space-y-10">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <BeritaCard
                        v-for="berita in props.articles.data"
                        :key="berita.article_id"
                        :id="berita.article_id"
                        :title="berita.judul"
                        :content="berita.content"
                        :thumbnail="berita.url_thumbnail || '/hero-bg.jpg'"
                        :date="berita.created_date"
                    />
                </div>

                <!-- Pagination -->
                <div class="mt-10 flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ props.articles.from }} sampai
                        {{ props.articles.to }} dari
                        {{ props.articles.total }} hasil.
                    </div>

                    <nav
                        class="isolate inline-flex -space-x-px rounded-xl shadow-sm"
                        aria-label="Pagination"
                    >
                        <!-- Menggunakan komponen PaginationLink -->
                        <PaginationLink
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            :link="link"
                        />
                    </nav>
                </div>
            </div>
            <div v-else class="text-center py-20">
                <h3 class="text-2xl font-bold text-gray-700">
                    Tidak ditemukan berita.
                </h3>
                <p class="mt-2 text-gray-500">
                    Coba ubah kata kunci pencarian Anda.
                </p>
            </div>
        </div>
    </UserAppLayout>
</template>
