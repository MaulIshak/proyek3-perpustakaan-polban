<script setup lang="ts">
defineProps({
    title: String,
    description: String,
});
</script>
<template>
    <h1>
        {{ title }}
    </h1>
    <p class="text-sm text-gray-900">{{ description }}</p>
</template>
