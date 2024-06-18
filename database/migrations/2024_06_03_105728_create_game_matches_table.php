<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams');
            $table->dateTime('date');
            $table->integer('placement');
            $table->integer('kills');
            $table->integer('damage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_matches');
    }
};
