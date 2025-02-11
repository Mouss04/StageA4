<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrateurSessiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orateur_sessi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sessi_id')->constrained('sessis')->onDelete('cascade');
            $table->foreignId('orateur_id')->constrained('orateurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orateur_sessi');
    }
}
