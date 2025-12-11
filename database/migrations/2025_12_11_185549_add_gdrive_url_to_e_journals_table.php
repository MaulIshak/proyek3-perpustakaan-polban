<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('e_journals', function (Blueprint $table) {
            // Menambahkan kolom gdrive_url setelah kolom url, boleh kosong (nullable)
            $table->string('gdrive_url')->nullable()->after('url');
        });
    }

    public function down()
    {
        Schema::table('e_journals', function (Blueprint $table) {
            $table->dropColumn('gdrive_url');
        });
    }
};
