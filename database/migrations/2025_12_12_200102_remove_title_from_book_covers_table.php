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
    Schema::table('book_covers', function (Blueprint $table) {
        // Cek dulu apakah kolom 'title' ada
        if (Schema::hasColumn('book_covers', 'title')) {
            $table->dropColumn('title');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_covers', function (Blueprint $table) {
            // Mengembalikan kolom 'title' jika migrasi di-rollback
            $table->string('title')->nullable();
        });
    }
};