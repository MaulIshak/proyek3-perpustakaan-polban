<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import {
    ArrowRight,
    BookOpen,
    CheckCircle2,
    Clock,
    FileText,
    Laptop,
    Users,
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    pelayanan: string;
}>();

// Mapping String ke Komponen Icon Lucide
const iconMap: Record<string, any> = {
    BookOpen,
    Clock,
    Users,
    FileText,
    Laptop,
};

const PelayananData: Record<string, any> = {
    peminjaman: {
        title: 'Peminjaman Buku',
        icon: 'BookOpen',
        description:
            'Layanan sirkulasi buku cetak untuk mendukung kegiatan belajar mengajar dan penelitian civitas akademika.',
        content: [
            {
                subtitle: 'Ketentuan Peminjaman',
                items: [
                    'Mahasiswa dapat meminjam maksimal 5 (lima) buku',
                    'Dosen dan staf dapat meminjam maksimal 10 (sepuluh) buku',
                    'Masa peminjaman mahasiswa: 14 hari',
                    'Masa peminjaman dosen/staf: 30 hari',
                    'Perpanjangan dapat dilakukan maksimal 2 kali',
                ],
            },
            {
                subtitle: 'Alur Peminjaman',
                items: [
                    'Cari buku yang diinginkan melalui katalog online (e-Lib)',
                    'Catat nomor panggil buku dan cari di rak koleksi',
                    'Bawa buku dan kartu anggota ke meja sirkulasi',
                    'Petugas akan memproses peminjaman dan mencetak slip',
                    'Simpan slip peminjaman sebagai bukti',
                ],
            },
        ],
    },
    pengembalian: {
        title: 'Pengembalian Buku',
        icon: 'Clock',
        description:
            'Prosedur pengembalian koleksi pustaka yang mudah, transparan, dan praktis.',
        content: [
            {
                subtitle: 'Cara Pengembalian',
                items: [
                    'Bawa buku yang akan dikembalikan ke meja sirkulasi',
                    'Serahkan buku beserta kartu anggota kepada petugas',
                    'Petugas akan memeriksa kondisi buku dan tanggal jatuh tempo',
                    'Jika ada denda keterlambatan, lakukan pembayaran',
                    'Simpan bukti pengembalian',
                ],
            },
            {
                subtitle: 'Ketentuan Denda',
                items: [
                    'Denda keterlambatan: Rp 1.000 per hari per buku',
                    'Kehilangan buku: Ganti buku yang sama atau 2x harga buku',
                    'Kerusakan ringan: Rp 25.000 - Rp 50.000',
                    'Kerusakan berat: Sesuai harga buku',
                    'Pembayaran denda dapat dilakukan di kasir perpustakaan',
                ],
            },
        ],
    },
    keanggotaan: {
        title: 'Keanggotaan',
        icon: 'Users',
        description:
            'Akses penuh ke seluruh fasilitas perpustakaan melalui keanggotaan resmi civitas akademika.',
        content: [
            {
                subtitle: 'Syarat Keanggotaan',
                items: [
                    'Mahasiswa aktif POLBAN dengan KTM yang masih berlaku',
                    'Dosen dan staff POLBAN dengan kartu pegawai',
                    'Mengisi formulir pendaftaran',
                    'Menyerahkan pas foto 3x4 sebanyak 2 lembar',
                    'Kartu anggota berlaku selama menjadi civitas akademika POLBAN',
                ],
            },
            {
                subtitle: 'Hak Anggota',
                items: [
                    'Meminjam buku sesuai kuota yang ditentukan',
                    'Mengakses katalog online dan database digital',
                    'Menggunakan fasilitas ruang baca dan komputer',
                    'Mengikuti program literasi dan pelatihan perpustakaan',
                    'Mendapatkan layanan referensi dan konsultasi',
                ],
            },
        ],
    },
    referensi: {
        title: 'Pelayanan Referensi',
        icon: 'FileText',
        description:
            'Bantuan profesional dalam penelusuran informasi ilmiah dan referensi akademik.',
        content: [
            {
                subtitle: 'Layanan yang Tersedia',
                items: [
                    'Konsultasi pencarian referensi untuk tugas akhir',
                    'Bantuan penelusuran database jurnal internasional',
                    'Pelatihan penggunaan tools manajemen referensi (Mendeley, Zotero)',
                    'Layanan fotokopi artikel jurnal dan buku referensi',
                    'Bantuan sitasi dan penulisan daftar pustaka',
                ],
            },
            {
                subtitle: 'Cara Mengakses',
                items: [
                    'Datang langsung ke meja layanan referensi',
                    "Email ke perpustakaan@polban.ac.id dengan subjek 'Layanan Referensi'",
                    'Jadwal konsultasi: Senin-Jumat, 09.00-15.00 WIB',
                    'Gratis untuk seluruh civitas akademika POLBAN',
                    'Dapat dijadwalkan untuk konsultasi kelompok',
                ],
            },
        ],
    },
    ruang_komputer: {
        title: 'Ruang Komputer',
        icon: 'Laptop',
        description:
            'Fasilitas komputasi modern dengan akses internet berkecepatan tinggi untuk menunjang akademik.',
        content: [
            {
                subtitle: 'Fasilitas',
                items: [
                    '40 unit komputer dengan spesifikasi memadai',
                    'Koneksi internet berkecepatan tinggi',
                    'Microsoft Office dan software akademik',
                    'Printer dan scanner (berbayar)',
                    'AC dan pencahayaan yang baik',
                ],
            },
            {
                subtitle: 'Tata Tertib Penggunaan',
                items: [
                    'Wajib menunjukkan kartu anggota perpustakaan',
                    'Maksimal penggunaan 2 jam per sesi',
                    'Hanya untuk keperluan akademik',
                    'Dilarang mengunduh file ilegal atau bermain game',
                    'Jaga kebersihan dan ketenangan ruangan',
                ],
            },
        ],
    },
};

