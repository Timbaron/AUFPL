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
            $table->string('gameweek');
            $table->integer('minutes')->default(0);
            $table->string('yellow_card');
            $table->string('red_card');
            $table->string('motm');
            $table->string('goal');
            $table->string('assist');
            $table->string('cleansheet');
            $table->string('own_goal');
            $table->string('penalty_missed');
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
