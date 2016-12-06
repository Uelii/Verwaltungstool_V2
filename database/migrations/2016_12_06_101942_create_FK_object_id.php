<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFKObjectId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renter', function (Blueprint $table) {
            $table->integer('object_id')->unsigned();
        });

        Schema::table('renter', function (Blueprint $table) {
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renter', function (Blueprint $table) {
            $table->dropForeign('renter_object_id_foreign');
            $table->dropColumn('object_id');
        });
    }
}
