<script setup>
import { computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue'; // <-- Impor layout kita
import { Link } from '@inertiajs/vue3';
import { BookOpen, Clock, Users, FileText, Laptop } from 'lucide-vue-next';

// 1. Terima 'props' yang dikirim oleh PelayananController.php
const props = defineProps({
  pelayanan: Object 
});

// 2. Petakan string 'icon' dari props ke komponen icon Vue
const icons = {
  BookOpen,
  Clock,
  Users,
  FileText,
  Laptop
};

const IconComponent = computed(() => icons[props.pelayanan.icon]);
</script>

<template>
  <Layout>
    <div class="py-12">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
          <nav class="text-sm text-gray-500 mb-4">
            <Link href="/" class="hover:text-emerald-600">Home</Link>
            <span class="mx-2">/</span>
            <span>Pelayanan</span>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ pelayanan.title }}</span>
          </nav>
          
          <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
              <component :is="IconComponent" class="w-8 h-8 text-white" />
            </div>
            <div>
              <h1 class="text-4xl font-bold text-gray-800">{{ pelayanan.title }}</h1>
              <p class="text-gray-600 mt-1">{{ pelayanan.description }}</p>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div
            v-for="(section, index) in pelayanan.content"
            :key="index"
            class="p-6 bg-white shadow rounded-lg"
          >
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ section.subtitle }}</h2>
            <ul class="space-y-3">
              <li
                v-for="(item, itemIndex) in section.items"
                :key="itemIndex"
                class="flex items-start gap-3 text-gray-700"
              >
                <span class="w-2 h-2 bg-emerald-600 rounded-full mt-2 flex-shrink-0"></span>
                <span>{{ item }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>