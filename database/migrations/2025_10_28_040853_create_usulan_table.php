<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usulan', function (Blueprint $table) {
            $table->uuid('usulan_id')->primary();
            $table->string('nama', 100);
            $table->string('identitas', 30)->comment('NIM atau NIP');
            $table->string('email', 150);
            $table->string('no_whatsapp', 20);
            $table->string('judul_buku', 255);
            $table->string('penulis_buku', 255);
            $table->text('alasan_usulan');
            $table->enum('status', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('updated_date')->nullable();
            $table->softDeletes('deleted_date', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan');
    }
};
