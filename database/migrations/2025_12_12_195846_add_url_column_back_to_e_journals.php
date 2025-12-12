<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_journals', function (Blueprint $table) {
            // Tambahkan ->nullable() ATAU ->default('')
            // Ini agar data lama otomatis terisi string kosong/placeholder
            if (!Schema::hasColumn('e_journals', 'url')) {
                $table->string('url')->default('#')->after('name'); 
            }
            
            if (Schema::hasColumn('e_journals', 'links')) {
                $table->dropColumn('links');
            }
        });
    }

    public function down(): void
    {
        Schema::table('e_journals', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};