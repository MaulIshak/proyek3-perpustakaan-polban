<script setup lang="ts">
import { useConfirmModal } from '@/composables/userConfirmModal';
import { AlertTriangle, X, CheckCircle2 } from 'lucide-vue-next';

// Mengambil state dan method dari composable
const { isOpen, title, message, payload, actionLabel, close, confirm } = useConfirmModal();

// Format key (camelCase/snake_case to Title Case)
function formatKey(key: string) {
    return key.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase());
}

// Format value
function formatValue(value: any) {
    if (value === null || value === undefined) return '-';
    if (typeof value === 'string' && value.length > 50)
        return value.slice(0, 50) + '...';
    return value;
}
</script>

<template>
    <teleport to="body">
        <!-- Backdrop Transition -->
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isOpen"
                class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4"
                @click="close"
            >
                <!-- Modal Transition -->
                <transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 scale-95 translate-y-4"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100 scale-100 translate-y-0"
                    leave-to-class="opacity-0 scale-95 translate-y-4"
                >
                    <div
                        v-if="isOpen"
                        class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                        @click.stop
                    >
                        <!-- Header / Icon Area -->
                        <div class="flex flex-col items-center pt-8 px-6 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 mb-4">
                                <AlertTriangle class="h-7 w-7 text-red-600" />
                            </div>

                            <h3 class="text-xl font-bold text-slate-800">
                                {{ title }}
                            </h3>

                            <p v-if="message" class="mt-2 text-sm text-slate-500 leading-relaxed">
                                {{ message }}
                            </p>
                        </div>

                        <!-- Payload Data Section -->
                        <div v-if="payload && Object.keys(payload).length > 0" class="px-6 mt-6">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-4 text-sm">
                                <div class="flex flex-col gap-2">
                                    <div
                                        v-for="(value, key) in payload"
                                        :key="key"
                                        class="flex justify-between items-start gap-4"
                                    >
                                        <span class="font-semibold text-slate-600 min-w-[80px]">
                                            {{ formatKey(String(key)) }}:
                                        </span>
                                        <span class="text-slate-800 font-medium text-right break-all">
                                            {{ formatValue(value) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="mt-8 grid grid-cols-2 gap-3 bg-slate-50 px-6 py-4 border-t border-slate-100">
                            <button
                                type="button"
                                class="inline-flex justify-center items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 shadow-sm hover:bg-slate-50 hover:text-slate-800 focus:outline-none transition-all"
                                @click="close"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                class="inline-flex justify-center items-center rounded-xl border border-transparent bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all active:scale-95"
                                @click="confirm"
                            >
                                {{ actionLabel || 'Konfirmasi' }}
                            </button>
                        </div>

                        <!-- Close Button (Absolute) -->
                        <button
                            @click="close"
                            class="absolute top-4 right-4 p-1 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors"
                        >
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
