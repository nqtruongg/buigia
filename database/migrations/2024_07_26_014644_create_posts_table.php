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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('description_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('title_seo')->nullable();
            $table->longText('content')->nullable();
            $table->string('image_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->integer('view')->nullable();
            $table->tinyInteger('active')->nullable()->default(1);
            $table->tinyInteger('hot')->nullable()->default(0);
            $table->bigInteger('order')->nullable()->default(0);
            $table->foreignId('category_id')->constrained('category_posts')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->bigInteger('setting_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
