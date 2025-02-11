<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToCommunications extends Migration
{
    public function up()
    {
        Schema::table('communications', function (Blueprint $table) {
            // Ajouter une contrainte d'unicité sur titre, date et session
            $table->unique(['titre', 'date', 'sessis_id']);
        });
    }

    public function down()
    {
        Schema::table('communications', function (Blueprint $table) {
            // Supprimer la contrainte d'unicité
            $table->dropUnique(['titre', 'date', 'sessis_id']);
        });
    }
}
