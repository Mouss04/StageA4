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
        Schema::create('orateurs', function (Blueprint $table) {
            $table->id(); // Identifiant unique auto-incrémenté
            $table->string('nom_complet'); // Nom complet de l'orateur
            $table->text('biographie'); // Biographie (utiliser 'text' si la biographie est longue)
            $table->string('photo')->nullable(); // Colonne pour stocker le chemin ou l'URL de la photo
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orateurs'); // Suppression de la table en cas de rollback
    }
};
