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

        Schema::create('admin', function (Blueprint $table) {
            $table->uuid('id_admin')->primary();
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('updated_date')->nullable();
            $table->softDeletes('deleted_date', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
