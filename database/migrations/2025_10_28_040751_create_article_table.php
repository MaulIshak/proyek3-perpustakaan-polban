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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('article_id')->primary();
            $table->string('url_thumbnail')->nullable();
            $table->string('url_attachment')->nullable();
            $table->string('judul', 255);
            $table->text('content');
            $table->enum('type', ['berita', 'pengumuman'])->default('berita');
            $table->enum('status', ['published', 'draft'])->default('draft');
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
        Schema::dropIfExists('articles');
    }
};
