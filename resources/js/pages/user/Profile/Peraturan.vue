<script setup lang="ts">
import { defineProps, ref } from 'vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
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
        trigger: "PERATURAN PENGUNJUNG", 
        rules: [
            "Perpustakaan hanya melayani civitas akademika Polban.",
            "Wajib berpakaian sopan dan tidak menggunakan sandal.",
            "Pengunjung perpustakaan wajib mengisi komputer data pengunjung.",
            "Menyimpan tas, jaket, jas di dalam loker yang tersedia.",
            "Tidak menyimpan barang berharga di dalam loker (dompet, hp, laptop).",
            "Tidak diperbolehkan membawa makanan dan minuman, merokok kedalam ruang perpustakaan.",
            "Pengunjung perpustakaan harus menjaga ketenangan, tidak membuat kegaduhan dan tidak mengganggu pengunjung yang lain.",
            "Wajib menjaga dan memelihara seluruh koleksi dan fasilitas yang ada di Perpustakaan. Pengunjung yang merusak koleksi dan fasilitas perpustakaan wajib mengganti dengan koleksi dan fasilitas yang sama dan dikenakan sanksi tidak diperbolehkan melakukan peminjaman buku selama 1 semester.",
            "Buku yang telah selesai dibaca harap tidak dikembalikan ke rak buku tapi disimpan di atas meja, disimpan di troli, atau diserahkan kepada petugas.",
            "Petugas tidak bertanggung jawab atas kehilangan barang pengunjung."
        ]
    },
    {
        value: "item-2",
        trigger: "PERATURAN PENGGUNAAN LOKER", 
        rules: [
            "Barang-barang milik pengunjung (tas, tas laptop, jaket, jaket himpunan, jas, jas lab, jas almameter, baju hangat/sweater, serta makanan dan minuman) diwajibkan untuk disimpan di dalam loker.",
            "Pemakaian loker hanya berlaku ketika jam pelayanan perpustakaan.",
            "Loker hanya boleh diperkenankan bagi yang akan memasuki perpustakaan dan selama ada di perpustakaan.",
            "Tidak diperkenankan meninggalkan barang-barang dalam loker apabila telah meninggalkan perpustakaan.",
            "Pengunjung wajib menjaga kebersihan loker.",
            "Pengunjung dilarang membuat coretan, merusak, dan atau membawa kunci loker.",
            "Pengunjung yang menghilangkan, merusak, dan atau mematahkan kunci loker akan dikenakan sanksi."
        ]
    },
    {
        value: "item-3",
        trigger: "PERATURAN PEMINJAMAN BUKU", 
        rules: [
            "Peminjam adalah Pemustaka yaitu mahasiswa, dosen atau karyawan Polban yang status keanggotaan perpustakaannya aktif.",
            "Anggota yang status keanggotaannya tidak aktif dapat memperpanjang keanggotaannya terlebih dahulu.",
            "Tidak diperkenankan meminjam buku dengan menggunakan kartu anggota mahasiswa lain.",
            "Jumlah buku yang dapat dipinjam maksimal 2 (dua) buku untuk mahasiswa dan 3 (tiga) buku untuk dosen, dengan periode peminjaman selama satu (satu) minggu.",
            "Perpanjangan periode peminjaman buku hanya dapat dilakukan 1 (satu) kali.",
            "Keterlambatan pengembalian buku dikenakan denda.",
            "Kerusakan dan kehilangan buku yang dipinjam menjadi tanggung jawab peminjam. Kerusakan buku yang terjadi pada saat pengembalian (sobek, basah, coretan, kotor, terbakar) akan dikenakan sanksi berupa tidak diperbolehkan melakukan peminjaman buku selama 1 semester dan penggantian buku.",
            "Penggantian buku yang hilang atau rusak diganti dengan buku yang sama. Apabila tidak ada sesuai buku aslinya maka diganti dengan judul buku yang sama edisi terbaru, diganti dengan subyek buku yang sama, diganti dengan jumlah halamannya sama atau lebih banyak, atau diganti dengan tahun terbit buku sama atau terbaru dengan buku yang dihilangkan.",
        ]
    },
    {
        value: "item-4",
        trigger: "PERATURAN KEANGGOTAAN PERPUSTAKAAN",
        rules: [
            "Anggota adalah pemustaka yaitu mahasiswa, dosen atau karyawan Polban yang terdaftar dalam basis data keanggotaan perpustakaan.",
            "Mahasiswa Baru sudah otomatis menjadi anggota perpustakaan.",
            "Mahasiswa yang status keanggotaannya tidak aktif, dapat memperpanjang keanggotaannya dengan memperlihatkan bukti pembayaran UKT semester berjalan.",
            "Keanggotaan perpustakaan bagi mahasiswa berlaku per semester. Maka di setiap awal semester baru setelah melakukan pembayaran UKT harus memperpanjang keanggotaan perpustakaan.",
            "Keanggotaan perpustakaan bagi dosen dan karyawan Polban berlaku per semester. Maka di setiap awal semester baru harus melakukan daftar ulang keanggotaan perpustakaan."
        ]

    }
];

const breadcrumb = [
    { label: 'Profil' },
    { label: 'Peraturan Perpustakaan' }
];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <transition name="accordion">
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