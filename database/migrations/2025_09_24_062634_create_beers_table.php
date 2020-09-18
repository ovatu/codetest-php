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
        Schema::create('beer', function (Blueprint $table) {
            $table->string('beerId')->primary();
            $table->string('styleId')->nullable();
            $table->string('name');
            $table->integer('abv')->nullable();
            $table->integer('ibu')->nullable();
            $table->integer('isOrganic')->nullable();
            $table->integer('year')->nullable();

            $table->foreign('styleId')->references('styleId')->on('style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beer');
    }
};
