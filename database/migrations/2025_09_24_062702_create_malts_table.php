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
        Schema::create('malt', function (Blueprint $table) {
            $table->string('maltId')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('countryOfOrigin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malt');
    }
};
