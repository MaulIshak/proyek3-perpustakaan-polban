<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Pengaturan Umum (Alur, Template, Watermark)
        Schema::create('bebas_masalah_settings', function (Blueprint $table) {
            $table->id();
            
            // Tab Alur
            $table->string('alur_image_path')->nullable(); // Path gambar diagram
            $table->text('alur_description')->nullable();

            // Tab Template
            $table->string('template_file_path')->nullable(); // Path file download
            $table->string('template_title')->default('Surat Pernyataan Publikasi');
            $table->string('template_info')->default('Format PDF - Ukuran: 150 KB');
            $table->text('template_instruction')->nullable();

            // Tab Watermark
            $table->string('watermark_file_path')->nullable(); // Path file download
            $table->string('watermark_title')->default('Logo POLBAN Watermark');
            $table->string('watermark_info')->default('Format PDF - Ukuran: Max 2 MB');
            $table->text('watermark_instruction')->nullable();

            $table->timestamps();
        });

        // 2. Tabel List Persyaratan
        Schema::create('bebas_masalah_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('sort_order')->default(0); // Untuk mengatur urutan
            $table->timestamps();
        });

        // 3. Tabel List Panduan
        Schema::create('bebas_masalah_guides', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: "1. Persiapan Dokumen"
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bebas_masalah_guides');
        Schema::dropIfExists('bebas_masalah_requirements');
        Schema::dropIfExists('bebas_masalah_settings');
    }
};
