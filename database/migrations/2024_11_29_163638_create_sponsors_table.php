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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id(); // Identifiant unique du sponsor
            $table->string('nom'); // Nom du sponsor
            $table->text('description')->nullable(); // Description du sponsor
            $table->string('logo')->nullable(); // Logo du sponsor (URL ou chemin de fichier)
            $table->string('fichier')->nullable(); // Fichier associé au sponsor (par exemple une brochure ou autre)
            $table->timestamps(); // Date de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
