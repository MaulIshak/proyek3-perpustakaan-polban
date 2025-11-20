<script setup>
import Layout from '@/layouts/UserAppLayout.vue';
import { BookOpen, Clock, FileText, Laptop, Users, CheckCircle2, Info } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    pelayanan: String, // e.g., 'peminjaman', 'pengembalian'
});

const PelayananData = {
    peminjaman: {
        title: 'Peminjaman Buku',
        icon: 'BookOpen',
        description: 'Layanan peminjaman buku untuk mendukung kegiatan belajar dan penelitian.',
        content: [
            {
                subtitle: 'Ketentuan Peminjaman',
                items: [
                    'Mahasiswa dapat meminjam maksimal 5 (lima) buku.',
                    'Dosen dan staf dapat meminjam maksimal 10 (sepuluh) buku.',
                    'Masa peminjaman mahasiswa: 14 hari.',
                    'Masa peminjaman dosen/staf: 30 hari.',
                    'Perpanjangan dapat dilakukan maksimal 2 kali.',
                ],
            },
            {
                subtitle: 'Alur Peminjaman',
                items: [
                    'Cari buku yang diinginkan melalui katalog online (e-Lib).',
                    'Catat nomor panggil buku dan cari di rak koleksi.',
                    'Bawa buku dan kartu anggota ke meja sirkulasi.',
                    'Petugas akan memproses peminjaman dan mencetak slip.',
                    'Simpan slip peminjaman sebagai bukti.',
                ],
            },
        ],
    },
    pengembalian: {
        title: 'Pengembalian Buku',
        icon: 'Clock',
        description: 'Prosedur pengembalian buku yang mudah, praktis, dan transparan.',
        content: [
            {
                subtitle: 'Cara Pengembalian',
                items: [
                    'Bawa buku yang akan dikembalikan ke meja sirkulasi.',
                    'Serahkan buku beserta kartu anggota kepada petugas.',
                    'Petugas akan memeriksa kondisi buku dan tanggal jatuh tempo.',
                    'Jika ada denda keterlambatan, lakukan pembayaran di tempat.',
                    'Simpan bukti pengembalian sebagai arsip pribadi.',
                ],
            },
            {
                subtitle: 'Ketentuan Denda & Sanksi',
                items: [
                    'Denda keterlambatan: Rp 1.000 per hari per buku.',
                    'Kehilangan buku: Wajib mengganti buku yang sama atau membayar 2x harga buku.',
                    'Kerusakan ringan (sobek/coretan): Denda Rp 25.000 - Rp 50.000.',
                    'Kerusakan berat (hilang halaman/basah): Ganti sesuai harga buku.',
                ],
            },
        ],
    },
    keanggotaan: {
        title: 'Keanggotaan',
        icon: 'Users',
        description: 'Informasi pendaftaran, hak akses, dan layanan eksklusif anggota.',
        content: [
            {
                subtitle: 'Syarat Pendaftaran',
                items: [
                    'Mahasiswa aktif POLBAN (tunjukkan KTM asli/digital).',
                    'Dosen dan staff POLBAN (tunjukkan Kartu Pegawai).',
                    'Mengisi formulir pendaftaran keanggotaan.',
                    'Menyerahkan pas foto 3x4 sebanyak 2 lembar (background merah).',
                    'Keanggotaan otomatis aktif selama status akademik berlaku.',
                ],
            },
            {
                subtitle: 'Hak & Fasilitas Anggota',
                items: [
                    'Meminjam buku sesuai kuota yang ditentukan.',
                    'Akses penuh ke katalog online dan e-journal.',
                    'Menggunakan fasilitas ruang baca, ruang diskusi, dan komputer.',
                    'Mengikuti workshop literasi informasi secara gratis.',
                    'Mendapatkan layanan prioritas dari pustakawan.',
                ],
            },
        ],
    },
    referensi: {
        title: 'Pelayanan Referensi',
        icon: 'FileText',
        description: 'Bantuan profesional untuk pencarian informasi dan referensi akademik.',
        content: [
            {
                subtitle: 'Layanan yang Tersedia',
                items: [
                    'Konsultasi pencarian referensi untuk Tugas Akhir / Skripsi.',
                    'Bantuan penelusuran database jurnal internasional (IEEE, ScienceDirect).',
                    'Pelatihan tools manajemen referensi (Mendeley, Zotero).',
                    'Layanan pengecekan plagiarisme (Turnitin).',
                    'Bantuan format sitasi dan penulisan daftar pustaka.',
                ],
            },
            {
                subtitle: 'Akses Layanan',
                items: [
                    'Datang langsung ke meja "Reference Desk" di lantai 1.',
                    'Email ke perpustakaan@polban.ac.id (Subjek: Tanya Pustakawan).',
                    'Jam Operasional: Senin-Jumat, 08.00-15.30 WIB.',
                    'Layanan ini gratis untuk seluruh civitas akademika POLBAN.',
                ],
            },
        ],
    },
    ruang_komputer: {
        title: 'Ruang Komputer',
        icon: 'Laptop',
        description: 'Fasilitas laboratorium komputer dan internet untuk menunjang akademik.',
        content: [
            {
                subtitle: 'Fasilitas & Spesifikasi',
                items: [
                    '40 Workstation PC dengan spesifikasi High-End.',
                    'Koneksi internet High-Speed (LAN & Wi-Fi 6).',
                    'Terinstall software akademik (Office, SPSS, Matlab, VS Code).',
                    'Tersedia Scanner dan Printer (berbayar).',
                    'Ruangan ber-AC yang nyaman dan tenang.',
                ],
            },
            {
                subtitle: 'Tata Tertib Penggunaan',
                items: [
                    'Wajib tap kartu anggota saat masuk ruangan.',
                    'Durasi penggunaan maksimal 2 jam per sesi (bisa diperpanjang jika kosong).',
                    'Dilarang makan, minum, dan membuat kegaduhan.',
                    'Dilarang mengakses situs pornografi, judi, atau mengunduh file ilegal.',
                    'Matikan komputer dan rapikan kursi setelah selesai.',
                ],
            },
        ],
    },
};

