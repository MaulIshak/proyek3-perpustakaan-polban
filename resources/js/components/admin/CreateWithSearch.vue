<script setup>
import { Plus, Search } from 'lucide-vue-next'; // pastikan sudah install lucide-vue-next

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Search...',
    },
    createLabel: {
        type: String,
        default: 'Create',
    },
    modelValue: {
        type: String,
        default: '',
    },
    // Event emit agar bisa dikontrol dari luar
    showIcon: {
        type: Boolean,
        default: true,
    },
    createHref: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue', 'search']);

// Handler saat mengetik di search bar
const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
    emit('search', event.target.value);
};

// Handler klik tombol create
const handleCreate = () => {
    emit('create');
};
</script>

<template>
    <div
        class="flex flex-col gap-3 rounded-xl sm:flex-row sm:items-center sm:justify-between"
    >
        <!-- Search Bar -->
        <div class="relative w-full sm:w-1/2">
            <span
                v-if="showIcon"
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"
            >
                <Search class="h-5 w-5" />
            </span>
            <input
                :placeholder="placeholder"
                :value="modelValue"
                @input="handleInput"
                class="w-full rounded-lg border border-gray-300 py-2 pr-3 pl-10 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            />
        </div>

        <!-- Create Button -->
        <a
            :href="createHref"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--primary-green)] px-4 py-2 font-medium text-white transition-all hover:bg-emerald-700"
        >
            <Plus class="h-4 w-4" />
            <span>{{ createLabel }}</span>
        </a>
    </div>
</template>
