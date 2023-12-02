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
        Schema::table('dealers', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('gst_details')->nullable()->change();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('gst_details')->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('net_weight')->nullable()->change();
        });
    }
};
