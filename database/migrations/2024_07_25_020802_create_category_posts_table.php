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
        Schema::create('category_posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('image_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->text('description')->nullable();
            $table->string('description_seo', 255)->nullable();
            $table->string('keyword_seo', 255)->nullable();
            $table->string('title_seo', 255)->nullable();
            $table->longText('content')->nullable();
            $table->string('language', 50)->nullable();
            $table->tinyInteger('active')->nullable()->default(1);
            $table->tinyInteger('hot')->nullable()->default(0);
            $table->bigInteger('order')->nullable()->default(0);
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_posts');
    }
};
