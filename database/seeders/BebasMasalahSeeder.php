<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BebasMasalahSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel kosong sebelum isi data
        DB::table('bebas_masalah_settings')->truncate();

        DB::table('bebas_masalah_settings')->insert([
            // Alur
            'alur_description' => 'Mahasiswa melakukan upload mandiri karya ilmiah dan menyerahkan berkas fisik.',
            'alur_image_path' => null,

            // Persyaratan
            'requirement_description' => 'Berikut adalah dokumen persyaratan yang wajib dipenuhi.',
            'requirement_file_path' => null,

            // Panduan
            'guide_description' => 'Silakan unduh panduan lengkap berikut.',
            'guide_file_path' => null,

            // Template
            'template_title' => 'Surat Pernyataan Publikasi',
            'template_info' => 'Format PDF/DOC - Size Max 5MB',
            'template_instruction' => 'Silakan unduh template surat pernyataan, isi, dan upload kembali.',
            'template_file_path' => null,

            // Watermark
            'watermark_title' => 'Watermark Logo POLBAN',
            'watermark_info' => 'Format PDF - Size Max 2MB',
            'watermark_instruction' => 'Gunakan file ini untuk watermark halaman judul.',
            'watermark_file_path' => null,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}