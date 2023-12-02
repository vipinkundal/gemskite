<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('date');
            $table->string('mobile_number');
            $table->string('address');
            $table->string('state');
            $table->string('country');
            $table->string('type');
            $table->string('opening_balance');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }
};
