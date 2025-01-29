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
        Schema::create('tblAndonNo', function (Blueprint $table) {
            $table->id();
            $table->string('Andon_No')->nullable();
            $table->string('Andon_Color')->nullable() ;
            $table->string('Workcenter')->nullable();
            $table->string('CodeAndon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblAndonNo');
    }
};
