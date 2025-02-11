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
        Schema::table('users', function (Blueprint $table) {
            // Renommer les colonnes existantes
            $table->renameColumn('name', 'nom_complet');
            $table->renameColumn('password', 'motdepasse');

            // Ajouter les nouvelles colonnes
            $table->string('surnom')->nullable(); // Colonne facultative pour le surnom
            $table->string('photo')->nullable(); // Colonne facultative pour le chemin de la photo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revenir en arrière (rollback)
            $table->renameColumn('nom_complet', 'name');
            $table->renameColumn('motdepasse', 'password');
            $table->dropColumn(['surnom', 'photo']);
        });
    }
};
