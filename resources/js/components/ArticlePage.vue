<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Download } from 'lucide-vue-next';
import { computed } from 'vue';

// Define the props for the component to make it reusable.
// It accepts an object with title, imageUrl, content, and an optional publishedAt date.
const props = defineProps<{
    article: {
        title: string;
        imageUrl: string;
        content: string;
        publishedAt?: string;
        url_attachment?: string;
        attachment_name?: string;
        type: 'berita' | 'pengumuman';
    };
}>();

// Format the date for display.
const formattedDate = computed(() => {
    if (!props.article.publishedAt) {
        return null;
    }
    return new Date(props.article.publishedAt).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});

const backUrl = computed(() => {
    return props.article.type === 'berita' ? '/berita' : '/pengumuman';
});
</script>

<template>
    <article class="mx-auto max-w-5xl rounded-3xl px-10 py-8">
        <!-- Back Button -->
        <Link
            :href="backUrl"
            class="mb-6 inline-flex items-center text-gray-600 transition hover:cursor-pointer hover:text-gray-800"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mr-1 h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            <span>Kembali</span>
        </Link>
        <!-- Article Header -->
        <header class="mb-8">
            <h1
                class="text-3xl leading-tight font-bold text-gray-900 md:text-4xl"
            >
                {{ article.title }}
            </h1>
            <p v-if="formattedDate" class="mt-2 text-base text-gray-500">
                <time :datetime="article.publishedAt">{{ formattedDate }}</time>
            </p>
        </header>
        <!-- Hero Image Section -->
        <!-- Hero Image Section -->
        <div class="mb-6 w-full" v-if="article.imageUrl">
            <!-- BERITA → 16:9 dengan max height -->
            <div
                v-if="article.type === 'berita'"
                class="overflow-hidden rounded-lg"
            >
                <img
                    :src="article.imageUrl"
                    :alt="`Image for ${article.title}`"
                    class="aspect-video max-h-[400px] w-full object-cover"
                />
            </div>

            <!-- PENGUMUMAN → fleksibel, tanpa crop, dengan max height -->
            <div v-else>
                <img
                    :src="article.imageUrl"
                    :alt="`Image for ${article.title}`"
                    class="h-auto max-h-[500px] w-auto max-w-full rounded-lg object-contain"
                />
            </div>
        </div>

        <!-- Article Content -->
        <!--
      The `prose` class from TailwindCSS Typography is used for beautiful
      typographic defaults for HTML content.
      Make sure you have `@tailwindcss/typography` plugin installed and configured.
    -->
        <div class="prose max-w-none" v-html="article.content"></div>

        <!-- Attachment Section -->
        <div v-if="article.url_attachment" class="mt-8 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-gray-700">Lampiran</h2>
            <a
                :href="article.url_attachment"
                target="_blank"
                :download="article.attachment_name"
                class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700"
            >
                <Download class="mr-2 h-4 w-4" />
                Unduh {{ article.attachment_name || 'Lampiran' }}
            </a>
        </div>
    </article>
</template>

<style scoped></style>
