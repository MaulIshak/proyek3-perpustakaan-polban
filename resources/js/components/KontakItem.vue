<script setup lang="ts">
// Asumsi Anda menggunakan komponen Icon yang menerima prop 'name'
import Icon from '@/components/Icon.vue'; 
import { computed } from 'vue';

const props = defineProps<{
    iconName: string; // Contoh: 'lucide:map-pin'
    title: string;
    content: string;
    link?: string;
}>();

// Teks konten Jam Operasional seringkali panjang, kita akan memecah konten menjadi baris
const contentLines = computed(() => {
    return props.content.split('|');
});
</script>

<template>
    <div class="flex items-start space-x-4"> 
        
        <div class="w-12 h-12 
                    bg-emerald-100/50 
                    rounded-lg 
                    flex items-center justify-center 
                    flex-shrink-0">
            <Icon :name="iconName" class="w-6 h-6 text-emerald-600" />
        </div>

        <div class="mt-1 min-w-0 flex-1">
            <h4 class="font-semibold text-gray-900">{{ title }}</h4>
            
            <template v-if="contentLines.length > 1">
                <p v-for="(line, index) in contentLines" :key="index" class="text-gray-600">
                    {{ line.trim() }}
                </p>
            </template>
            
            <a v-else-if="link" :href="link" class="text-blue-600 hover:text-blue-800 hover:underline">
                {{ content }}
            </a>
            
            <p v-else class="text-gray-600">
                {{ content }}
            </p>
        </div>
    </div>
</template>