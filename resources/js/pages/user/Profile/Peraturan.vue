<script setup lang="ts">
import { defineProps, ref } from 'vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import RemahanRoti from '@/layouts/RemahanRoti.vue';
import { Icon } from '@iconify/vue'; 

// --- Data Halaman dari Controller ---
defineProps<{
    title: string;
    description?: string; 
}>();

// --- State untuk mengontrol Accordion yang terbuka (Multi-Open) ---
// Menggunakan array untuk menampung beberapa item yang terbuka.
const activeAccordion = ref<string[]>([]);

/**
 * Fungsi untuk membuka atau menutup item accordion.
 * Item yang sudah terbuka tidak akan tertutup otomatis.
 * @param value Nilai item (misalnya 'item-1')
 */
function toggleAccordion(value: string) {
    const index = activeAccordion.value.indexOf(value);
    
    if (index > -1) {
        // Jika sudah terbuka, tutup (hapus dari array)
        activeAccordion.value.splice(index, 1);
    } else {
        // Jika belum terbuka, buka (tambahkan ke array)
        activeAccordion.value.push(value);
    }
}

// --- Data Peraturan (Sesuai dengan Konten Gambar) ---
const peraturanItems = [
    {
        value: "item-1",
        trigger: "Peraturan Pengunjung", 
        rules: [
            "Pengunjung yang memakai sandal dan jaket akan dikeluarkan dari ruangan perpustakaan.",
            "Pengunjung yang membawa tas, tas laptop, makanan, minuman, rokok ke dalam ruangan akan dikeluarkan dari ruangan perpustakaan.",
            "Pengunjung yang mengganggu ketertiban dan ketenangan akan dikeluarkan dari ruangan perpustakaan.",
            "Pengunjung yang merusak koleksi dan fasilitas perpustakaan wajib mengganti dengan koleksi dan fasilitas yang sama dan dikenakan sanksi tidak diperbolehkan melakukan peminjaman buku selama 1 semester.",
            "Pengunjung yang menghilangkan, merusak, dan/atau mematahkan kunci loker akan dikenakan sanksi.",
        ]
    },
    {
        value: "item-2",
        trigger: "Pengembalian Buku & Ketentuan Ganti Rugi", 
        rules: [
            "Keterlambatan pengembalian buku dikenakan denda Rp500,-/buku/hari.",
            "Kerusakan dan kehilangan buku yang dipinjam menjadi tanggung jawab peminjam. Kerusakan buku yang terjadi pada saat pengembalian (sobek, basah, coretan, kotor, terbakar) akan dikenakan sanksi berupa tidak diperbolehkan melakukan peminjaman buku selama 1 semester dan penggantian buku.",
            // Sub-aturan: Ketentuan penggantian buku rusak
            "Ketentuan penggantian buku rusak sebagai berikut:",
            "Buku diganti sesuai aslinya.",
            "Apabila tidak ada sesuai buku aslinya, maka diganti dengan judul buku yang sama edisi terbaru.",
            "Diganti dengan subyek buku yang sama dengan buku yang dihilangkan.",
            "Jumlah halamannya sama atau lebih banyak dengan buku yang dihilangkan.",
            "Tahun terbit buku sama atau terbaru dengan buku yang dihilangkan.",
        ]
    },
    {
        value: "item-3",
        trigger: "Buku Hilang", 
        rules: [
            "Kehilangan buku yang dipinjam menjadi tanggung jawab peminjam. Ketentuan penggantian buku hilang sebagai berikut:**",
            // Aturan Penggantian Buku Hilang (Sama seperti yang rusak)
            "Buku diganti sesuai aslinya.",
            "Apabila tidak ada sesuai buku aslinya, maka diganti dengan judul buku yang sama edisi terbaru.",
            "Diganti dengan subyek buku yang sama dengan buku yang dihilangkan.",
            "Jumlah halamannya sama atau lebih banyak dengan buku yang dihilangkan.",
            "Tahun terbit buku sama atau terbaru dengan buku yang dihilangkan.",
        ]
    },
];

const breadcrumb = [
    { label: 'Profil' },
    { label: 'Peraturan Perpustakaan' }
];
</script>

<template>
    <UserAppLayout :title="title">
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="mb-8">
                    <RemahanRoti :itemRoti="breadcrumb" />
                    <h1 class="text-4xl font-bold text-gray-900">{{ title }}</h1>
                    <p class="text-gray-600 mt-2">Tata tertib dan ketentuan penggunaan perpustakaan</p>
                </div>

                <div class="p-6 mb-6 bg-emerald-50 border border-emerald-200 rounded-xl shadow">
                    <div class="flex items-start gap-3">
                        <Icon icon="lucide:alert-circle" class="w-6 h-6 text-emerald-600 shrink-0 mt-0.5" />
                        <p class="text-gray-700">
                            Setiap pengguna perpustakaan wajib mematuhi peraturan yang berlaku untuk kenyamanan bersama.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-xl border text-card-foreground shadow"> 
                    <div class="w-full divide-y divide-gray-200">
                        <div v-for="item in peraturanItems" :key="item.value" class="py-4">
                            
                            <!-- Tombol Accordion -->
                            <button 
                                type="button"
                                @click="toggleAccordion(item.value)"
                                :aria-expanded="activeAccordion.includes(item.value)"
                                class="flex justify-between items-center w-full text-left font-semibold text-gray-800 transition-all hover:text-emerald-600"
                            >
                                <span>{{ item.trigger }}</span>
                                <Icon 
                                    icon="lucide:chevron-down" 
                                    :class="[
                                        'w-5 h-5 text-gray-500 transition-transform duration-300', 
                                        {'rotate-180 text-emerald-600': activeAccordion.includes(item.value)}
                                    ]" 
                                />
                            </button>
                            
                            <!-- Konten Accordion dengan Transisi Smooth -->
                            <transition 
                                name="accordion"
                                @enter="onEnter"
                                @after-enter="onAfterEnter"
                                @leave="onLeave"
                            >
                                <div
                                    v-show="activeAccordion.includes(item.value)"
                                    class="overflow-hidden"
                                >
                                    <ul class="space-y-2 text-gray-700 pt-4">
                                        <li 
                                            v-for="(rule, index) in item.rules" 
                                            :key="index" 
                                            class="flex items-start gap-2 text-sm"
                                        >
                                            <span class="font-medium shrink-0 pt-0.5">{{ index + 1 }}.</span>
                                            <span>{{ rule }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </transition>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </UserAppLayout>
</template>

<style scoped>
/* Transisi accordion halus (max-height + opacity + padding) */
.accordion-enter-active,
.accordion-leave-active {
  transition: all 0.4s ease-in-out;
  overflow: hidden;
}

.accordion-enter-from,
.accordion-leave-to {
  max-height: 0;
  opacity: 0;
  padding-top: 0;
}

.accordion-enter-to,
.accordion-leave-from {
  max-height: 500px; /* cukup besar agar semua konten muat */
  opacity: 1;
  padding-top: 1rem;
}
</style>