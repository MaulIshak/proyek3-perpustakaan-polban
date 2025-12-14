<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import ScrollReveal from '@/components/ScrollReveal.vue'; // [CRITICAL] Import komponen ini
import {
    ArrowRight,
    BookOpen,
    CheckCircle2,
    Clock,
    FileText,
    Laptop,
    Users,
    ShieldCheck,
    AlertCircle, // Icon untuk state "Not Found"
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    pelayanan: string;
}>();

const PelayananData: Record<string, any> = {
    peminjaman: {
        title: 'Peminjaman Buku',
        description: 'Layanan sirkulasi buku cetak untuk mendukung kegiatan belajar mengajar.',
        content: [
            {
                subtitle: 'Ketentuan Peminjaman',
                items: [
                    'Mahasiswa dapat meminjam maksimal 2 (dua) buku',
                    'Dosen dan staf dapat meminjam maksimal 2 (dua) buku',
                    'Masa peminjaman mahasiswa: 7 hari',
                    'Masa peminjaman dosen/staf: 7 hari',
                    'Perpanjangan dapat dilakukan maksimal 1 kali',
                ],
            },
            {
                subtitle: 'Alur Self-Loan',
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
        description: 'Prosedur pengembalian koleksi pustaka yang mudah dan transparan.',
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
                    'Denda keterlambatan sesuai dengan SK Direktur',
                    'Kehilangan buku: Ganti buku yang sama atau 2x harga',
                    'Kerusakan ringan: Rp 25.000 - Rp 50.000',
                    'Kerusakan berat: Sesuai harga buku',
                    'Pembayaran denda dapat dilakukan di kasir',
                ],
            },
        ],
    },
    keanggotaan: {
        title: 'Keanggotaan',
        description: 'Akses penuh fasilitas perpustakaan untuk civitas akademika.',
        content: [
            {
                subtitle: 'Syarat Keanggotaan',
                items: [
                    'Mahasiswa aktif POLBAN dengan KTM berlaku',
                    'Dosen dan staff POLBAN dengan kartu pegawai',
                    'Mengisi formulir pendaftaran',
                    'Menyerahkan pas foto 3x4 sebanyak 2 lembar',
                    'Kartu berlaku selama menjadi civitas akademika',
                ],
            },
            {
                subtitle: 'Hak Anggota',
                items: [
                    'Meminjam buku sesuai kuota yang ditentukan',
                    'Mengakses katalog online dan database digital',
                    'Menggunakan fasilitas ruang baca dan komputer',
                    'Mengikuti program literasi perpustakaan',
                    'Mendapatkan layanan referensi dan konsultasi',
                ],
            },
        ],
    },
    referensi: {
        title: 'Pelayanan Referensi',
        description: 'Bantuan profesional dalam penelusuran informasi ilmiah.',
        content: [
            {
                subtitle: 'Layanan Tersedia',
                items: [
                    'Konsultasi pencarian referensi tugas akhir',
                    'Bantuan penelusuran database jurnal internasional',
                    'Bantuan sitasi dan penulisan daftar pustaka',
                ],
            },
            {
                subtitle: 'Cara Mengakses',
                items: [
                    'Datang langsung ke ruang referensi',
                    "Email ke lib@polban.ac.id subjek 'Layanan Referensi'",
                    'Jadwal: Senin-Jumat, 09.00-15.00 WIB',
                    'Gratis untuk civitas akademika POLBAN',
                    'Dapat dijadwalkan untuk konsultasi kelompok',
                ],
            },
        ],
    },
    ruang_komputer: {
        title: 'Ruang Komputer',
        description: 'Fasilitas komputasi modern untuk menunjang akademik.',
        content: [
            {
                subtitle: 'Fasilitas',
                items: [
                    '24 unit komputer spesifikasi memadai',
                    'Koneksi internet berkecepatan tinggi',
                    'Microsoft Office & Printer',
                    'AC dan pencahayaan yang baik',
                ],
            },
            {
                subtitle: 'Tata Tertib',
                items: [
                    'Wajib menunjukkan kartu anggota perpustakaan',
                    'Hanya untuk keperluan akademik',
                    'Dilarang mengunduh file ilegal atau bermain game',
                    'Jaga kebersihan dan ketenangan ruangan',
                ],
            },
        ],
    },
};

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
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-slate-50/50">
            <div
                class="absolute top-0 right-0 h-[300px] w-[300px] sm:h-[600px] sm:w-[600px] rounded-full bg-[#99cc33]/10 blur-3xl opacity-60"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[250px] w-[250px] sm:h-[500px] sm:w-[500px] rounded-full bg-[#99cc33]/5 blur-3xl opacity-60"
            ></div>
        </div>

        <div
            class="relative container mx-auto px-4 py-8 sm:py-12 sm:px-6 lg:px-8"
            v-if="activeData"
        >
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-8">
                <ScrollReveal
                    v-for="(section, index) in activeData.content"
                    :key="index"
                    animation="fade-up"
                    :delay="index * 150"
                    class="h-full"
                >
                    <div
                        class="group relative flex h-full flex-col overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-100 bg-white shadow-lg shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-[#99cc33]/50 hover:shadow-xl hover:shadow-[#99cc33]/10"
                    >
                        <div
                            class="absolute -top-6 -right-6 sm:-top-10 sm:-right-10 h-24 w-24 sm:h-32 sm:w-32 rounded-full bg-[#99cc33]/20 blur-2xl transition-all duration-500 group-hover:bg-[#99cc33]/30"
                        ></div>

                        <div
                            class="relative flex items-center gap-4 bg-gradient-to-br from-[#99cc33]/5 to-transparent p-6 sm:p-8"
                        >
                            <div
                                class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/30 transition-transform duration-300 group-hover:scale-110"
                            >
                                <ShieldCheck class="h-5 w-5 sm:h-6 sm:w-6" />
                            </div>

                            <div class="flex-1">
                                <h2
                                    class="text-lg sm:text-xl font-bold text-slate-800 group-hover:text-[#99cc33] transition-colors leading-tight"
                                >
                                    {{ section.subtitle }}
                                </h2>
                                <div
                                    class="mt-1.5 h-1 w-12 rounded-full bg-[#99cc33]/40"
                                ></div>
                            </div>
                        </div>

                        <div class="flex-grow p-6 sm:p-8 pt-2 sm:pt-2">
                            <ul class="space-y-3 sm:space-y-4">
                                <li
                                    v-for="(item, itemIndex) in section.items"
                                    :key="itemIndex"
                                    class="group/item flex items-start gap-3 rounded-lg p-1.5 sm:p-2 transition-colors hover:bg-[#99cc33]/5"
                                >
                                    <div class="mt-0.5 sm:mt-1 shrink-0">
                                        <CheckCircle2
                                            class="h-4 w-4 sm:h-5 sm:w-5 text-[#99cc33] drop-shadow-sm transition-transform duration-300 group-hover/item:scale-110"
                                        />
                                    </div>
                                    <span
                                        class="text-sm sm:text-[0.95rem] leading-relaxed text-slate-600 transition-colors group-hover/item:text-slate-900"
                                    >
                                        {{ item }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </ScrollReveal>
            </div>
        </div>

        <ScrollReveal
            v-else
            animation="fade-in"
            class="container mx-auto px-4 py-20 text-center"
        >
            <div
                class="mb-4 inline-flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-slate-50 border border-slate-100"
            >
                <AlertCircle class="h-8 w-8 sm:h-10 sm:w-10 text-slate-400" />
            </div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-700">
                Layanan Tidak Ditemukan
            </h2>
            <p class="text-sm sm:text-base text-slate-500 mt-2 max-w-md mx-auto">
                Mohon maaf, informasi layanan yang Anda cari tidak tersedia atau URL yang Anda tuju salah.
            </p>
        </ScrollReveal>
    </Layout>
</template>
