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
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // ID unique de la question
            $table->text('contenu'); // Contenu de la question
            $table->text('reponse')->nullable(); // Réponse à la question (optionnelle)
            $table->enum('statut', [
                'en_attente',  // Question en attente de validation
                'validée',     // Question validée par le staff
                'rejetée',     // Question rejetée par le staff
                'traitée'      // Question traitée (répondue)
            ])->default('en_attente'); // Par défaut, la question est en attente
            $table->foreignId('user_id') // Utilisateur ayant posé la question
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('communication_id') // Communication associée
                ->constrained('communications')
                ->onDelete('cascade');
            $table->foreignId('orateur_id') // Orateur responsable de la réponse
                ->nullable() // L'orateur peut ne pas être défini immédiatement
                ->constrained('orateurs')
                ->onDelete('set null'); // Si l'orateur est supprimé, mettre la relation à null
            $table->timestamps(); // Dates de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
