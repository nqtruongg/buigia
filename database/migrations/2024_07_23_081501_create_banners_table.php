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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->integer('share_id')->nullable();
            $table->string('language')->nullable();
            $table->string('link')->nullable();
            $table->tinyInteger('hot')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->integer('order')->default(0);
            $table->string('description')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
