<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_journals', function (Blueprint $table) {
            // Hapus kolom gdrive_url yang lama
            if (Schema::hasColumn('e_journals', 'gdrive_url')) {
                $table->dropColumn('gdrive_url');
            }
            
            // Tambah kolom baru JSON untuk link tambahan (bisa null)
            $table->json('additional_links')->nullable()->after('url');
        });
    }

    public function down(): void
    {
        Schema::table('e_journals', function (Blueprint $table) {
            $table->dropColumn('additional_links');
            $table->string('gdrive_url')->nullable();
        });
    }
};