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
        Schema::table('bookings', function (Blueprint $table) {
            // Kita tambahkan kolom deadline yang boleh kosong (nullable)
            // 'after' hanya visual di MySQL, di PostgreSQL urutan kolom tidak bisa diubah,
            // tapi tetap aman ditulis.
            $table->dateTime('deadline')->nullable()->after('rejection_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Ini untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('deadline');
        });
    }
};