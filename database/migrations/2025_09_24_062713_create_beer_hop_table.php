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
        Schema::create('beer_hop', function (Blueprint $table) {
            $table->id('beerHopId');
            $table->string('beerId');
            $table->string('hopId');

            $table->foreign('beerId')->references('beerId')->on('beer')->onDelete('cascade');
            $table->foreign('hopId')->references('hopId')->on('hop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beer_hop');
    }
};