// Computed property untuk mengambil data berdasarkan props
const activeData = computed(() => PelayananData[props.pelayanan]);
const breadcrumb = computed(() => [
    { label: 'Home', link: '/' },
    { label: 'Pelayanan' },
    { label: activeData.value ? activeData.value.title : 'Detail' },
]);
</script>

<template>
    <Layout
        :page="true"
        :breadcrumb="breadcrumb"
        :title="activeData?.title || 'Layanan'"
    >
        <!-- Background decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div
            class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8"
            v-if="activeData"
        >
            <!-- Content Grid -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div
                    v-for="(section, index) in activeData.content"
                    :key="index"
                    class="group flex flex-col rounded-2xl border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/30"
                >
                    <div
                        class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4"
                    >
                        <div class="rounded-lg bg-[#99cc33]/10 p-2">
                            <ArrowRight class="h-5 w-5 text-[#99cc33]" />
                        </div>
                        <h2
                            class="text-xl font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                        >
                            {{ section.subtitle }}
                        </h2>
                    </div>

                    <ul class="flex-grow space-y-4">
                        <li
                            v-for="(item, itemIndex) in section.items"
                            :key="itemIndex"
                            class="group/item flex items-start gap-3"
                        >
                            <!-- Custom Bullet Point -->
                            <div class="mt-1 shrink-0">
                                <CheckCircle2
                                    class="h-5 w-5 text-[#99cc33]/60 transition-colors group-hover/item:text-[#99cc33]"
                                />
                            </div>
                            <span
                                class="text-[0.95rem] leading-relaxed text-slate-600 transition-colors group-hover/item:text-slate-800"
                            >
                                {{ item }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Empty State / Error Handling -->
        <div v-else class="container mx-auto px-4 py-20 text-center">
            <div
                class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-slate-100"
            >
                <FileText class="h-8 w-8 text-slate-400" />
            </div>
            <h2 class="text-xl font-bold text-slate-700">
                Layanan Tidak Ditemukan
            </h2>
            <p class="text-slate-500">
                Mohon maaf, informasi layanan yang Anda cari tidak tersedia.
            </p>
        </div>
    </Layout>
</template>
