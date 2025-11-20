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
        Schema::create('e_journals', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Untuk 'nama' (misal: Emerald Insight)
            $table->string('url');              // Untuk 'link' tujuan
            $table->string('subject');          // Untuk 'subjek' (misal: Ekonomi, Bisnis)
            $table->string('logo_path')->nullable(); // Path gambar setelah di-upload. Nullable karena ada jurnal tanpa logo.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_journals');
    }
};
