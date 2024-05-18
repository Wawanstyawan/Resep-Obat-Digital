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
        Schema::create('resep_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resep_id');
            $table->unsignedBigInteger('obatalkes_id');
            $table->unsignedBigInteger('signa_id');
            $table->integer('qty');
            $table->foreign('resep_id')->references('id')->on('reseps');
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_details');
    }
};
