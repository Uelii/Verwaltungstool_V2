<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStreetNumberBuildings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('street_number');
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->string('street_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('street_number');
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->integer('street_number');
        });
    }
}
