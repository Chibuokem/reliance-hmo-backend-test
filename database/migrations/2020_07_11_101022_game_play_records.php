<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GamePlayRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('game_play_records', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->bigInteger('player_id');
            $table->string('type');
            $table->json('invites')->nullable();
            $table->json('invites_scores')->nullable();
            $table->integer('score')->default(0);
            $table->timestamp('date_played');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_play_records');
    }
}