<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Konstanta untuk placeholder
        $placeholderImage = 'https://placehold.co/600x400/png';
        $placeholderPdf = 'https://s2.q4cdn.com/175719177/files/doc_presentations/Placeholder-PDF.pdf';

        // --- 1. Generate 15 Berita ---
        $beritaData = [
            // Berita tentang Pelayanan
            ['judul' => 'Perpustakaan POLBAN Luncurkan Sistem Peminjaman Mandiri Baru', 'konten' => 'Sistem peminjaman buku mandiri (self-service kiosk) mulai diuji coba minggu ini untuk meningkatkan efisiensi pelayanan. Kami mengajak seluruh mahasiswa untuk mencoba fitur baru ini.'],
            ['judul' => 'Suksesi Literasi Digital: Workshop Wajib Mahasiswa Baru', 'konten' => 'Lebih dari 1000 mahasiswa baru telah mengikuti workshop literasi digital yang diadakan oleh Perpustakaan, fokus pada etika penggunaan sumber daya akademik.'],
            ['judul' => 'Jam Operasional Terbaru Selama Bulan Ramadan', 'konten' => 'Sehubungan dengan datangnya bulan suci Ramadan, jam layanan Perpustakaan disesuaikan menjadi pukul 08:00 - 15:00 WIB. Harap diperhatikan.'],
            // Berita tentang Teknologi/Inovasi
            ['judul' => 'Peningkatan Kecepatan Akses E-Journal & Database Internasional', 'konten' => 'Unit IT Perpustakaan telah berhasil meningkatkan bandwidth khusus untuk akses ke jurnal elektronik berbayar, menjamin kecepatan download yang lebih baik.'],
            ['judul' => 'Fitur Live Chat Bantuan Pustakawan Resmi Dirilis', 'konten' => 'Untuk mendukung riset daring, Perpustakaan kini menyediakan fitur live chat yang terintegrasi dengan portal untuk konsultasi langsung dengan pustakawan profesional.'],
            ['judul' => 'Inovasi Green Library: Pemanfaatan Energi Terbarukan', 'konten' => 'Dalam rangka mendukung kampus hijau, atap Perpustakaan dipasangi panel surya. Inisiatif ini diharapkan mengurangi konsumsi energi listrik hingga 30%.'],
            // Berita Kolaborasi/Kegiatan
            ['judul' => 'Kolaborasi dengan Jurusan Teknik: Pelatihan Pembuatan Karya Ilmiah', 'konten' => 'Perpustakaan bekerja sama dengan Jurusan Teknik Sipil mengadakan pelatihan intensif mengenai penulisan dan sitasi karya ilmiah yang sesuai standar internasional.'],
            ['judul' => 'Pekan Donasi Buku 2025: Mencapai Target 500 Judul', 'konten' => 'Kegiatan rutin tahunan Pekan Donasi Buku berhasil mengumpulkan 500 judul buku baru dari dosen, alumni, dan mahasiswa untuk memperkaya koleksi.'],
            ['judul' => 'Kunjungan Studi Banding dari Perpustakaan Universitas Mitra', 'konten' => 'Delegasi dari 5 universitas ternama mengunjungi Perpustakaan POLBAN untuk mempelajari model pengelolaan koleksi digital yang telah kami terapkan.'],
            // Berita Bervariasi Lainnya
            ['judul' => 'Sosialisasi Bahaya Plagiarisme bagi Mahasiswa Tingkat Akhir', 'konten' => 'Seminar wajib tentang integritas akademik dan pencegahan plagiarisme dengan menggunakan perangkat lunak Turnitin dan sejenisnya.'],
            ['judul' => 'Pameran Manuskrip Kuno Warisan Nusantara', 'konten' => 'Dalam rangka Dies Natalis, diselenggarakan pameran khusus yang menampilkan koleksi manuskrip langka dari seluruh Indonesia.'],
            ['judul' => 'Seleksi Duta Baca Perpustakaan POLBAN Tahun 2026 Dibuka!', 'konten' => 'Ayo daftar dan jadilah perwakilan Perpustakaan untuk menginspirasi budaya membaca di kalangan civitas akademika.'],
            ['judul' => 'Pengadaan Buku Terbaru untuk Jurusan Akuntansi dan Keuangan', 'konten' => 'Dana khusus telah dialokasikan untuk penambahan 150 judul buku terbaru di bidang Akuntansi, Perpajakan, dan Keuangan Syariah.'],
            ['judul' => 'Perbaikan dan Penataan Ulang Ruang Baca Lantai 2', 'konten' => 'Ruang baca di lantai 2 sedang direnovasi untuk menyediakan kursi ergonomis dan pencahayaan yang lebih baik demi kenyamanan pengguna.'],
            ['judul' => 'Pelatihan Dasar Penggunaan Aplikasi Mendeley untuk Referensi', 'konten' => 'Pelatihan teknis praktis selama 3 hari bagi mahasiswa pascasarjana tentang manajemen referensi menggunakan Mendeley.'],
        ];

        foreach ($beritaData as $data) {
            Article::create([
                'article_id' => Str::uuid()->toString(),
                'judul' => $data['judul'],
                'content' => $data['konten'],
                'type' => 'berita',
                'status' => 'published',
                'url_thumbnail' => $placeholderImage,
                'created_date' => now()->subDays(rand(1, 30)), // Tanggal acak 1 bulan terakhir
            ]);
        }

        // --- 2. Generate 10 Pengumuman ---
        $pengumumanData = [
            ['judul' => 'Pemberitahuan: Pemeliharaan Server Sistem Informasi', 'konten' => 'Akan dilakukan pemeliharaan rutin server sistem Perpustakaan pada tanggal 20 November 2025 pukul 23:00 hingga 02:00 WIB. Akses ke portal akan terhenti sementara.'],
            ['judul' => 'Waktu Perpanjangan Pinjaman Koleksi: Batas Akhir Semester', 'konten' => 'Batas akhir perpanjangan pinjaman untuk semester ini adalah 5 Desember 2025. Koleksi yang terlambat akan dikenakan denda sesuai peraturan.'],
            ['judul' => 'Lowongan Relawan Pustakawan Muda POLBAN', 'konten' => 'Dibuka kesempatan bagi mahasiswa yang ingin menambah pengalaman sebagai relawan di Perpustakaan. Informasi lengkap dapat dilihat di berkas lampiran.'],
            ['judul' => 'Peringatan: Protokol Kesehatan Terbaru di Area Perpustakaan', 'konten' => 'Mengingat peningkatan kasus, diwajibkan menggunakan masker FFP2/KN95 di seluruh area indoor Perpustakaan. Sanksi berlaku bagi yang melanggar.'],
            ['judul' => 'Penutupan Sementara Ruang Diskusi Kelompok (RDK) Lantai 3', 'konten' => 'RDK lantai 3 ditutup mulai hari ini hingga batas waktu yang belum ditentukan karena ada perbaikan pendingin ruangan.'],
            ['judul' => 'Syarat dan Ketentuan Terbaru Bebas Masalah (Bebas Pustaka)', 'konten' => 'Telah diterbitkan dokumen terbaru mengenai prosedur dan persyaratan pengurusan Surat Keterangan Bebas Masalah bagi calon wisudawan. Wajib dibaca!'],
            ['judul' => 'Seminar Daring: Riset Berbasis Data di Era AI', 'konten' => 'Pendaftaran dibuka untuk seminar daring gratis bersama Prof. Dr. Budi Santoso. Kuota terbatas 150 peserta. Daftarkan diri Anda sekarang.'],
            ['judul' => 'Pengembalian Buku Koleksi Khusus (Reserve Collection)', 'konten' => 'Seluruh buku dari Koleksi Khusus yang dipinjam wajib dikembalikan paling lambat 24 jam setelah jam perkuliahan berakhir.'],
            ['judul' => 'Undangan Rapat Koordinasi Kepala Bagian Perpustakaan', 'konten' => 'Kepada seluruh Kepala Bagian diwajibkan hadir dalam Rapat Koordinasi Bulanan yang akan diselenggarakan pada Jumat ini di Ruang Teater Mini.'],
            ['judul' => 'Informasi Pelaksanaan Ujian Sertifikasi Pustakawan', 'konten' => 'Pengumuman mengenai jadwal, lokasi, dan persyaratan bagi peserta Ujian Sertifikasi Pustakawan tahun 2026. Lampiran berisi daftar nama peserta terdaftar.'],
        ];

        foreach ($pengumumanData as $index => $data) {
            Article::create([
                'article_id' => Str::uuid()->toString(),
                'judul' => $data['judul'],
                'content' => $data['konten'],
                'type' => 'pengumuman',
                'status' => 'published',
                // Pengumuman ke-1, ke-3, ke-6, dan ke-10 akan memiliki lampiran
                'url_attachment' => in_array($index, [0, 2, 5, 9]) ? $placeholderPdf : null,
                'attachment_name' => in_array($index, [0, 2, 5, 9]) ? 'Lampiran_Detail.pdf' : null,
                'url_thumbnail' => $placeholderImage, // Meskipun pengumuman, tetap isi kolom ini untuk konsistensi model, tapi di frontend bisa diabaikan.
                'created_date' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
