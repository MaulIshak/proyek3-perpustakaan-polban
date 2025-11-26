<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BebasMasalahSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Settings
        DB::table('bebas_masalah_settings')->insert([
            'alur_image_path' => '/Images/Diagram_Alur.png', // Sesuaikan path storage nanti
            'alur_description' => 'Alur proses Bebas Masalah Perpustakaan',
            
            'template_file_path' => '/files/template_surat.pdf',
            'template_title' => 'Surat Pernyataan Publikasi',
            'template_info' => 'Format PDF - Ukuran: 150 KB',
            'template_instruction' => 'Cetak template, isi data diri, tandatangani di atas meterai Rp 10.000, dan serahkan ke perpustakaan.',
            
            'watermark_file_path' => '/files/watermark_logo.pdf',
            'watermark_title' => 'Watermark Logo POLBAN (PDF)',
            'watermark_info' => 'Format PDF - Ukuran: 2 MB',
            'watermark_instruction' => 'Tempelkan watermark pada halaman judul tugas akhir dengan posisi di tengah dan opacity 30%.',
        ]);

        // 2. Seed Requirements (Persyaratan)
        $requirements = [
            ['1. Pengembalian Buku', 'Mengembalikan seluruh buku yang dipinjam dan memastikan tidak ada tunggakan denda.'],
            ['2. Penyerahan Tugas Akhir', 'Menyerahkan 1 (satu) eksemplar hard copy tugas akhir yang telah dijilid hardcover.'],
            ['3. Upload Soft Copy', 'Mengunggah file PDF tugas akhir ke Repository POLBAN sesuai format yang ditentukan.'],
            ['4. Surat Pernyataan', 'Mengisi dan menandatangani surat pernyataan publikasi karya ilmiah di atas meterai.'],
            ['5. Watermark Logo POLBAN', 'Menempelkan watermark logo POLBAN pada halaman judul tugas akhir.'],
        ];

        foreach ($requirements as $index => $req) {
            DB::table('bebas_masalah_requirements')->insert([
                'title' => $req[0],
                'description' => $req[1],
                'sort_order' => $index + 1,
            ]);
        }

        // 3. Seed Guides (Panduan - Sesuai request: Nomor digabung ke Judul)
        $guides = [
            ['1. Persiapan Dokumen', 'Pastikan file PDF tugas akhir telah final dan sesuai format. Nama file: NIM_NamaLengkap_Judul.pdf'],
            ['2. Akses Repository', 'Login ke Repository POLBAN menggunakan akun mahasiswa (NIM dan password).'],
            ['3. Upload File', 'Pilih menu Submit New Item dan ikuti petunjuk upload. Isi metadata dengan lengkap dan benar.'],
            ['4. Verifikasi', 'Tunggu proses verifikasi oleh pustakawan (maksimal 3 hari kerja).'],
            ['5. Cetak Bukti', 'Setelah disetujui, cetak bukti upload sebagai persyaratan Bebas Masalah.'],
        ];

        foreach ($guides as $index => $guide) {
            DB::table('bebas_masalah_guides')->insert([
                'title' => $guide[0],
                'description' => $guide[1],
                'sort_order' => $index + 1,
            ]);
        }
    }
}