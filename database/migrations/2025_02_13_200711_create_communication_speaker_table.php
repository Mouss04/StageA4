<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('communication_speaker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_id')->constrained('communications')->onDelete('cascade');
            $table->foreignId('speaker_id')->constrained('speakers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communication_speaker');
    }
};
