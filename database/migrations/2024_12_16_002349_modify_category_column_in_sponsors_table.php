<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCategoryColumnInSponsorsTable extends Migration
{
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            // Modifier la colonne 'category' pour la transformer en type ENUM avec les catégories spécifiées
            $table->enum('category', [
                'Dispositifs médicaux',
                'Distributeurs pharmaceutiques',
                'Parapharmacie & phytothérapie',
                'Pharmacie hospitalière',
                'Édition',
                'Laboratoires pharmaceutiques',
                'Puériculture & lait infantile',
                'Services',
                'Fournisseurs industrie pharmaceutiques',
                'Institutions, corporations & partenaires sociaux',
            ])->nullable()->change(); // Ajout de nullable si vous souhaitez que cette colonne puisse être vide
        });
    }

    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            // Revenir à un type 'varchar' si besoin lors du rollback
            $table->string('category', 255)->nullable()->change();
        });
    }
}