// Map String ke Komponen Icon
const iconMap = {
    BookOpen, Clock, Users, FileText, Laptop
};

const Pelayanan_Data = computed(() => PelayananData[props.pelayanan]);
const breadcrumb = computed(() => [
    { label: 'Pelayanan' }, 
    { label: Pelayanan_Data.value?.title || 'Detail' }
]);
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="Pelayanan_Data?.title">
        <div class="min-h-screen bg-[#f3fff3] py-12 font-sans" v-if="Pelayanan_Data">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-12 animate-fade-in-up">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-[#e6ffe6] to-white border border-[#99cc33]/30 shadow-lg mb-6 transform transition-transform hover:scale-105 duration-300">
                        <component 
                            :is="iconMap[Pelayanan_Data.icon]" 
                            class="w-10 h-10 text-[#00637b]" 
                        />
                    </div>
                    
                    <h1 class="text-4xl font-extrabold text-[#0f3800] tracking-tight mb-3">
                        {{ Pelayanan_Data.title }}
                    </h1>
                    
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        {{ Pelayanan_Data.description }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start animate-fade-in-up delay-100">
                    <div
                        v-for="(section, index) in Pelayanan_Data.content"
                        :key="index"
                        class="group h-full bg-white rounded-2xl shadow-md hover:shadow-xl border-t-4 border-[#00637b] p-8 transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="flex items-center gap-3 mb-6 border-b border-dashed border-gray-200 pb-4">
                            <div class="bg-[#f3fff3] p-2 rounded-lg">
                                <Info class="w-5 h-5 text-[#99cc33]" />
                            </div>
                            <h2 class="text-2xl font-bold text-[#0f3800]">
                                {{ section.subtitle }}
                            </h2>
                        </div>

                        <ul class="space-y-4">
                            <li
                                v-for="(item, itemIndex) in section.items"
                                :key="itemIndex"
                                class="flex items-start gap-3 text-gray-700 group-hover:text-gray-900 transition-colors"
                            >
                                <CheckCircle2 class="mt-1 h-5 w-5 flex-shrink-0 text-[#99cc33]" />
                                <span class="text-base leading-relaxed">{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 text-center animate-fade-in-up delay-200">
                    <div class="inline-block px-6 py-3 bg-[#00637b]/10 rounded-full border border-[#00637b]/20">
                        <p class="text-sm text-[#00637b] font-medium flex items-center gap-2">
                            <Info class="w-4 h-4" />
                            Butuh bantuan lebih lanjut? Hubungi pustakawan di meja sirkulasi.
                        </p>
                    </div>
                </div>

            </div>
        </div>
        
        <div v-else class="min-h-[50vh] flex items-center justify-center bg-[#f3fff3]">
            <p class="text-gray-500 text-lg">Data pelayanan tidak ditemukan.</p>
        </div>
    </Layout>
</template>

<style scoped>
/* Animation Utilities */
.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}

.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>