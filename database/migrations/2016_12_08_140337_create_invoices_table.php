<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned();
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
            $table->double('amount');
            $table->date('invoice_date');
            $table->date('payable_until');
            $table->boolean('is_paid');
            $table->enum('invoice_type', ['Repair', 'Oil', 'Water', 'Power', 'Caretaker']);
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
        Schema::table('invoices', function (Blueprint $table) {
            Schema::drop('invoices');
        });
    }
}
