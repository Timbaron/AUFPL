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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('freehit')->after('password')->default(true);
            $table->boolean('wildcard')->after('freehit')->default(true);
            $table->boolean('bench_boost')->after('wildcard')->default(true);
            $table->integer('free_transfer')->after('bench_boost')->default(2);
            $table->boolean('triple_captain')->after('free_transfer')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
