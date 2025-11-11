<script lang="ts" setup>
defineProps<{
  itemRoti: { label: string; link?: string }[];
}>();
</script>

<template>
  <nav class="flex items-center py-3" aria-label="Breadcrumb">
    <ol class="flex items-center gap-2">
      <li v-for="(item, index) in itemRoti" :key="index" class="flex items-center">
        <a
          v-if="item.link"
          :href="item.link"
          class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-sm font-medium"
        >
          {{ item.label }}
      </a>

        <span
          v-else
          class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-sm font-medium"
        >
          {{ item.label }}
        </span>

        <span v-if="index < itemRoti.length - 1" class="text-gray-400 mx-1">/</span>
      </li>
    </ol>
  </nav>
</template>
