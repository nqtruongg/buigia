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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('order')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('active')->default(1);
            $table->integer('hot')->default(0);
            $table->integer('parent_id')->nullable();
            $table->string('type')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('description_seo')->nullable();
            $table->string('title_seo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
