<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTableSuppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('firm_name');
            $table->string('city');
            $table->string('state');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('gst_details');
            $table->timestamps();
        });
    }
}
