<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            // ID sesi — string, bukan UUID
            $table->string('id')->primary();

            // UUID admin yang login (nullable karena tidak semua session harus punya user)
            $table->uuid('user_id')->nullable()->index();

            // IP dan user agent (default Laravel)
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            // Payload berisi data session yang diserialisasi oleh Laravel
            $table->longText('payload');

            // Waktu aktivitas terakhir (timestamp unix)
            $table->integer('last_activity')->index();

            // Relasi opsional ke tabel admin
            $table->foreign('user_id')
                ->references('id_admin')
                ->on('admin')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
