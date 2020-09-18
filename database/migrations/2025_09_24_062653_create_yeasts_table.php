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
        Schema::create('yeast', function (Blueprint $table) {
            $table->string('yeastId')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('yeastType')->nullable();
            $table->string('yeastFormat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeast');
    }
};
