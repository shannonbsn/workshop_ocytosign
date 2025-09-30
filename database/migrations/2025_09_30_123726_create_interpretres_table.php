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
        Schema::create('interpretres', function (Blueprint $table) {
            $table->id('id_interprete');
            $table->unsignedBigInteger('id_medecin');

            $table->foreign('id_medecin')->references('id_medecin')->on('medecins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interpretres');
    }
};
