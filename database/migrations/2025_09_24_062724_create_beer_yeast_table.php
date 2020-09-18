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
        Schema::create('beer_yeast', function (Blueprint $table) {
            $table->id('beerYeastId');
            $table->string('beerId');
            $table->string('yeastId');

            $table->foreign('beerId')->references('beerId')->on('beer')->onDelete('cascade');
            $table->foreign('yeastId')->references('yeastId')->on('yeast')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beer_yeast');
    }
};
