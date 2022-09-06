<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_points', function (Blueprint $table) {
            $table->id();
            $table->string('player_id');
            $table->integer('gameweek')->nullable();
            $table->integer('minutes')->default(0);
            $table->boolean('yellow_card');
            $table->boolean('red_card');
            $table->boolean('motm');
            $table->integer('goal');
            $table->integer('assist');
            $table->boolean('cleansheet');
            $table->integer('own_goal');
            $table->integer('penalty_missed');
            $table->integer('penalty_saved');
            $table->integer('saves');
            $table->integer('goals_conceded');
            $table->softDeletes();
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
        Schema::dropIfExists('player_points');
    }
};
