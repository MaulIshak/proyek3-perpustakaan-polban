<template>
  <div class="bg-white rounded-xl shadow-sm flex items-center gap-4 p-4">
    <div class="bg-emerald-100 text-emerald-700 p-3 rounded-lg">
      <component :is="iconComponent" class="w-5 h-5" />
    </div>
    <div>
      <p class="text-sm text-gray-500">{{ label }}</p>
      <h4 class="text-xl font-semibold text-gray-800">{{ value }}</h4>
    </div>
  </div>
</template>

<script setup>
import * as icons from 'lucide-vue-next';
import { computed } from 'vue';
const props = defineProps({ icon: String, label: String, value: String });
const iconComponent = computed(() => icons[props.icon]);
</script>
