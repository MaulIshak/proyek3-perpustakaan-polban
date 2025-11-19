<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
        <div
            class="animate-fadeIn w-full max-w-md rounded-xl bg-white p-6 shadow-xl"
        >
            <h2 class="mb-2 text-xl font-semibold text-gray-800">
                {{ title }}
            </h2>

            <p v-if="message" class="mb-4 text-gray-600">{{ message }}</p>

            <!-- Tampilkan data ketika diberikan -->
            <div
                v-if="payload"
                class="mb-4 rounded-lg border bg-gray-50 p-3 text-sm text-gray-700"
            >
                <div
                    v-if="payload && typeof payload === 'object'"
                    class="rounded-lg bg-gray-50 p-3 text-sm text-gray-700"
                >
                    <div
                        v-for="(value, key) in payload"
                        :key="key"
                        class="flex justify-between border-b pb-1"
                    >
                        <span
                            class="flex-1 font-medium text-gray-800 capitalize"
                            >{{ formatKey(key) }}</span
                        >
                        <span class="flex-3 text-gray-700">{{
                            formatValue(value)
                        }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm hover:bg-gray-300"
                    @click="close"
                >
                    Batal
                </button>

                <button
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700"
                    @click="confirm"
                >
                    {{ actionLabel }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useConfirmModal } from '@/composables/userConfirmModal';

const { isOpen, title, message, payload, actionLabel, close, confirm } =
    useConfirmModal();

function formatKey(key) {
    return key.replace(/_/g, ' ');
}

function formatValue(value) {
    if (value === null || value === undefined) return '-';
    if (typeof value === 'string' && value.length > 100)
        return value.slice(0, 100) + '...';
    return value;
}
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
