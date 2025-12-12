<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('e_journals', function (Blueprint $table) {
            $table->dropColumn(['url', 'gdrive_url']); // Hapus kolom lama
            $table->json('links')->nullable()->after('description'); // Kolom baru tipe JSON
        });
    }

    public function down()
    {
        Schema::table('e_journals', function (Blueprint $table) {
            $table->dropColumn('links');
            $table->string('url')->nullable();
            $table->string('gdrive_url')->nullable();
        });
    }
};
