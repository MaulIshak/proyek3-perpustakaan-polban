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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nim_nip');
            $table->string('email');
            $table->string('whatsapp');    
            $table->string('judul_buku');
            $table->string('pengarang');
            
            // Status: pending, approved, rejected, cancelled
            $table->string('status')->default('pending'); 
            
            // Alasan jika ditolak (nullable karena tidak semua ditolak)
            $table->text('rejection_reason')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_bukus');
    }
};
