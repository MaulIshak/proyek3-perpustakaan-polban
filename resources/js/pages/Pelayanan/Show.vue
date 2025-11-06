<script setup>
import { computed } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Clock, Users, FileText, Laptop } from 'lucide-vue-next';

const props = defineProps({
  pelayanan: String
});

const PelayananData = {
  peminjaman : {
            title : 'Peminjaman Buku',
            icon : 'BookOpen',
            description : 'Layanan peminjaman buku untuk mendukung kegiatan belajar dan penelitian',
            content : [
                {
                    subtitle : 'Ketentuan Peminjaman',
                    items : [
                        'Mahasiswa dapat meminjam maksimal 5 (lima) buku',
                        'Dosen dan staf dapat meminjam maksimal 10 (sepuluh) buku',
                        'Masa peminjaman mahasiswa: 14 hari',
                        'Masa peminjaman dosen/staf: 30 hari',
                        'Perpanjangan dapat dilakukan maksimal 2 kali'
                    ]
                },
                {
                    subtitle : 'Alur Peminjaman',
                    items : [
                        'Cari buku yang diinginkan melalui katalog online (e-Lib)',
                        'Catat nomor panggil buku dan cari di rak koleksi',
                        'Bawa buku dan kartu anggota ke meja sirkulasi',
                        'Petugas akan memproses peminjaman dan mencetak slip',
                        'Simpan slip peminjaman sebagai bukti'
                    ]
                }
            ]
        },
        pengembalian : {
            title : 'Pengembalian Buku',
            icon : 'Clock',
            description : 'Prosedur pengembalian buku yang mudah dan praktis',
            content  : [
                {
                    subtitle : 'Cara Pengembalian',
                    items : [
                        'Bawa buku yang akan dikembalikan ke meja sirkulasi',
                        'Serahkan buku beserta kartu anggota kepada petugas',
                        'Petugas akan memeriksa kondisi buku dan tanggal jatuh tempo',
                        'Jika ada denda keterlambatan, lakukan pembayaran',
                        'Simpan bukti pengembalian'
                        
                    ]
                },
                {
                    subtitle : 'Ketentuan Denda',
                    items : [
                        'Denda keterlambatan: Rp 1.000 per hari per buku',
                        'Kehilangan buku: Ganti buku yang sama atau 2x harga buku',
                        'Kerusakan ringan: Rp 25.000 - Rp 50.000',
                        'Kerusakan berat: Sesuai harga buku',
                        'Pembayaran denda dapat dilakukan di kasir perpustakaan'
                    ]
                }
            ]
        },
        keanggotaan : {
            title : 'Keanggotaan',
            icon : 'Users',
            description : 'Informasi pendaftaran dan layanan keanggotaan perpustakaan',
            content : [
                {
                    subtitle : 'Syarat Keanggotaan',
                    items : [
                        'Mahasiswa aktif POLBAN dengan KTM yang masih berlaku',
                        'Dosen dan staff POLBAN dengan kartu pegawai',
                        'Mengisi formulir pendaftaran',
                        'Menyerahkan pas foto 3x4 sebanyak 2 lembar',
                        'Kartu anggota berlaku selama menjadi civitas akademika POLBAN'
                    ]
                },
                {
                    subtitle : 'Hak Anggota',
                    items : [
                        'Meminjam buku sesuai kuota yang ditentukan',
                        'Mengakses katalog online dan database digital',
                        'Menggunakan fasilitas ruang baca dan komputer',
                        'Mengikuti program literasi dan pelatihan perpustakaan',
                        'Mendapatkan layanan referensi dan konsultasi'
                    ]
                }
            ] 
        },
        referensi : {
            title : 'Pelayanan Referensi',
            icon : 'FileText',
            description : 'Bantuan pencarian informasi dan referensi akademik',
            content : [
                {
                    subtitle : 'Layanan yang Tersedia',
                    items : [
                        'Konsultasi pencarian referensi untuk tugas akhir',
                        'Bantuan penelusuran database jurnal internasional',
                        'Pelatihan penggunaan tools manajemen referensi (Mendeley, Zotero)',
                        'Layanan fotokopi artikel jurnal dan buku referensi',
                        'Bantuan sitasi dan penulisan daftar pustaka'
                    ]
                },
                {
                    subtitle : 'Cara Mengakses',
                    items : [
                        'Datang langsung ke meja layanan referensi',
                        'Email ke perpustakaan@polban.ac.id dengan subjek \'Layanan Referensi\'',
                        'Jadwal konsultasi: Senin-Jumat, 09.00-15.00 WIB',
                        'Gratis untuk seluruh civitas akademika POLBAN',
                        'Dapat dijadwalkan untuk konsultasi kelompok'
                    ]
                }
            ]
        },
        ruang_komputer : {
            title : 'Ruang Komputer',
            icon : 'Laptop',
            description : 'Fasilitas komputer dengan akses internet untuk kegiatan akademik',
            content : [
                {
                    subtitle : 'Fasilitas',
                    items : [
                        '40 unit komputer dengan spesifikasi memadai',
                        'Koneksi internet berkecepatan tinggi',
                        'Microsoft Office dan software akademik',
                        'Printer dan scanner (berbayar)',
                        'AC dan pencahayaan yang baik'
                    ]
                },
                {
                    subtitle : 'Tata Tertib Penggunaan',
                    items : [
                        'Wajib menunjukkan kartu anggota perpustakaan',
                        'Maksimal penggunaan 2 jam per sesi',
                        'Hanya untuk keperluan akademik',
                        'Dilarang mengunduh file ilegal atau bermain game',
                        'Jaga kebersihan dan ketenangan ruangan'
                    ]
                }
            ]
        }
    };

const icons = {
  BookOpen,
  Clock,
  Users,
  FileText,
  Laptop
};

const Pelayanan_Data = computed(() => PelayananData[props.pelayanan]);
const IconComponent = computed(() => icons[Pelayanan_Data.value.icon]);
</script>

<template>
  <Layout>
    <div class="py-12" v-if="Pelayanan_Data">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
          <nav class="text-sm text-gray-500 mb-4">
            <Link href="/" class="hover:text-emerald-600">Home</Link>
            <span class="mx-2">/</span>
            <span>Pelayanan</span>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ Pelayanan_Data.title }}</span>
          </nav>
          
          <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
              <component :is="IconComponent" class="w-8 h-8 text-white" />
            </div>
            <div>
              <h1 class="text-4xl font-bold text-gray-800">{{ Pelayanan_Data.title }}</h1>
              <p class="text-gray-600 mt-1">{{ Pelayanan_Data.description }}</p>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div
            v-for="(section, index) in Pelayanan_Data.content"
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