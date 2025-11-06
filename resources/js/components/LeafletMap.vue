<script setup lang="ts">
import { 
  LMap, 
  LTileLayer, 
  LMarker,
} from '@vue-leaflet/vue-leaflet';
import 'leaflet/dist/leaflet.css';
import L, { LatLngExpression } from 'leaflet';
import { onMounted, ref } from 'vue'; // <--- Tambahkan 'ref'

onMounted(() => {
    // Perbaikan ikon marker (dipertahankan)
    // ...
});

// Gunakan 'ref' untuk variabel reaktif
// Pastikan tipe data center adalah LatLngExpression (atau array number biasa [lat, lng])
const center = ref([-6.8643, 107.5908] as any);

// Pastikan zoom adalah angka, didefinisikan sebagai ref
const zoom = ref(15); 
</script>

<template>
  <div class="h-full w-full relative"> 
    <l-map 
      :zoom="zoom"      
      :center="center"      
      :use-global-leaflet="false"
      style="height: 100%; width: 100%; z-index: 0"
      class="rounded-md"
    >
      </l-map>
    </div>
</template>