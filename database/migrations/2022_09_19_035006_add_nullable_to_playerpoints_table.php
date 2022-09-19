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
        Schema::table('player_points', function (Blueprint $table) {
            $table->boolean('yellow_card')->nullable()->change();
            $table->boolean('red_card')->nullable()->change();
            $table->boolean('motm')->nullable()->change();
            $table->integer('goal')->nullable()->change();
            $table->integer('assist')->nullable()->change();
            $table->boolean('cleansheet')->nullable()->change();
            $table->integer('own_goal')->nullable()->change();
            $table->integer('penalty_missed')->nullable()->change();
            $table->integer('penalty_saved')->nullable()->change();
            $table->integer('saves')->nullable()->change();
            $table->integer('goals_conceded')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playerpoints', function (Blueprint $table) {
            //
        });
    }
};
