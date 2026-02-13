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
        Schema::create('cms_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_id')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->string('meta_key')->nullable()->comment('such as banner_image');
            $table->longText('meta_value')->nullable()->comment('such as banner_image URL , HEIGHT,WIDTH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_metas');
    }
};
