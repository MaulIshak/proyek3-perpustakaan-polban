<!-- ArticleModal.vue -->
<template>
    <div
        v-if="open"
        class="fixed inset-0 z-9999 flex items-center justify-center bg-black/50"
    >
        <div
            class="animate-fadeIn max-h-[90vh] w-[90vw] max-w-4xl overflow-y-auto rounded-2xl bg-white p-6"
        >
            <X
                class="fixed z-100 mb-4 cursor-pointer text-gray-600 hover:text-black"
                @click="$emit('close')"
            />

            <ArticlePage :article="article" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { X } from 'lucide-vue-next';
import ArticlePage from '../ArticlePage.vue';

defineProps<{
    open: boolean;
    article: any;
}>();

defineEmits(['close']);
</script>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>
