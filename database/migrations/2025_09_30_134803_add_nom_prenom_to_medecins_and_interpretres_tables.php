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
        Schema::table('medecins', function (Blueprint $table) {
            $table->string('nom')->after('id_medecin');
            $table->string('prenom')->after('nom');
        });

        Schema::table('interpretres', function (Blueprint $table) {
            $table->string('nom')->after('id_interprete');
            $table->string('prenom')->after('nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom']);
        });

        Schema::table('interpretres', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom']);
        });
    }
};
