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
        Schema::create('tblMatPickList', function (Blueprint $table) {
            $table->id('MatPickListID');
            $table->integer('MatPickID');
            $table->text('ItemNumber')->nullable();
            $table->text('ItemName')->nullable();
            $table->text('Uom')->nullable();
            $table->bigInteger('Qty')->nullable();
            $table->text('Notes')->nullable();
            $table->bigInteger('QtyMod')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblMatPickList');
    }
};
