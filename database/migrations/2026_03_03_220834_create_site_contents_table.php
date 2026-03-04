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
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page');          // 'beranda', 'tentang', 'fitur', 'global', 'seo'
            $table->string('section');       // 'hero_title', 'hero_subtitle', dll
            $table->string('type')->default('text'); // 'text', 'textarea', 'image', 'url'
            $table->text('value')->nullable();
            $table->string('label');         // Label tampilan di form: "Judul Hero"
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->unique(['page', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
