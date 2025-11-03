<template>
  <div
    v-if="modelValue"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
  >
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
      <button
        @click="$emit('update:modelValue', false)"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
      >
        ✕
      </button>
      <h2 v-if="title" class="text-xl font-semibold mb-4">{{ title }}</h2>
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
  title: String,
});
defineEmits(["update:modelValue"]);
</script>
