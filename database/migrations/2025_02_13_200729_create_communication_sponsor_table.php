<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('communication_sponsor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_id')->constrained('communications')->onDelete('cascade');
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communication_sponsor');
    }
};
