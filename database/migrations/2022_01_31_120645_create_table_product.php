<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku');
            $table->string('stone_name');
            $table->string('shape')->nullable();
            $table->string('size')->nullable();
            $table->string('piece')->nullable();
            $table->string('gross_weight');
            $table->string('s_w');
            $table->string('line');
            $table->string('net_weight');
            $table->string('price');
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
}
