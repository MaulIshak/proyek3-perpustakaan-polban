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
        Schema::create('team_manajemen', function (Blueprint $table) {
            $table->id('id_team')->primary();
            $table->string('nama', 100);
            $table->string('jabatan', 100);
            $table->string('gelar', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_manajemen');
    }
};
