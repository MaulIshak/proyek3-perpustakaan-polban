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
        Schema::create('photos', function (Blueprint $table) {
            $table->uuid('foto_id')->primary();
            $table->string('url_foto', 255);
            $table->integer('size')->nullable()->comment('Ukuran file dalam KB');
            $table->enum('tipe', ['galeri', 'cover_buku'])->default('galeri');
            $table->timestamp('created_date')->useCurrent();
            $table->softDeletes('deleted_date', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
