<script setup lang="ts">
import { computed } from 'vue';
import { Download } from 'lucide-vue-next';

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
</script>

<template>
    <article class="mx-auto max-w-5xl rounded-3xl px-10 py-8 backdrop-blur-3xl">
        <!-- Article Header -->
        <header class="mb-8">
            <h1
                class="text-3xl font-bold leading-tight text-gray-900 md:text-4xl"
            >
                {{ article.title }}
            </h1>
            <p v-if="formattedDate" class="mt-2 text-base text-gray-500">
                <time :datetime="article.publishedAt">{{ formattedDate }}</time>
            </p>
        </header>
        <!-- Hero Image Section -->
        <div
            class="mb-6 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700"
        >
            <!--
        The image will maintain a 16:9 aspect ratio.
        `object-cover` ensures the image covers the area, cropping as needed.
      -->
            <img
                :src="article.imageUrl"
                :alt="`Image for ${article.title}`"
                class="aspect-[16/9] h-auto w-full object-cover"
                width="1280"
                height="720"
            />
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
            <h2 class="mb-3 text-lg font-semibold text-gray-700">
                Lampiran
            </h2>
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
