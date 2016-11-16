<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangsInObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->dropColumn('size');
            $table->dropColumn('room');

            $table->double('living_space');
            $table->double('number_of_rooms');
            $table->double('floor_room_number');
            $table->double('rent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->integer('size');
            $table->double('room');

            $table->dropColumn('living_space');
            $table->dropColumn('number_of_rooms');
            $table->dropColumn('floor_room_number');
            $table->dropColumn('rent');
        });
    }
}
