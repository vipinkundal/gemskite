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
        Schema::table('inward_entry_items', function (Blueprint $table) {
            $table->string('line')->nullable()->change();
            $table->string('s_w')->nullable()->change();
            $table->string('gross_weight')->nullable()->change();
            $table->string('net_weight')->nullable()->change();
            $table->string('price')->nullable()->change();
            $table->string('description')->nullable()->change();
        });

        Schema::table('outward_entry_items', function (Blueprint $table) {
            $table->string('line')->nullable()->change();
            $table->string('s_w')->nullable()->change();
            $table->string('gross_weight')->nullable()->change();
            $table->string('net_weight')->nullable()->change();
            $table->string('price')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }
};
