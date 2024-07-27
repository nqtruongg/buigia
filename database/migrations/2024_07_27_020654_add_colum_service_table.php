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
        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('image_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->integer('acreage');
            $table->integer('numberBedroom')->nullable();
            $table->integer('toilet')->nullable();
            $table->string('direction')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('householder_id');
            $table->unsignedBigInteger('category_id');
            $table->string('order')->default(0)->nullable();
            $table->text('content')->nullable();
            $table->integer('active')->default(1);
            $table->integer('hot')->default(0);
            $table->string('keyword_seo')->nullable();
            $table->string('description_seo')->nullable();
            $table->string('title_seo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->dropColumn('banner_path');
            $table->dropColumn('acreage');
            $table->dropColumn('numberBedroom');
            $table->dropColumn('toilet');
            $table->dropColumn('direction');
            $table->dropColumn('area_id');
            $table->dropColumn('householder_id');
        });
    }
};
