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
        Schema::create('category_services', function (Blueprint $table) {
            $table->id(); // Đây sẽ là khóa chính tự động tăng giá trị
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('share_id')->nullable(); // Đã loại bỏ tự động tăng giá trị khỏi cột này
            $table->string('image_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('hot')->default(0);
            $table->integer('order')->default(0);
            $table->string('description')->nullable();
            $table->string('content')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('title_seo')->nullable();
            $table->string('description_seo')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('category_services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_services');
    }
};
