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
        Schema::create('aufpl_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('current_gameweek')->default(1);
            $table->boolean('transfer_window_open')->default(false);
            $table->boolean('squad_selection_open')->default(false);
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
        Schema::dropIfExists('aufpl_settings');
    }
};
