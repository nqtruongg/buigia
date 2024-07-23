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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('email', 255)->unique();
            $table->string('tax_code', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('type');
            $table->string('invoice_address', 255)->nullable();
            $table->string('service', 255)->nullable();
            $table->string('responsible_person', 255)->nullable();
            $table->integer('created_by');
            $table->integer('update_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
