<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renter', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('title', ['Mr.', 'Ms.']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_landline')->nullable();
            $table->string('phone_mobile_phone')->nullable();
            $table->string('street');
            $table->integer('street_number');
            $table->integer('zip_code');
            $table->string('city');
            $table->boolean('is_main_domicile');
            $table->date('beginning_of_contract');
            $table->date('end_of_contract')->nullable();
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
        Schema::drop('renter');
    }
}
