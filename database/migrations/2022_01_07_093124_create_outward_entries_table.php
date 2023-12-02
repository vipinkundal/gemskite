<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutwardEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outward_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('voucher_number');
            $table->string('dealer_name');
            $table->string('firm_name');
            $table->string('city');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('outward_entry_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outward_entry_id');
            $table->foreign('outward_entry_id')->references('id')->on('outward_entries');
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
            $table->text('description');
            $table->timestamps();
        });
    }
}
