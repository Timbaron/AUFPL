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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('gameweek')->nullable();
            $table->longText('starters');
            $table->longText('subs');
            $table->string('captain');
            $table->string('vice_captain');
            $table->boolean('bench_boost')->default(false);
            $table->boolean('triple_captain')->default(false);
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
        Schema::dropIfExists('selections');
    }
};
