<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnumOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_type');
        });

        Schema::table('invoices', function(Blueprint $table){
            $table->enum('invoice_type', ['Repair', 'Oil', 'Water', 'Power', 'Caretaker', 'Other']);
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
            $table->dropColumn('invoice_type');
        });

        Schema::table('invoices', function(Blueprint $table){
            $table->enum('invoice_type', ['Repair', 'Oil', 'Water', 'Power', 'Caretaker']);
        });
    }
}
