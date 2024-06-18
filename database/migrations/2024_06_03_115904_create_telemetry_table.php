<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('telemetry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('game_matches');
            $table->foreignId('player_id')->constrained('players');
            $table->string('event_type');
            $table->foreignId('target_player_id')->nullable()->constrained('players');
            $table->timestamp('timestamp');
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telemetry');
    }
};
