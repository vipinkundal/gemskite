<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTableInwardEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inward_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('invoice_number')->nullable();
            $table->string('supplier');
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('inward_entry_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inward_entry_id');
            $table->foreign('inward_entry_id')->references('id')->on('inward_entries');
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
