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
        Schema::create('cms_meta_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_meta_id')->constrained('cms_metas')->onDelete('cascade')->cascadeOnUpdate();
            $table->string('key')->nullable()->comment('such as image_url, height, width');
            $table->longText('value')->nullable()->comment('such as actual URL, height value, width value');
            $table->foreignId('parent_id')->nullable()->constrained('cms_meta_values')->onDelete('cascade')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_meta_values');
    }
};
