<template>
    <Teleport to="body">
        <div
            v-if="open"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        >
            <div
                class="animate-fadeIn relative flex flex-col w-full max-w-4xl max-h-[90vh] rounded-2xl bg-white shadow-2xl overflow-hidden"
            >
                <button
                    class="absolute top-4 right-4 z-50 p-2 rounded-full bg-white/90 shadow-sm hover:bg-gray-100 transition-colors cursor-pointer"
                    @click="$emit('close')"
                >
                    <X class="w-6 h-6 text-slate-600 hover:text-black" />
                </button>

                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    <ArticlePage :article="article" :is-admin="true" />
                </div>
            </div>
        </div>
    </Teleport>
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
        transform: translateY(10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}

/* Optional: Mempercantik Scrollbar agar terlihat modern */
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #cbd5e1; /* slate-300 */
    border-radius: 20px;
    border: 3px solid transparent;
    background-clip: content-box;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #94a3b8; /* slate-400 */
}
</style>
