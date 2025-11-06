<script setup lang="ts">
import { computed } from 'vue';

// Define the props for the component to make it reusable.
// It accepts an object with title, imageUrl, content, and an optional publishedAt date.
const props = defineProps<{
    article: {
        title: string;
        imageUrl: string;
        content: string;
        publishedAt?: string;
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
    <article class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
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

        <!-- Article Content -->
        <!--
      The `prose` class from TailwindCSS Typography is used for beautiful
      typographic defaults for HTML content.
      Make sure you have `@tailwindcss/typography` plugin installed and configured.
    -->
        <div
            class="prose dark:prose-invert max-w-none"
            v-html="article.content"
        ></div>
    </article>
</template>

<style scoped></style>
