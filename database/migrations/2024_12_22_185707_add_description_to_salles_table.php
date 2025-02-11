<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToSallesTable extends Migration
{
    public function up()
    {
        Schema::table('salles', function (Blueprint $table) {
            $table->text('description')->nullable(); // Ajoute la colonne description, de type texte et nullable
        });
    }

    public function down()
    {
        Schema::table('salles', function (Blueprint $table) {
            $table->dropColumn('description'); // Supprime la colonne description si la migration est annulée
        });
    }
}
