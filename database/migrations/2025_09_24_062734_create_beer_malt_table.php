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
        Schema::create('beer_malt', function (Blueprint $table) {
            $table->id('beerMaltId');
            $table->string('beerId');
            $table->string('maltId');

            $table->foreign('beerId')->references('beerId')->on('beer')->onDelete('cascade');
            $table->foreign('maltId')->references('maltId')->on('malt')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beer_malt');
    }
};
