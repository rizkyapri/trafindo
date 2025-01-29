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
        Schema::create('tblWO', function (Blueprint $table) {
            $table->id();
            $table->string('WONumber')->nullable();
            $table->string('WOName')->nullable();
            $table->text('WODescription')->nullable();
            $table->date('WOBeginDate')->default(now());
            $table->date('WOEndDate')->default(now());
            $table->integer('WOStatus')->nullable();
            $table->integer('IDMFG')->nullable();
            $table->string('WOnborig')->nullable();
            $table->string('FGnborig')->nullable();
            $table->string('BOMnborig')->nullable();
            $table->float('WOqty')->nullable();
            $table->string('WOnote')->nullable();
            // $table->string('BOM')->default('0');
            // $table->string('BRG')->default('0');
            // $table->integer('qty')->default('0');
            // $table->string('stn')->nullable();
            // $table->string('wc')->default('0');
            // $table->integer('MatPickID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblWO');
    }
};
