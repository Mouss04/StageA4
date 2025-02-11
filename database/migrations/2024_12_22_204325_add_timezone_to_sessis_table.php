<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimezoneToSessisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessis', function (Blueprint $table) {
            // Ajouter un champ 'timezone' pour stocker le fuseau horaire de la session
            $table->string('timezone')->default('UTC'); // Par défaut, 'UTC' si le fuseau horaire n'est pas défini
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessis', function (Blueprint $table) {
            // Supprimer le champ 'timezone' en cas de rollback de la migration
            $table->dropColumn('timezone');
        });
    }
}
