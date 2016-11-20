<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectRenterJunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_renter', function (Blueprint $table) {
            $table->integer('FK_object_id')->unsigned();
            $table->foreign('FK_object_id')->references('id')->on('objects')->onDelete('restrict');
            $table->integer('FK_renter_id')->unsigned();
            $table->foreign('FK_renter_id')->references('id')->on('renter')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('object_renter');
    }
}
