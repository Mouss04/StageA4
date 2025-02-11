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
        Schema::create('communications', function (Blueprint $table) {
            $table->id(); // ID unique de la communication
            $table->string('titre'); // Titre de la communication
            $table->text('description')->nullable(); // Description de la communication
            $table->date('date'); // Date de la communication
            $table->time('heure_debut'); // Heure de début
            $table->time('heure_fin'); // Heure de fin
            $table->enum('type', ['communication', 'symposium', 'atelier', 'pause', 'discours', 'debat'])->default('communication'); // Type de la communication
            $table->foreignId('sessis_id') // ID de la session associée
                ->constrained('sessis')
                ->onDelete('cascade'); // Suppression en cascade
            $table->foreignId('salle_id') // ID de la salle associée
                ->constrained('salles')
                ->onDelete('cascade'); // Suppression en cascade
            $table->timestamps(); // Dates de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
