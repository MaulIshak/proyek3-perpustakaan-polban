<template>
  <a href="#" :class="[
    'flex items-center gap-3 px-4 py-2 rounded-xl transition font-medium',
    active ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-100'
  ]">
    <component :is="iconComponent" class="w-5 h-5" />
    {{ label }}
  </a>
</template>

<script setup>
import * as icons from 'lucide-vue-next';
import { computed } from 'vue';
const props = defineProps({ icon: String, label: String, active: Boolean });
const iconComponent = computed(() => icons[props.icon]);
</script>
