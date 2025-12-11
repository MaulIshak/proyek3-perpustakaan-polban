<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. HAPUS TABEL LAMA (CLEANUP)
        // Kita hapus semua kemungkinan tabel lama agar bersih
        Schema::dropIfExists('bebas_masalah_guides');      // Hapus tabel guides (list lama)
        Schema::dropIfExists('bebas_masalah_requirements');// Hapus tabel requirements (list lama)
        Schema::dropIfExists('bebas_masalah_settings');    // Hapus settings lama

        // 2. BUAT TABEL BARU (SINGLE TABLE)
        Schema::create('bebas_masalah_settings', function (Blueprint $table) {
            $table->id();
            
            // ALUR
            $table->string('alur_image_path')->nullable();
            $table->text('alur_description')->nullable();

            // PERSYARATAN (Single Row)
            $table->string('requirement_file_path')->nullable(); 
            $table->text('requirement_description')->nullable(); 

            // PANDUAN (Single Row)
            $table->string('guide_file_path')->nullable(); 
            $table->text('guide_description')->nullable(); 

            // TEMPLATE
            $table->string('template_file_path')->nullable();
            $table->string('template_title')->default('Surat Pernyataan Publikasi');
            $table->string('template_info')->default('Format PDF - Ukuran: 150 KB');
            $table->text('template_instruction')->nullable();

            // WATERMARK
            $table->string('watermark_file_path')->nullable();
            $table->string('watermark_title')->default('Logo POLBAN Watermark');
            $table->string('watermark_info')->default('Format PDF - Ukuran: Max 2 MB');
            $table->text('watermark_instruction')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bebas_masalah_settings');
    }
};